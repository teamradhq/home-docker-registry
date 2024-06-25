usage() {
  echo "Usage:"
  echo " $0 <directory> <owner>"
  exit 1
}

if [ -z "$1" ]
  then WORKDIR=$(cwd)
  else WORKDIR="$1"
fi

WORKDIR=$(realpath "$WORKDIR")

if [ ! -f "$WORKDIR/docker-compose.yml" ]; then
  echo "Error: $WORKDIR/docker-compose.yml does not exist."
  usage
fi

if [ -z "$2" ]
  then OWNER="$USER"
  else OWNER="$2"
fi

if [ -z "$OWNER" ]; then
  echo "Error: Could not determine the owner to set."
  usage
fi

TEMPLATE_FILE="$WORKDIR/templates/docker-registry.service"
TARGET_FILE="/etc/systemd/system/docker-registry.service"

sed -e "s|{{WORKDIR}}|$WORKDIR|g" \
    -e "s|{{USER}}|$USER|g" \
    -e "s|{{GROUP}}|$GROUP|g" \
    "$TEMPLATE_FILE" | sudo tee "$TARGET_FILE" > /dev/null

sudo chmod 644 "$TARGET_FILE"
sudo usermod -aG docker "$OWNER"
sudo systemctl daemon-reload
sudo systemctl enable docker-registry
sudo systemctl start docker-registry

