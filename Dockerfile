FROM php:8.2-apache

# Копируем все файлы проекта в корневую директорию веб-сервера
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/

# Настраиваем Apache для работы с портом, который выдает Render (переменная PORT)
RUN sed -i "s/Listen 80/Listen \${PORT}/g" /etc/apache2/ports.conf && \
    sed -i "s/:80/:\${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Включаем модуль rewrite (на всякий случай для роутинга)
RUN a2enmod rewrite
