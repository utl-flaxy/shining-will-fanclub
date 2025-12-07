# ベースイメージ（Laravel Sail / PHP 8.3）
FROM laravelsail/php83-composer:latest

# GD + EXIF + 既存拡張をインストール
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libexif-dev \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    && docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    gd \
    exif \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 作業ディレクトリ
WORKDIR /var/www/html

# Laravelファイルコピー
COPY . .

# Composer install（vendorが無い場合のみ）
RUN if [ ! -d "vendor" ]; then composer install --no-interaction --prefer-dist; fi

# 権限調整
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Laravel 開発サーバー起動
CMD php artisan serve --host=0.0.0.0 --port=8000
