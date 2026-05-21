#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "==========================================="
echo " Starting Server Setup for LibraVerse"
echo "==========================================="

# 1. Update system packages
echo "--> Updating package lists..."
sudo apt update -y

# 2. Install Nginx, PHP, Git, Unzip, Composer
echo "--> Installing Nginx, Git, Composer, PHP 8.3, and extensions..."
sudo apt install -y nginx git unzip composer \
    php-fpm php-cli php-sqlite3 php-mbstring \
    php-xml php-curl php-zip

# 3. Setup application directory variables
PROJECT_DIR="$(pwd)"
echo "--> Current project directory: $PROJECT_DIR"

# 4. Copy .env if not exists
if [ ! -f .env ]; then
    echo "--> Creating .env file from .env.example..."
    cp .env.example .env
    # Set APP_ENV and DB_CONNECTION in the .env file
    sed -i 's/APP_ENV=local/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
    sed -i 's/DB_CONNECTION=sqlite/# DB_CONNECTION=sqlite/' .env # disable default comment
    echo "DB_CONNECTION=sqlite" >> .env
else
    echo "--> .env file already exists."
fi

# 5. Create SQLite database file
if [ ! -f database/database.sqlite ]; then
    echo "--> Creating SQLite database file..."
    touch database/database.sqlite
else
    echo "--> SQLite database file already exists."
fi

# 6. Install PHP Composer dependencies
echo "--> Installing composer dependencies (no-dev, optimized)..."
composer install --no-dev --optimize-autoloader

# 7. Generate App Key if not set
if ! grep -q "APP_KEY=base64:" .env || [ -z "$(grep APP_KEY= .env | cut -d= -f2)" ]; then
    echo "--> Generating application key..."
    php artisan key:generate --ansi
else
    echo "--> Application key already set."
fi

# 8. Run migrations and database seeding
echo "--> Running migrations and seeders..."
php artisan migrate --force --seed --ansi

# 9. Configure Nginx Server Block
echo "--> Configuring Nginx server block..."
NGINX_CONF="/etc/nginx/sites-available/libraverse"
sudo cp nginx.conf.example "$NGINX_CONF"

# Replace server_name in the Nginx configuration with public IP if possible
PUBLIC_IP=$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4 || echo "_")
if [ -n "$PUBLIC_IP" ] && [ "$PUBLIC_IP" != "_" ]; then
    echo "--> Detected EC2 Public IP: $PUBLIC_IP. Setting in Nginx config..."
    sudo sed -i "s/server_name _;/server_name $PUBLIC_IP;/" "$NGINX_CONF"
fi

# Link configuration to sites-enabled
if [ ! -f /etc/nginx/sites-enabled/libraverse ]; then
    sudo ln -s "$NGINX_CONF" /etc/nginx/sites-enabled/
fi

# Remove default site
if [ -f /etc/nginx/sites-enabled/default ]; then
    sudo rm /etc/nginx/sites-enabled/default
fi

# 10. Set directory permissions for www-data (Nginx user)
echo "--> Adjusting directory ownership and permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache database

# 11. Test Nginx Configuration
echo "--> Verifying Nginx configuration..."
sudo nginx -t

# 12. Restart Nginx and PHP-FPM
echo "--> Restarting services..."
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm

echo "==========================================="
echo " Setup Completed Successfully!"
echo " Visit: http://$PUBLIC_IP"
echo "==========================================="
