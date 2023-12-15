# Utilisez une image PHP Apache
#FROM php:apache
# Copiez le contenu de l'application PHP dans le répertoire de travail du conteneur (/var/www/html/ est le répertoire par défaut d'Apache)
#COPY . /var/www/html/
# Installez les dépendances de PDO pour MySQL
#RUN docker-php-ext-install pdo pdo_mysql

#utilisons une image PHP apache
FROM php:apache
#copy de toute l'appl dans le répertoire du travail du conteneur
COPY . /var/www/html
# #copy de l'env prod en le renommant en env
# COPY .env.prod /var/www/html/.env
# installons les dépendances de PDO pour MySQL
RUN docker-php-ext-install pdo pdo_mysql