<h2>Base url</h2>
<?php
echo \LibreMVC\Http\Context::getBaseUrl();
?>

<h2>Request</h2>
<?php
    var_dump(\LibreMVC\Views\Template\ViewBag::get()->request);
?>
<h2>Instance</h2>
<?php
var_dump(\LibreMVC\Views\Template\ViewBag::get()->instance);
?>

<a href="~/">Instance root</a>
<br>
<a href="#/">default root</a>