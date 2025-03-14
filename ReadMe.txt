Установить все зависимости проекта:
composer install

Создать базу данных:
mysql -u root -p < path_to_database.sql

Настроить .env файл для работы с локальной базой данных:

DB_CONNECTION=mysql
DB_HOST=MySQL-8.2
DB_PORT=3306
DB_DATABASE=diplom
DB_USERNAME=root
DB_PASSWORD=

php artisan serve
