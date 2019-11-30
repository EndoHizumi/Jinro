FROM php:7.2.7-apache as dev

RUN apt update && apt install -y libtidy-dev git libzip-dev zlib1g-dev
RUN docker-php-ext-install pdo_mysql mbstring tidy zip
# nodejsのセットアップ
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs
# Vue.jsのインストール
RUN npm install -g @vue/cli
RUN npm install -g @vue/cli-service-global

FROM php:7.2.7-apache as prod

RUN apt update && apt install -y libtidy-dev git libzip-dev zlib1g-dev
RUN docker-php-ext-install pdo_mysql mbstring tidy zip
# nodejsのセットアップ
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs
# Vue.jsのインストール
RUN npm install -g @vue/cli
RUN npm install -g @vue/cli-service-global