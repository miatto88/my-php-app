FROM php:7.2-fpm

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim

WORKDIR /usr/local/bin
RUN curl -sSL https://github.com/evertiro/mhsendmail/releases/download/v0.2.0-M1/mhsendmail_linux_arm64 -o mhsendmail \
   && chmod +x mhsendmail

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mysqli 
RUN echo "alias ll='ls -la'" >> ~/.bashrc && . ~/.bashrc
WORKDIR /var/www/html
