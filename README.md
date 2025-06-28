## 🚀 Быстрый старт

1. **Создай `.env` файл на основе скрипта**

   ```bash
   ./scripts/generate-env.sh
   ```

   ```
   Достаточно нажимать клавишу Enter для базовой установки.
   Также будет необходимо задать пароль для БД.
   ```

2. **Запусти инфраструктуру**

   ```bash
   docker compose up --build -d
   ```

---

## Структура проекта

```
.
├── data/                        # Персистентные данные (например, БД)
│   └── postgres-db/             # Том данных PostgreSQL database (директория может быть создана контейнером)
├── docker/                      # Dockerfile'ы и конфиги сервисов
│   ├── nginx/                   # Nginx
│   │   ├── api/                 # Nginx API
│   │   │   ├── Dockerfile       # Nginx API образ
│   │   │   └── nginx.conf       # Nginx API конфиг
│   │   ├── backend/             # Nginx Backend
│   │   │   ├── Dockerfile       # Nginx Backend образ
│   │   │   └── nginx.conf       # Nginx Backend конфиг
│   │   └── frontend/            # Nginx Frontend
│   │       ├── Dockerfile       # Nginx Frontend образ
│   │       └── nginx.conf       # Nginx Frontend конфиг
│   ├── php-app/                 # PHP-приложение
│   │   └── Dockerfile           # Образ PHP + расширения
│   └── postgres-db/             # PostgreSQL БД
│       ├── Dockerfile           # PostgreSQL БД образ
│       ├── init.sql             # Скрипт инициализации базы
│       └── init.sql.tpl         # Шаблон с заполнителями для генерации init.sql
├── logs/                        # Логи контейнеров
│   └── nginx/                   # Логи Nginx по разным сервисам
│       ├── api/                 # Логи Nginx API
│       ├── backend/             # Логи Nginx Backend
│       └── frontend/            # Логи Nginx Frontend
├── scripts/                     # Скрипты для автоматизации и установки
│   └── generate-compose-phpstorm.sh   # Скрипт генерации docker-compose-phpstorm.yml (для настройки xdebug в PhpStorm)
│   └── generate-compose-resolved.sh   # Скрипт генерации docker-compose-resolved.yml (для визуальной сверки окружения)
│   └── generate-env.sh                # Скрипт генерации .env (сохраняет интерактивный ввод в параметры окружения)
│   └── install_yii2.sh                # Создаёт новый проект на Yii2 (запускать, только если нет никакого проекта)
├── yii2/                        # Исходники приложения (Yii2)
├── .env                         # Переменные окружения
├── .env.tpl                     # Шаблон переменных окружения
├── .gitignore                   # Список файлов-исключений для Git
├── docker-compose.yml           # Основной docker-compose файл
├── docker-compose-phpstorm.yml  # PhpStorm docker-compose файл (т.к. PhpStorm не понимает конфиги с ключом args)
├── docker-compose-resolved.yml  # Resolved docker-compose файл (для наглядного отображения окружения, не используется)
├── README.md                    # Документация по развёртыванию приложения
└── README-APP.tpl.md            # Документация уже развёрнутого приложения
```

---

## ⚙️ Примечания

- `generate-env.sh` - скрипт для генерации `.env`, а также для подстановки переменных окружения в SQL и README шаблоны.