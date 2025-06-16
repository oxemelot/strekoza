#!/bin/bash

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(realpath "$SCRIPT_DIR/..")"

ENV_FILE="$PROJECT_ROOT/.env"
COMPOSE_FILE="$PROJECT_ROOT/docker-compose.yml"
OUTPUT_FILE="$PROJECT_ROOT/docker-compose-resolved.yml"

if [ ! -f "$ENV_FILE" ]; then
  echo "❌ .env файл не найден: $ENV_FILE"
  exit 1
fi

if [ ! -f "$COMPOSE_FILE" ]; then
  echo "❌ docker-compose.yml не найден: $COMPOSE_FILE"
  exit 1
fi

echo "📦 Генерация $OUTPUT_FILE с подставленными переменными из .env..."

# Надёжная загрузка переменных из .env
while IFS='=' read -r key value; do
  # Пропустить пустые строки и комментарии
  [[ -z "$key" || "$key" =~ ^# ]] && continue

  # Убрать возможные кавычки вокруг значения
  value="${value%\"}"
  value="${value#\"}"
  value="${value%\'}"
  value="${value#\'}"

  export "$key=$value"
done < "$ENV_FILE"

# Подстановка переменных
envsubst < "$COMPOSE_FILE" > "$OUTPUT_FILE"

echo "✅ Готово: $OUTPUT_FILE"
