# Api Cacher

Проксирование удаленного API с дальнейшим хранениям ответов в кэше.

1. Запустите сервер, например выполнив команду: `php -S localhost:9999 index.php`
2. В настройках своего приложения в качестве API сервера укажите `localhost:9999`
3. Создайте копию конфига `config-sample.php` с названием `config.php` и укажите в нем URL настоящего API сервера.

Теперь все последующие запросы к API будут проксироваться, а ответы добавлятся в кэш.