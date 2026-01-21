#!/bin/bash

# Script pour démarrer le serveur Laravel avec configuration PHP personnalisée
# Usage: ./serve.sh

echo "🚀 Démarrage du serveur Laravel avec configuration PHP personnalisée..."
echo "📁 Projet: Colibri Littéraire"
echo "⚙️  Configuration: php-dev.ini (512M upload, 1024M memory)"
echo ""
echo "Limites configurées:"
echo "  - upload_max_filesize: 512M"
echo "  - post_max_size: 512M"
echo "  - memory_limit: 1024M"
echo "  - max_execution_time: 600s"
echo ""
echo "🌐 Serveur accessible sur: http://0.0.0.0:8000"
echo "🌐 Ou sur: http://localhost:8000"
echo ""
echo "Appuyez sur Ctrl+C pour arrêter le serveur"
echo "─────────────────────────────────────────────────────"
echo ""

# Démarrer le serveur avec la configuration personnalisée
php -c php-dev.ini artisan serve --host=0.0.0.0 --port=8000
