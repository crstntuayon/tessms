# ==========================================
# TESSMS - Render Deployment Dockerfile
# ==========================================

FROM php:8.2-apache

# Prevent interactive prompts during build
ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libssl-dev \
    unzip \
    git \
    curl \
    nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        gd \
        mbstring \
        xml \
        zip \
        bcmath \
        intl \
        ctype \
        fileinfo \
        tokenizer \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite headers expires deflate

# Install Node.js 20.x (LTS) and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for better Docker layer caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-autoloader

# Copy package files
COPY package.json package-lock.json* ./
RUN npm ci

# Copy the rest of the application
COPY . .

# Generate autoloader (now that all files are present)
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Set proper permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache \
    && chmod -R 775 public/build

# Copy Apache virtual host configuration
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy startup script
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Create Laravel storage directories if they don't exist
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    storage/logs storage/app/public \
    && chown -R www-data:www-data storage bootstrap/cache

# Expose port 80
EXPOSE 80

# Use the startup script as entrypoint
CMD ["/usr/local/bin/start.sh"]
