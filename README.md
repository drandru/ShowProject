
# ShowProject

## Добрый день.
Решил написать проект, по задаче с собеседования )) 
Про полки, книги и авторов.

для сборки проекта

`
make build
`

Для запуска

`
make start
`

или старт в фоновом режиме

`
make start-d 
`

Подождите 10 секунд, загрузятся миграции.

В проект доступен на [localhost:8080/admin](http://localhost:8080/admin) (для изменения порта см docker-compose.yml #28)

логин пароль `admin@admin.com` : `admin`

вначале добавьте авторов и полки, а сущность книги сводная. 
связь книг к авторам - manyToMany
связь полок и книг - oneToMany


## Основная идея:
Код добавлен в виде модулей `app/modules` (под каждую сущность свой модуль, это для наглядности), модули подгружаются через composer. На мой взгляд это достаточно удобный способ работы как в структуре монолита, так и с возможным переходом на микросервисы.




