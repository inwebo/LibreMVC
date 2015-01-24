<H1>Autoloader</H1>
<?php
ini_set('display_errors', 'on');

include('../core/string/class.string.php');
include('../core/autoloader/autoload.php');

use LibreMVC\Autoloader\ClassInfos;
use LibreMVC\Modules\Foo;

$class = new ClassInfos("\\test");
var_dump(assert($class->isNamespaced()===true));

$class = new ClassInfos("test");
var_dump(assert($class->isNamespaced()===false));

$class = new ClassInfos("test");
var_dump(assert($class->getVendor()===null));

$class = new ClassInfos("LibreMVC\\test");
var_dump(assert($class->getVendor()==="LibreMVC"));

$class = new ClassInfos("\\LibreMVC\\test");
var_dump(assert($class->getVendor()==="LibreMVC"));

$class = new ClassInfos("test");
var_dump(assert($class->toAbsolute()==="\\test"));

$class = new ClassInfos("\\test");
var_dump(assert($class->toAbsolute()==="\\test"));

$class = new ClassInfos("\\test");
var_dump(assert($class->toArray()===array('test')));

$class = new ClassInfos("\\LibreMVC\\test");
var_dump(assert($class->toArray()===array('LibreMVC','test')));

$class = new ClassInfos("\\LibreMVC\\test");
var_dump(assert($class->getClassName()==='test'));

// Decorator
$d = new \LibreMVC\Autoloader\Decorators('../core');
//$e = new \LibreMVC\Autoloader\Decorators('../core','autoload.php');

\LibreMVC\Autoloader\Handler::addDecorator($d);
//\LibreMVC\Autoloader\Handler::addDecorator($e);


\LibreMVC\Autoloader\Handler::handle("LibreMVC\\Img");
\LibreMVC\Autoloader\Handler::handle("\\Img");

$class = new ClassInfos('LibreMVC\\Modules\\Foo');
var_dump(assert($class->getVendor(2)==="LibreMVC\\Modules"));
$e = new \LibreMVC\Autoloader\Decorators('/home/inwebo/www/libre',2);
\LibreMVC\Autoloader\Handler::addDecorator($e);
\LibreMVC\Autoloader\Handler::handle("LibreMVC\\Modules\\Foo");

spl_autoload_register("\\LibreMVC\\Autoloader\\Handler::handle");

$f = new Foo\Core\Foo();
$b = new Foo\Core\Bar();