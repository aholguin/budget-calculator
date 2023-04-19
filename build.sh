#!/bin/bash

printMessage() {
  echo -e "\e[92m\e[1m$1 \e[0m"
}

cd docker/

DOCKER_APP_CONTAINER_COMMAND="docker exec -it bidcalculator-app"

printMessage "Building docker containers..."

if [ $(docker compose version --short) ]; then
    docker compose up -d
else
    docker-compose up -d
fi

printMessage "Running composer install..."

$DOCKER_APP_CONTAINER_COMMAND composer install
