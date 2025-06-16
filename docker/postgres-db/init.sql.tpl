-- Создаём схему
CREATE SCHEMA IF NOT EXISTS {{DB_SCHEMA}} AUTHORIZATION {{DB_USER}};

-- Назначаем search_path по умолчанию для пользователя
ALTER ROLE {{DB_USER}} SET search_path TO {{DB_SCHEMA}};

-- Удаляем public схему за ненадобностью
DROP SCHEMA public CASCADE;
