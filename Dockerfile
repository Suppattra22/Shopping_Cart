FROM php:8.1-apache

# เปิดการใช้งาน session
COPY php.ini /usr/local/etc/php/

# คัดลอกไฟล์เว็บไซต์ไปไว้ในโฟลเดอร์ Apache
COPY src/ /var/www/html/

# ให้ Apache เขียนได้
RUN chown -R www-data:www-data /var/www/html
