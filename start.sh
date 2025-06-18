#!/bin/bash

# Démarrage de docker compose en arrière-plan
cd backEnd/docker
docker compose up &
DOCKER_PID=$!

# Démarrage des autres services
cd ..
composer start &
COMPOSER_PID=$!

cd ../frontEnd
npm start &
FRONT_PID=$!

# Quand on fait Ctrl+C, tout s'arrête proprement
trap "echo 'Stopping...'; pkill -TERM -P $COMPOSER_PID; pkill -TERM -P $FRONT_PID; cd ../backEnd/docker && docker compose down; kill $DOCKER_PID; exit" SIGINT

# Attendre que tous les processus soient terminés
wait
