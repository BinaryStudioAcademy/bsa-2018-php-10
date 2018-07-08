### Домашнее задание: разработка системы рассылки email сообщений с помощью очереди (queue)

#### Требования
Рализовать очередь для простой рассылки уведомлений пользователям об изменении курса валюты в БД используя фреймворк Laravel.

***

#### Установка

**Форкать репозиторий нельзя!**

```
git clone <link to this repository>
cd <name of repository>
cp .env.example .env
composer install
php artisan key:generate
```
Проверьте и настройте очереди в [config/queue.php](config/queue.php):
- Connection type: beanstalkd
- Queue name: notification

Для выполнения этого задания разрешается использование кода предыдущих домашних заданий.

#### Задание

Основная цель задания: после изменения администратором курса какой-либо из валют в БД, необходимо проинформировать с помощью информационного Email всех
пользователей из таблицы users по соответствующим email-адресам.

* Реализовать job класс класс App\Jobs\SendCourseChangedEmail для отправки Email об изменении курса валюты всем пользователям из таблицы users
* Job должен получать модель User и Currency, и отправлять следующий текст:
```
Dear <user name>,

<currency name> exchange rate has been changed to <new rate>!

Best regards,
Crypto Market Service!
```

#### Проверка

Вы можете проверить себя запустив тест в директории проекта:
```
./vendor/bin/phpunit
```
