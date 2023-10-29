## Тестовое задание

> Задача: Нужно сделать простую систему тестирования, поддерживающую вопросы с нечеткой логикой и возможностью выбора нескольких вариантов ответа.
.

## Детали реализации
Проект состоит из трёх страниц
1. Главная
2. Тест
3. Результаты

Так как авторизация не предусмотрена, то я решил написать сервис, который будет хранить состояние прохождения теста для текущего пользователя.
Хранилище может быть разным (`ContestStorageInterface`), для примера сделано через сессию `SessionContestStorage`

Вся работа с состояниями тестирования реализована в `CurrentContestService`

Работа с хранением состояния текущего пользователя и с базой данных вынесена в конкретные реализации абстракций, используемых в сервисе `CurrentContestService`

## Альтернативные пути без сессий
1. Выводить все вопросы на одной странице. Обрабатывать разом все ответы и сохранять в базу данных. 
2. Выводить по одному вопросу и после каждого сабмита сохранять ответ в базу данных. Динамически определять сколько сделано ответов и выводить случайный вопрос из оставшихся. Но нужна синхронизация пользователя с базой. Так как авторизации нет, то можно использовать сессию, куки или localStorage

### Установка и запуск проекта (DEV)

```shell
mkdir textmagic_test_be && cd textmagic_test_be
git clone https://github.com/VorontsovSA/textmagic_test_be.git ./
docker compose up -d --build 
docker compose exec php sh boot.sh
```
