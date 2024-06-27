#!/bin/bash

# Ensure the correct number of arguments are provided
if [ "$#" -ne 2 ]; then
    echo "Usage: $0 WORKING_DIRECTORY USER"
    exit 1
fi

# Define the variables
WORKING_DIRECTORY=$1
USER=$2
GROUP="docker"

# Path to the template and target service file
TEMPLATE_FILE="./templates/docker-registry.service"
TARGET_FILE="/etc/systemd/system/docker-registry.service"

# Check if the template file exists
if [ ! -f "$TEMPLATE_FILE" ]; then
    echo "Template file not found: $TEMPLATE_FILE"
    exit 1
fi

# Substitute the placeholders with actual values and copy to the target location
sed -e "s|{{WORKDIR}}|$WORKDIR|g" \
    -e "s|{{USER}}|$USER|g" \
    $TEMPLATE_FILE | sudo tee $TARGET_FILE > /dev/null

# Set permissions and reload systemd
sudo chmod 644 $TARGET_FILE
sudo systemctl daemon-reload

# Enable and start the service
sudo systemctl enable docker-registry
sudo systemctl start docker-registry

# Check the status
sudo systemctl status docker-registry.service
