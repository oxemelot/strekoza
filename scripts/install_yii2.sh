#!/bin/bash

set -euo pipefail

# Настройки
SERVICE_NAME=php
APP_DIR=/var/www

# Сборка и запуск контейнеров
echo "🚀 Запуск docker-compose..."
docker compose -f ../docker-compose.yml up -d --build

# Установка Yii2 Advanced
echo "📦 Установка Yii2 Advanced..."
docker compose exec $SERVICE_NAME bash -c "rm -rf $APP_DIR/{*,.*} && composer create-project yiisoft/yii2-app-advanced $APP_DIR --prefer-dist"

# Инициализация проекта
echo "⚙️  Инициализация проекта..."
docker compose exec $SERVICE_NAME bash -c "cd $APP_DIR && php init --env=Development --overwrite=All"

echo "✅ Установка завершена. Yii2 Advanced готов к работе!"
