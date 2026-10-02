# BD VulnSite

Сайт с преднамеренными уязвимостями для изучения базовой веб-безопасности.

## ВНИМАНИЕ

Проект содержит намеренные уязвимости и предназначен **только для локального обучения** в изолированной среде. Не выкладывайте его в публичный доступ и не запускайте на серверах, доступных из интернета. Автор не несёт ответственности за любой ущерб, вызванный использованием этого кода.

## Происхождение проекта

Оригинальный проект **BDVulnSite** создан **BlackDiverX**:

- Автор: BlackDiverX
- Исходный репозиторий: https://github.com/BlackDiverX/BDVulnSite

Текущая версия — форк с модернизацией (Docker, PHP 8.2, MariaDB 10.11, чеклист). Оригинальная идея, структура и логика уязвимостей принадлежат автору оригинального проекта.

## Уязвимости

| Уязвимость | Файл | Параметр |
|---|---|---|
| SQL Injection (обход аутентификации) | login.php | username, password |
| SQL Injection (UNION) | comments.php | search |
| Reflected XSS | comments.php | search |
| Stored XSS | comments.php | name, comment |
| Command Injection | monitor.php | type |
| Local File Inclusion (LFI) | monitor.php | page |
| CSRF | comments.php | POST |
| Раскрытие данных | login.php | сообщения об ошибках |

## Требования

- Docker
- Docker Compose

Для запуска без Docker:

- Apache
- PHP 8.0+ с расширением mysqli
- MySQL 5.7+ или MariaDB 10.3+

## Быстрый старт (Docker)

1. Клонировать репозиторий:

   ```
   git clone https://github.com/swatteam1/BDVulnSite.git
   cd BDVulnSite
   ```

2. Создать файл `.env` из шаблона:

   ```
   cp .env.example .env
   ```

   При необходимости отредактировать значения (пароли, порт, секрет для флагов).

3. Запустить:

   ```
   docker compose up -d --build
   ```

4. Открыть в браузере:

   ```
   http://localhost:8080
   ```

База данных создаётся и заполняется автоматически при первом старте контейнера через `backup.sql`.

## Запуск без Docker

1. Скопировать файлы проекта в директорию веб-сервера.

2. Создать базу данных MySQL/MariaDB.

3. Указать параметры подключения в `config.php` (или задать переменные окружения `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME`).

4. Выполнить скрипт `install.php` для создания и заполнения таблиц:

   ```
   http://localhost/install.php
   ```

## Переменные окружения

Используются в `docker-compose.yml` и читаются в `config.php`:

| Переменная | По умолчанию | Назначение |
|---|---|---|
| DB_HOST | db | Хост базы данных |
| DB_USER | admin | Пользователь БД |
| DB_PASSWORD | MegaPassword1! | Пароль пользователя БД |
| DB_NAME | portal | Имя базы данных |
| DB_ROOT_PASSWORD | root | Root-пароль MariaDB |
| WEB_PORT | 8080 | Порт, на котором доступен сайт |
| FLAG_SECRET | bdvulnsite-ctf-secret-2026 | Секрет для HMAC-хешей флагов |

## Структура проекта

```
.
├── Dockerfile
├── docker-compose.yml
├── .env.example
├── .gitignore
├── .dockerignore
├── backup.sql              # дамп БД
├── config.php              # настройки подключения к БД
├── install.php             # создание и заполнение таблиц (альтернатива backup.sql)
├── index.html              # главная страница
├── login.php               # вход 
├── comments.php            # отзывы
├── monitor.php             # мониторинг
├── checklist.php           # CTF-чеклист с полями для флагов
├── flags.php               # HMAC-хеши флагов
├── tools/
│   └── hash_flag.php       # CLI-утилита для генерации хешей
├── style.css
├── logo.png
└── text/                   # файлы для LFI-демонстрации
```

## Чеклист уязвимостей (CTF)

Страница `checklist.php` — это CTF-подобный чеклист. Для каждой уязвимости нужно найти флаг и ввести его в поле. Прогресс хранится в сессии.

Флаги хранятся в `flags.php` как HMAC-SHA256 с секретом `FLAG_SECRET` из `.env`. Без секрета восстановить оригиналы невозможно, даже имея доступ к репозиторию.

Список заданий:

| Задание | Область | Уязвимость |
|---|---|---|
| Обход аутентификации | Форма входа | SQL Injection |
| Утечка через поиск | Страница отзывов | SQL Injection (UNION) |
| Отражённый ввод | Страница отзывов | Reflected XSS |
| Сохранённый ввод | Страница отзывов | Stored XSS |
| Выполнение на сервере | Страница мониторинга | Command Injection |
| Чтение файлов | Страница мониторинга | LFI |
| Действие от чужого имени | Страница отзывов | CSRF |
| Лишняя информация | Форма входа | Раскрытие данных |

Названия уязвимостей в чеклисте намеренно нейтральны — пользователь должен сам догадаться, какой вектор применить.

## Смена флагов

Если вы форкаете проект и хотите свои флаги:

1. Придумать новые флаги в формате `flag{...}`.

2. Задать свой `FLAG_SECRET` в `.env`.

3. Пересчитать хеши командой:

   ```
   FLAG_SECRET=ваш-секрет php tools/hash_flag.php "flag{ваш-флаг}"
   ```

4. Вставить полученные хеши в `flags.php`.

5. Заменить оригинальные флаги в:
   - `backup.sql` (таблица `secrets`);
   - `install.php` (INSERT в `secrets`);
   - `comments.php` (Stored XSS, CSRF);
   - `login.php` (Data Disclosure);
   - `Dockerfile` (`/flag_cmd.txt`, `/flag_lfi.txt`).

## Остановка и очистка

Остановить контейнеры:

```
docker compose down
```

Остановить и удалить данные БД (при следующем запуске БД будет создана заново):

```
docker compose down -v
```

## Лицензия

См. файл LICENSE. Проект распространяется только для образовательных целей.

## Благодарности

Оригинальный проект **BDVulnSite** создан командой **BlackDiverX** (https://BlackDiver.Net).

Текущая версия — форк с модернизацией. Оригинальная идея, структура и логика уязвимостей принадлежат автору оригинального проекта.
BD VulnSite
Тестовый сайт с уязвимостями:
1) SQL Injection
2) Cross-Site Scripting (XSS)
3) Command Injection
4) Local File Inclusion (LFI)
5) раскрытие данных
6) Сross Site Request Forgery (CSRF)
7) перехват трафика

Создан для базового изучения Web уязвимостей.

Системные требования
--------------------
Для установки требуется: 
Apache
PHP
MySQL/MariaDB

Для Windows [XAMPP](https://www.apachefriends.org/ru/index.html) или аналогичный.

Для Unix отлично описано в [этом](https://github.com/teddysun/lamp) репо.

Установка
---------
1) Скопировать файлы в директорию Web сервера
2) Создать базу данных
3) Указать настройки базы данных в файле parse.php
4) Выпонить скрипт install.php для заполнения базы данных

От автора оригинального репо [BlackDiverX](https://github.com/BlackDiverX)/[BDVulnSite](https://github.com/BlackDiverX/BDVulnSite)
----------
Посетите наш сайт, посвященный обучению тестированию на проникновение.

Команда сайта BlackDiver.Net

[https://BlackDiver.Net](https://blackdiver.net)
