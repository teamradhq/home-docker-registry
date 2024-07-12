#!/usr/bin/env bash

# Check if the docker compose php service is running
run_in_php() {
  if [ "$(docker ps -q -f name=php)" ]; then
      PHP_RUNNING=true
      echo "PHP is running."
  else
      PHP_RUNNING=false
      docker compose up -d --build php
  fi

  docker compose exec php "$@"

  if [ "$PHP_RUNNING" = false ]; then
      docker compose down php
  fi
}

