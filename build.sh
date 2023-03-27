#!/bin/bash

printMessage() {
  echo -e "\e[92m\e[1m$1 \e[0m"
}

cd docker/

DOCKER_APP_CONTAINER_COMMAND="docker exec -it bidcalculator-app"

printMessage "Building docker containers..."

docker compose up -d

printMessage "Running composer install..."

$DOCKER_APP_CONTAINER_COMMAND composer install
