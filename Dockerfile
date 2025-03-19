# Utiliser l'image PHP officielle de PHP 7.4
FROM php:7.4-apache

# Installation des dépendances système nécessaires
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libonig-dev \
        libexif-dev \
        libgd-dev \
        iputils-ping \
        default-mysql-client \
        netcat \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql bcmath zip exif

# Copier le jeton GitHub en tant que variable d'environnement
#ARG GITHUB_TOKEN 
ENV GITHUB_TOKEN=e937372fa1ecd63957e7356ce79bb373c0a7ca88
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
# Configurer Composer pour utiliser le jeton GitHub
RUN composer config -g github-oauth.github.com $GITHUB_TOKEN

# Copie des fichiers de l'application
WORKDIR /var/www/Abajim
RUN chown -R www-data:www-data /var/www/Abajim
COPY . .

# Configuration de l'extension PHP exif
RUN docker-php-ext-configure exif \
   && docker-php-ext-install exif

# Installation de l'extension PHP gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
   && docker-php-ext-install -j$(nproc) gd

# Copier le fichier .env.example en tant que .env
COPY .env .env

# Installer les dépendances PHP avec Composer
RUN composer install --no-dev --optimize-autoloader

# Générer la clé de l'application
RUN php artisan key:generate || true

# Exposer le port utilisé par php artisan serve
EXPOSE 8000

# Script d'entrée pour attendre la base de données et exécuter les migrations
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Définir le script d'entrée
ENTRYPOINT ["entrypoint.sh"]

# Commande par défaut pour lancer le serveur Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
