#!/bin/bash

# Script pour démarrer le serveur Laravel avec des limites d'upload augmentées
# Usage: ./serve.sh

echo "Démarrage du serveur Laravel avec configuration PHP personnalisée..."
php -c php-dev.ini artisan serve --host=0.0.0.0 --port=8000
