## Проект для хакатона ОБУ-ИТЦ-2024

## Дизайн проекта - `https://www.figma.com/design/i6btcpMI5PBJTMhGADRqCP/%D0%94%D0%B8%D0%B7%D0%B0%D0%B9%D0%BD-(%D1%81%D0%BE-%D1%81%D1%82%D0%B0%D1%80%D1%8B%D0%BC%D0%B8-%D0%B7%D0%B0%D0%B3%D0%BE%D1%82%D0%BE%D0%B2%D0%BA%D0%B0%D0%BC%D0%B8).-%D0%9E%D0%91%D0%A3-%D0%98%D0%A2%D0%A6.-%D0%9C%D0%B0%D0%B9-2024?node-id=102-323&t=azZmI0Kyxe6F1Zym-0`


## Презентация проекта - `Ссылка сюда`

## Иструкция по запуску проекта

## Frontend

Для запуска или установки Vue Vite требуется Node.js версии 18+ https://nodejs.org/en/

1. Заходим в папку frontend `cd frontend`
2. Устанавливаем зависимости с помощью команды `npm install`
3. Запускам проект с помщоью команды `npm run dev`
4. Готово, фронт запущен

## Backend

1. Заходим в папку backend `cd backend`
2. Запускаем docker службу
3. Создаем образ `docker build -t <название образа> .`
4. Запускаем контейнер `docker compose -p <название контейнера> up -d`
5. Для установки композера composer require phpmailer/phpmailer
6. Сервер запущен

## В папке postgres лежит файл дампа базы данных, который нужно выполнить

1. Чтобы зайти внутрь контейнера с базой данных введем команду `docker exec -it <container id> /bin/bash`
2. После попадания внутрь контейнера подключаемся к базе данных `psql -H postgres-db -U user -d obu-hack-2024`
3. Выполняем скрипт с базой данных `\i dump/<название файла.sql>`
4. Готово база данных создана и заполнена!


## Тест Backend

1. Для начала вам необходимо запустить наш сервер на Docker и подключить нашу базу данных

2. Заходите в Postman по `https://www.postman.com/notfive/workspace/notfive-workspace/overview` или ищите команду `notFive` в и переходите на `notFive Workspace`
3. Вас интересует obu_hack, выбираете его
4. Делайте форк и можете тестировать ( тестировать в браузере нельзя )

