#!/bin/bash

# Script pour traiter les emails en queue
# Usage: ./process-emails.sh

echo "=== TRAITEMENT DES EMAILS EN QUEUE ==="
echo ""

# Vérifier combien d'emails sont en attente
JOBS_COUNT=$(php artisan tinker --execute="echo \DB::table('jobs')->count();" 2>/dev/null | tail -1)

echo "📧 Jobs en attente: $JOBS_COUNT"

if [ "$JOBS_COUNT" -eq "0" ]; then
    echo "✅ Aucun email en attente"
    exit 0
fi

echo ""
echo "🚀 Traitement en cours..."
echo ""

# Traiter tous les jobs
php artisan queue:work --stop-when-empty

echo ""
echo "✅ Tous les emails ont été traités!"
echo ""

# Vérifier qu'il n'en reste plus
JOBS_AFTER=$(php artisan tinker --execute="echo \DB::table('jobs')->count();" 2>/dev/null | tail -1)
FAILED_JOBS=$(php artisan tinker --execute="echo \DB::table('failed_jobs')->count();" 2>/dev/null | tail -1)

echo "📊 État final:"
echo "   Jobs restants: $JOBS_AFTER"
echo "   Jobs échoués: $FAILED_JOBS"
