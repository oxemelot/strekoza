# {{APP_TITLE}}

---

## 🚀 Быстрый старт

1. **Создай `.env` файл на основе скрипта**

   ```bash
   ./scripts/generate-env.sh
   ```

2. **Запусти инфраструктуру**

   ```bash
   docker compose up --build -d
   ```

---

## 🌐 Доступ в браузере

- Frontend: [`http://localhost:{{NGINX_FRONTEND_PORT}}`](http://localhost:{{NGINX_FRONTEND_PORT}})
- Backend: [`http://localhost:{{NGINX_BACKEND_PORT}}`](http://localhost:{{NGINX_BACKEND_PORT}})
- API: [`http://localhost:{{NGINX_API_PORT}}`](http://localhost:{{NGINX_API_PORT}})

---

## Структура проекта

```
.
├── data/                      # Персистентные данные (например, БД)
│   └── postgres/              # Том данных PostgreSQL (директория может быть создана контейнером)
├── docker/                    # Dockerfile'ы и конфиги сервисов
│   ├── nginx/
│   │   ├── api/
│   │   │   ├── Dockerfile
│   │   │   └── nginx.conf
│   │   ├── backend/
│   │   │   ├── Dockerfile
│   │   │   └── nginx.conf
│   │   └── frontend/
│   │       ├── Dockerfile
│   │       └── nginx.conf
│   ├── php/
│   │   └── Dockerfile         # Образ PHP + расширения
│   └── postgres/
│       ├── init.sql           # Скрипт инициализации базы
│       └── init.sql.tpl       # Шаблон с заполнителями для генерации init.sql
├── logs/                      # Логи контейнеров
│   └── nginx/                 # Логи Nginx по разным сервисам
│       ├── api/
│       ├── backend/
│       └── frontend/
├── scripts/                   # Скрипты для автоматизации и установки
│   └── generate-env.sh        # Скрипт генерации .env
├── yii2/                      # Исходники приложения (Yii2)
├── docker-compose.yml         # Основной docker-compose файл
├── .env                       # Переменные окружения
├── .env.tpl                   # Шаблон переменных
├── README.md                  # Документация
└── README.tpl.md              # Шаблон документации
```

---

## ⚙️ Примечания

- `generate-env.sh` - скрипт для генерации `.env`, а также для подстановки переменных окружения в SQL и README шаблоны.

---

© {{APP_TITLE}}, 2025