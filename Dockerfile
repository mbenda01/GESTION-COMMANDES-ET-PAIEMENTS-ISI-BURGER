FROM php:8.2-cli-alpine

# ── 1. Dépendances système ──────────────────────────
RUN apk add --no-cache \
    bash \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libzip-dev \
    postgresql-dev \
    nodejs \
    npm \
    oniguruma-dev \
    libxml2-dev

# ── 2. Extensions PHP ───────────────────────────────
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
    mbstring \
    xml \
    bcmath

# ── 3. Composer ─────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ── 4. Dossier de travail ───────────────────────────
WORKDIR /var/www/html

# ── 5. Copier composer.json seul d'abord ────────────
COPY composer.json composer.lock ./

# ── 6. Installer les dépendances PHP ────────────────
RUN composer install \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

# ── 7. Copier tout le projet ─────────────────────────
COPY . .

# ── 8. Finaliser composer ───────────────────────────
RUN composer dump-autoload --optimize

# ── 9. Dépendances Node + Build frontend ────────────
RUN npm install && npm run build

# ── 10. Permissions ─────────────────────────────────
RUN chmod -R 775 storage bootstrap/cache

# ── 11. Lancer l'application ────────────────────────
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
