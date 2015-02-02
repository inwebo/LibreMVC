<?php if(user()->is('Root')) { ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<h1>Admin</h1>
<a href="http://localhost/libremvc/tests/">tests</a>
<?php $this->renderPartial('body'); ?>
</body>
</html>
<?php } ?>
