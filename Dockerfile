FROM node:22-alpine AS node
FROM php:8.2-fpm

# Copy node from node image
COPY --from=node /usr/lib /usr/lib
COPY --from=node /usr/local/lib /usr/local/lib
COPY --from=node /usr/local/include /usr/local/include
COPY --from=node /usr/local/bin /usr/local/bin

# Update package repositories and install dependencies
RUN apt-get update && \
  apt-get install -y \
  git \
  zip \
  unzip \
  libzip-dev \
  libpq-dev \
  curl \
  && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
  && apt-get install -y nodejs \
  && docker-php-ext-install pdo pdo_mysql zip bcmath

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install and build frontend assets
RUN npm ci && npm run build

# Create custom entrypoint script
RUN echo '#!/bin/bash\n\
  chown -R www-data:www-data /var/www/html/storage\n\
  chmod -R 775 /var/www/html/storage\n\
  php-fpm' > /usr/local/bin/entrypoint.sh && \
  chmod +x /usr/local/bin/entrypoint.sh

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage \
  /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage \
  /var/www/html/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Use custom entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
