FROM php:8.1-apache

# ติดตั้ง zip และ PHP extension ที่จำเป็น
RUN apt-get update && apt-get install -y \
    libzip-dev unzip && \
    docker-php-ext-install mysqli pdo pdo_mysql

# เปิด mod_rewrite
RUN a2enmod rewrite

# ปรับ index และสิทธิ์ Directory
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n\
DirectoryIndex index.php index.html' >> /etc/apache2/apache2.conf

# คัดลอกโปรเจกต์
COPY . /var/www/html/

# 🔧 สำคัญ: สร้างโฟลเดอร์อัปโหลดและให้สิทธิ์ www-data
RUN mkdir -p /var/www/html/upload_image && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html

# เปลี่ยน user รัน Apache เป็น www-data (ชัวร์ว่าเขียนได้)
USER www-data

EXPOSE 80
