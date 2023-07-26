## Docker

Запустить Redis и MEILISEARCH контейнеры
`docker compose -f docker-compose.prod.yml up -d`

## .env файл

В config/database.php настроены 3 соединения для разных БД. Нужно в .env указать настройки. Для каждой БД префиксы HA (
HomeAdvisor), ND (ND), YP (Yelp)
Так же настраиваем остальное окружение для Laravel по умолчанию

## Запускаем миграции и сиды

https://laravel.com/docs/10.x/migrations#main-content
https://laravel.com/docs/10.x/seeding#main-content

## Scout

Для индексации и поиска работает контейнер Meilisearch, описан в docker-compose.yaml Все модели в начале нужно прогнать
через индексацию (https://laravel.com/docs/10.x/scout#batch-import), модели лежат в app/Models/Resources Потом запускаем
обновление индексов (https://laravel.com/docs/10.x/scout#configuring-filterable-data-for-meilisearch)
Стоит помнить что нужно запустить Laravel очередь чтобы прошла комманда индексации
моделей (https://laravel.com/docs/10.x/scout#queueing)

## Панель админа Orchid (https://orchid.software/)

В целом настроек кроме создать главного админа чтобы зайти в панель в первый раз не
требуеться (https://orchid.software/en/docs/installation/#create-an-admin-user)
