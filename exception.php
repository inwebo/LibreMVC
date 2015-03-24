<?php
$exception = $this->_vo->exception;
$trace     = $exception->getTrace();
$deltaSrc  = 15;
//var_dump($exception);
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<h1><?php echo get_class($exception) ?></h1>
<p>file : <?php echo $exception->getFile(); ?> @ line <?php echo $exception->getLine(); ?></p>
<h2>Message</h2>
<pre>
<?php echo $exception->getMessage(); ?>
</pre>
<h2>Trace</h2>
<p>
    <?php for($i=0;$i<count($trace);$i++) { ?>
        <a href="#trace-<?php echo $i ?>"><?php echo $i ?></a>,
    <?php } ?>
</p>
<ol start="0">
    <?php $loop = 0 ?>
    <?php foreach($trace as $item) { ?>
        <li id="trace-<?php echo $loop++?>">
            <table border="1" width="100%">
                <tr>
                    <td><?php echo isset($item['file']) ? $item['file'] : '-'; ?></td>
                    <td>@</td>
                    <td><?php echo isset($item['line']) ? $item['line'] : '-'; ?></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php echo isset($item['class']) ? $item['class'] : ''; ?>
                        <?php echo isset($item['type']) ? $item['type'] : ''; ?>
                        <?php echo isset($item['function']) ? $item['function'] : ''; ?>()
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php if( isset($item['args']) ){ ?>
                            <pre><?php var_dump($item['args']) ?></pre>
                        <?php }else{ ?>
                            &nbsp;
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                    <?php if( isset($item['file']) && isset($item['line']) ){ ?>
                        <?php
                            $lines = file($item['file']);
                            $lines = array_slice($lines, $item['line'] - $deltaSrc, $deltaSrc*2);
                            $start =  $item['line'] - $deltaSrc;
                            $start = ($start<=0) ? 1 : $start;
                        ?>
                            <table width="100%"><tr><td>Line</td><td>Source</td></tr>
                            <?php
                                for($i = 0; $i < count($lines); $i++) {
                                    $src = str_replace(array('&lt;?php','?&gt;'),array('',''),highlight_string( '<?php'.$lines[$i].'?>', true));
                                    ?>
                                    <tr <?php echo ($i===$deltaSrc) ? ' style="background-color:whitesmoke" ' : '' ?>>
                                        <td><?php echo $start++; ?></td>
                                        <td><?php echo $src; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                    <?php }else{ ?>
                        &nbsp;
                    <?php } ?>
                    </td>
                </tr>
            </table>
        </li>
    <?php } ?>
</ol>
<?php var_dump($exception); ?>
</body>
</html>