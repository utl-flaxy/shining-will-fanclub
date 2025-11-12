# ベースイメージ
FROM laravelsail/php83-composer:latest

# 必要な拡張機能を追加（intl + pdo_mysql + zipなど）
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install intl pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 作業ディレクトリ設定
WORKDIR /var/www/html

# Laravelファイルをコピー
COPY . .

# 依存関係をインストール（vendorがない場合のみ）
RUN if [ ! -d "vendor" ]; then composer install --no-interaction --prefer-dist; fi

# 権限を調整（WSLユーザー環境向け）
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 起動コマンド（Laravel開発サーバーを起動）
CMD php artisan serve --host=0.0.0.0 --port=8000
