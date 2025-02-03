#!/bin/bash
# wait-for-db.sh

until nc -z -v -w30 db 3306
do
  echo "Esperando a que MySQL esté listo..."
  sleep 1
done

echo "MySQL está listo, ejecutando migraciones..."
php artisan migrate
