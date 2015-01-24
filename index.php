<?php
    ini_set('display_errors', 'on');
    include('core/autoloader/autoload.php');
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Test</title>
    <base href="http://localhost/libre/" >
</head>
<body>
<h1>LibreMVC 2.0</h1>
<?php
$t = glob('tests/*.php');
foreach($t as $v) { ?>
    <a href="<?php echo $v ?>"><?php echo $v ?></a><br>
    <?php } ?>
</body>
</html>