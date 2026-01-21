#!/bin/bash

# Script pour modifier le php.ini système et augmenter les limites d'upload
# Nécessite les droits sudo
# Usage: sudo ./fix-php-ini.sh

echo "🔧 Modification du fichier php.ini système..."
echo ""
echo "Fichier: /etc/php/8.4/cli/php.ini"
echo ""

# Vérifier les valeurs actuelles
echo "📋 Valeurs AVANT modification:"
echo "─────────────────────────────────────"
grep "^upload_max_filesize" /etc/php/8.4/cli/php.ini
grep "^post_max_size" /etc/php/8.4/cli/php.ini
grep "^max_execution_time" /etc/php/8.4/cli/php.ini
echo ""

# Demander confirmation
read -p "Voulez-vous appliquer les modifications? (y/N) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    echo "❌ Annulé"
    exit 1
fi

# Créer une sauvegarde
echo "💾 Création d'une sauvegarde..."
cp /etc/php/8.4/cli/php.ini /etc/php/8.4/cli/php.ini.backup.$(date +%Y%m%d_%H%M%S)
echo "✅ Sauvegarde créée"
echo ""

# Modifier les valeurs
echo "✏️  Application des modifications..."
sed -i 's/^upload_max_filesize = 2M/upload_max_filesize = 512M/' /etc/php/8.4/cli/php.ini
sed -i 's/^post_max_size = 8M/post_max_size = 512M/' /etc/php/8.4/cli/php.ini
sed -i 's/^max_execution_time = 30/max_execution_time = 600/' /etc/php/8.4/cli/php.ini

echo "✅ Modifications appliquées"
echo ""

# Afficher les nouvelles valeurs
echo "📋 Valeurs APRÈS modification:"
echo "─────────────────────────────────────"
grep "^upload_max_filesize" /etc/php/8.4/cli/php.ini
grep "^post_max_size" /etc/php/8.4/cli/php.ini
grep "^max_execution_time" /etc/php/8.4/cli/php.ini
echo ""

echo "✅ Terminé!"
echo ""
echo "🔄 Redémarrez le serveur Laravel pour appliquer les changements:"
echo "   1. Ctrl+C (arrêter le serveur)"
echo "   2. ./serve.sh (redémarrer)"
