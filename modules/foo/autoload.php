<?php
use LibreMVC\Autoloader\Handler;
use LibreMVC\Autoloader\Decorators;

Handler::addDecorator(new Decorators('..',2));

echo getcwd();

new \LibreMVC\Modules\Foo\Core\Foo();
new \LibreMVC\Modules\Foo\Core\Bar\Bar();