#!/bin/bash

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TEMPLATE_FILE="$SCRIPT_DIR/../.env.tpl"
ENV_FILE="$SCRIPT_DIR/../.env"
INIT_SQL_TEMPLATE="$SCRIPT_DIR/../docker/postgres-db/init.sql.tpl"
INIT_SQL_FILE="$SCRIPT_DIR/../docker/postgres-db/init.sql"
README_TEMPLATE="$SCRIPT_DIR/../README-APP.tpl.md"
README_OUTPUT="$SCRIPT_DIR/../README-APP.md"

declare -A VALUES

VALUES["APP_UID"]="$(id -u)"
VALUES["APP_GID"]="$(id -g)"

echo "⚙️ Генерация $ENV_FILE из шаблона $TEMPLATE_FILE"
echo "🔧 Вводи значения (нажми Enter, чтобы оставить текущее значение, если указано)"
echo

> "$ENV_FILE"

while IFS='=' read -r key default_value || [[ -n "$key" ]]; do
  [[ -z "$key" || "$key" =~ ^# ]] && continue

  default_value="${default_value%\"}"
  default_value="${default_value#\"}"

  case "$key" in
    APP_UID|APP_GID)
      value="${VALUES[$key]}"
      ;;
    APP_NAME)
      echo -n "$key [$default_value]: " > /dev/tty
      read -r input < /dev/tty
      value="${input:-$default_value}"
      VALUES["APP_NAME"]="$value"
      ;;
    DB_NAME|DB_USER)
      default="${VALUES["APP_NAME"]:-$default_value}"
      echo -n "$key [$default]: " > /dev/tty
      read -r input < /dev/tty
      value="${input:-$default}"
      ;;
    DB_PASS)
      while true; do
        echo -n "$key [required, hidden]: " > /dev/tty
        stty -echo < /dev/tty
        read -r input < /dev/tty
        stty echo < /dev/tty
        echo > /dev/tty
        if [ -n "$input" ]; then
          value="${input//\$/\$\$}"
          break
        else
          echo "❌ Пароль не может быть пустым." > /dev/tty
        fi
      done
      ;;
    *)
      echo -n "$key [$default_value]: " > /dev/tty
      read -r input < /dev/tty
      value="${input:-$default_value}"
      ;;
  esac

  VALUES["$key"]="$value"
  echo "$key=$value" >> "$ENV_FILE"
done < "$TEMPLATE_FILE"

echo
echo "✅ .env успешно сохранён → $ENV_FILE"

# === Подстановка в init.sql ===
if [ -f "$INIT_SQL_TEMPLATE" ]; then
  echo "🛠  Генерация init.sql из шаблона init.sql.tpl"
  cp "$INIT_SQL_TEMPLATE" "$INIT_SQL_FILE"
  sed -i \
    -e "s/{{DB_SCHEMA}}/${VALUES["DB_SCHEMA"]}/g" \
    -e "s/{{DB_USER}}/${VALUES["DB_USER"]}/g" \
    "$INIT_SQL_FILE"
fi

# === Подстановка в README.md ===
if [ -f "$README_TEMPLATE" ]; then
  echo "🛠  Обновление $README_OUTPUT по шаблону README-APP.tpl.md"
  cp "$README_TEMPLATE" "$README_OUTPUT"

  for key in "${!VALUES[@]}"; do
    placeholder="{{${key}}}"
    value="${VALUES[$key]}"
    # Экранируем слэши и амперсанды для sed
    safe_value=$(printf '%s\n' "$value" | sed -e 's/[\/&]/\\&/g')
    sed -i "s/${placeholder}/${safe_value}/g" "$README_OUTPUT"
  done
fi

echo "🎉 Всё готово!"
