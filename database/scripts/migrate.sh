#!/bin/bash

# Activer le mode maintenance
php artisan down --message="Mise à jour de la base de données en cours. Veuillez patienter..."

# Exécuter les migrations
php artisan migrate --force

# Désactiver le mode maintenance
php artisan up

echo "Migrations terminées avec succès !"
