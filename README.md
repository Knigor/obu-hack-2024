## Проект для хакатона ОБУ-ИТЦ-2024

## Дизайн проекта - https://clck.ru/3AzowS

## Презентация проекта - https://docs.google.com/presentation/d/1beMFL7enuccZz_yBYAZSrmXwkbHnabfTAJUEkL0fMpE/edit#slide=id.g2e20c13be55_5_105

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

## ML приложение
1. Для того чтобы запустить сервис для расчета стоимости билетов, перейдем в папку `ml-app/python` и выполним скрипт для запуска сервиса на flask `python app.py`
2. Рабочая модель так же находится по этому пути, называется `model`
