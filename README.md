# SQRT\Framework

> _Всё следует упрощать до тех пор, пока это возможно, но не более того. &copy; Эйнштейн_

## Идеология
1. Полиморфизм. Наследование. Инкапсуляция. Никакой магии.
2. Никаких текстовых конфигов.
3. Максимум подсказок в IDE (PHPStorm).

## Установка

Установка производится с помощью [Composer](https://getcomposer.org/).

`php composer.phar create-project sqrt-pro/framework:dev-master path/to/install`

## Пояснения

### 1. Полиморфизм. Наследование. Инкапсуляция. Никакой магии.
Фреймворк старается быть максимально незаметным. Нет никаких сложных соглашений, не обязательно читать тонны 
документации. Можно просто взять пример и начать писать проект, при необходимости подключая сторонние компоненты или 
просто замещая части фреймворка, ведь он полностью состоит из 
[подключаемых независимых компонентов](https://packagist.org/users/sqrt-pro/).

При этом, основным способом достижения гибкости и производительности являются три базовых принципа ООП, направленные на 
производство легкого кода, который легко читать и поддерживать, а не на усложнение концепций и многостраничных 
соглашений и мануалов.

### 2. Никаких текстовых конфигов.
Настройка системы производится с помощью вызовов методов, настраивающих окружение, а конфигурирование форм, 
схемы БД и т.п. осуществляется с помощью наследования базовых классов и их дополнительной инициализации. Таким образом 
IDE сама подсказывает доступные опции и шанс опечатки или ошибки довольно невысок. И опять же, не нужно лезть в 
документацию, чтобы посмотреть какие опции есть по этому пункту.

**Пример настройки формы:**

~~~ php
class MyForm extends Form
{
  function init() 
  {
    $this->addInput('name', 'Имя')
      ->addFilter('!^[a-z]+$!i');
    $this->addCheckbox('is_active', 'Вкл');
    $this->addSelect('status', 'Статус')
      ->setOptions(array('new' => 'Новый', 'old' => 'Старый'));
    $this->addFile('image', 'Изображение')
      ->setIsRequired();
  }
}
~~~

### 3. Максимум подсказок в IDE (PHPStorm).
В SQRT Framework если где-либо можно получить объект, по нему с большой вероятностью будет доступен автокомплит, т.к. 
не используются языковые конструкции вида:

    $app['DB']->query()
    Doctrine::getTable('JobeetJob')

Т.к они не позволяют IDE определить, какой именно объект используется и соответственно выдать подсказки для автокомплита. 
Кроме этого, там где необходимо прописаны PHPDoc комментарии `@return` и каждый метод, за исключением совсем очевидных, 
снабжен кратким комментарием, позволяющим понять суть без изучения кода.