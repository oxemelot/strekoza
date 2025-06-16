#!/bin/bash

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(realpath "$SCRIPT_DIR/..")"

# Путь до исходного docker-compose.yml
SOURCE_COMPOSE="$PROJECT_ROOT/docker-compose.yml"
TARGET_COMPOSE="$PROJECT_ROOT/docker-compose-phpstorm.yml"

echo "📦 Генерация $TARGET_COMPOSE без блока args..."

# Удаление блока args: и всех вложенных строк с отступом
awk '
  BEGIN { skip = 0 }
  /^ *args: *$/ { skip = 1; next }
  skip == 1 && /^[[:space:]]{2,}/ { next }
  { skip = 0; print }
' "$SOURCE_COMPOSE" > "$TARGET_COMPOSE"

echo "✅ Готово: $TARGET_COMPOSE"
