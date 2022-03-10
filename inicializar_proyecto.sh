echo "Generando BBDD y usuario dev..."
# Borrar usuario si existe
mysql -e "DROP USER IF EXISTS 'dev'@'localhost'";
mysql -e "FLUSH PRIVILEGES";
# Crear BBDD si no existe (creamos BD proyecto y hosteleria por si se indica una u otra en el .env)
mysql -e "CREATE DATABASE IF NOT EXISTS proyecto";
mysql -e "CREATE DATABASE IF NOT EXISTS proyecto";
# Creamos usuario dev para el desarrollo en local
mysql -e "CREATE USER 'dev'@'localhost' IDENTIFIED BY '12345Abcde'";
mysql -e "GRANT ALL PRIVILEGES ON proyecto.* TO 'dev'@'localhost'";
# Y le damos permisos
mysql -e "GRANT ALL PRIVILEGES ON hosteleria.* TO 'dev'@'localhost'";
mysql -e "FLUSH PRIVILEGES";
echo "BBDD y usuario dev creados con éxito"
echo "Accediendo al proyecto..."
# Accedemos a la ruta del script
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
cd $SCRIPT_DIR
echo "Acceso realizado con éxito"
echo "Ejecutando migraciones y seeding..."
# Ejecutamos las migraciones y el seeding
php artisan migrate:fresh --seed
echo "Migraciones y seeding ejecutados correctamente"
echo "Optimizando rutas y limpiando cachés..."
php artisan optimize
echo "Proceso finalizado con éxito"