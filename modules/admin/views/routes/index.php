<h3>Routes home</h3>
<table>
    <tr>
        <td>#</td>
        <td>Name</td>
        <td>Pattern</td>
        <td>Controller</td>
        <td>Action</td>
        <td>Params</td>
    </tr>
    <?php $current = $this->routed; ?>
    <tr>
        <td> >>> </td>
        <td><?php echo (is_null($current->name)) ? '-' : $current->name ; ?></td>
        <td><?php echo (is_null($current->pattern)) ? '-' : $current->pattern ; ?></td>
        <td><?php echo (is_null($current->controller)) ? '-' : $current->controller ; ?></td>
        <td><?php echo (is_null($current->action)) ? '-' : $current->action ; ?></td>
        <td><pre><code>-</code></pre></td>
    </tr>
<?php
$i = 0;

while($this->routes->getRoutes()->routes->valid()) {
    //var_dump($this->routes->getRoutes()->routes->current());
    $current = $this->routes->getRoutes()->routes->current();

?>
    <tr>
    <td><?php echo ++$i ?></td>
    <td><?php echo (is_null($current->name)) ? '-' : $current->name ; ?></td>
    <td><?php echo (is_null($current->pattern)) ? '-' : $current->pattern ; ?></td>
    <td><?php echo (is_null($current->controller)) ? '-' : $current->controller ; ?></td>
    <td><?php echo (is_null($current->action)) ? '-' : $current->action ; ?></td>
    <td><pre><code>-</code></pre></td>
    </tr>
<?php
    $this->routes->getRoutes()->routes->next();
}
?>



</table>
