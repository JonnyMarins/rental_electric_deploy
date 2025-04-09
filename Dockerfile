# Usa un'immagine Node.js per la fase di build
FROM node:18 AS build

# Imposta la directory di lavoro
WORKDIR /app

# Copia i file package.json e package-lock.json
COPY package*.json ./

# Installa le dipendenze
RUN npm install

# Copia solo i file necessari per il build
COPY resources/ resources/
COPY vite.config.js .
COPY postcss.config.js .
COPY tailwind.config.js .

# Compila gli asset
RUN npm run build

# Usa l'immagine di produzione per il server
FROM richarvey/nginx-php-fpm:latest

# Copia gli asset compilati dalla fase di build
COPY --from=build /app/public/build /var/www/html/public/build

# Copia i file dell'applicazione Laravel
COPY app/ /var/www/html/app/
COPY bootstrap/ /var/www/html/bootstrap/
COPY config/ /var/www/html/config/
COPY database/ /var/www/html/database/
COPY public/ /var/www/html/public/
COPY resources/views/ /var/www/html/resources/views/
COPY routes/ /var/www/html/routes/
COPY storage/ /var/www/html/storage/
COPY artisan /var/www/html/
COPY composer.* /var/www/html/

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]

# Imposta i permessi di lettura, scrittura ed esecuzione
RUN chmod -R 775 storage bootstrap/cache

# Cambia il proprietario delle directory
RUN chown -R www-data:www-data storage bootstrap/cache