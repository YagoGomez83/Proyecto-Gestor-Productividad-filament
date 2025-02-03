FROM php:8.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    bash \
    libpq-dev \
    libicu-dev \
    apache2 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql intl

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Dockerize
RUN curl -sSL https://github.com/jwilder/dockerize/releases/download/v0.6.1/dockerize-linux-amd64-v0.6.1.tar.gz | tar -C /usr/local/bin -xzv

# Instalar Node.js y npm
# Instalar Node.js (v20.x) y npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Eliminar el archivo de configuración por defecto si existe
RUN rm -f /etc/apache2/sites-available/000-default.conf

# Copiar la configuración de Apache personalizada desde el archivo en tu máquina local
COPY ./config/apache/default-ssl.conf /etc/apache2/sites-available/000-default.conf

# Habilitar el sitio predeterminado
RUN a2ensite 000-default.conf

# Exponer los puertos de Apache y PHP-FPM
EXPOSE 80

# Comando para ejecutar Apache en primer plano
CMD ["apache2ctl", "-D", "FOREGROUND"]
