<?php
    $packages = glob('*.php');
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<h1>Framework</h1>
<ul>
<?php foreach($packages as $p) { ?>

        <li><a href="<?php echo $p ?>"><?php if($p !== '.' || $p !== '..' || $p !== 'index.php') { echo $p;          }        ?></a></li>

<?php } ?>
</ul>
</body>
</html>