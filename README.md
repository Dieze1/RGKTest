Тестовое задание для соискателей на должность PHP-developer
============================

Yii 2 Basic Project Template в качестве основы для приложения по отслеживанию событий в моделях.
Стартовая страница выдаёт только приветствие.
Страница Signup позволяет создать пользователя с любой ролью (админ, пользователь).
Затем необходимо залогиниться.

Пользователю доступна только страница **Notifications** (уведомления) - ListView из Bootstrap-alert-ов с пагинацией
(10 элементов на страницу), а также кнопкой прочитано (х). CRUD сгенерирован автоматически, но кроме index не используется,
сортировка по dismissed и дате уведомлений.

Админу доступно еще 2 раздела:

**Articles** (статьи) - тут всё довольно тривиально, CRUD статей.

**Triggers** (триггеры) - здесь задаем отслеживаемую модель, выбираем из доступных в выбранной модели событие, От кого, Кому
(Здесь немного негибко получилось, ибо помимо отправки уведомлений конкретному пользователю или всем пользователям,
нужна отправка инициатору события, т.к. заранее выбрать пользователя, которому нужно отправить уведомление при регистрации
невозможно), Заголовок и Текст сообщения (Доступна подстановка параметров, поддерживаемых в модели), Тип уведомления
(мултиселект). CRUD

Отслеживание событий осуществляется с помощью Поведения models/Triggered,
которое нужно подключить во всех интересующих нас моделях (подключено в 
User и в Articles)

[Автор Салтановский Д.С.](https://voronezh.hh.ru/resume/fdd3cd7eff032036750039ed1f553154443367)


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      config/             здесь в файле **db.php** не забудьте прописать свои настройки БД
      controllers/        здесь контроллеры
      mail/               contains view files for e-mails
      models/             здесь все модели и поведение Triggered
      runtime/            contains files generated during runtime
      tests/              тесты не писал, уже и без того слишком долго выполняю это задание
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



ТРЕБОВАНИЯ
------------

Функция получения списка доступных в модели событий использует array_filter с параметром, добавленным в PHP 5.6.



НАСТРОЙКА
---------

### БД

Внесите в `config/db.php` реальные данные, например:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

### Миграции создадут необходимые таблицы

### Подключение системы отслеживания событий к моделям:
1. В /models/Model.php дописать функции getEvents и behaviors
2. В /views/triggers/_form.php в поле 'model' дописать имя новой модели

### Добавление новых типов уведомлений:
1. В /models/Triggered.php в функции triggerMe добавить обработчик отправки
нового типа уведомления
2. В /views/triggers/_form.php в поле 'type' дописать имя нового типа


**Заметки:**
- Сложно сказать, сколько времени ушло на выполнение задания, при том, 
что с Yii2 столкнулся впервые, и большая часть времени затрачена на 
изучение мануалов. Приблизительно 2-3 дня на написание кода.
- При проблемах с русским текстом в MySQL выполнить:
```SQL
SET collation_connection = 'utf8_general_ci';
ALTER DATABASE yii2basic CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE yii2basic.articles CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE yii2basic.notifications CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE yii2basic.triggers CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE yii2basic.user CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
```