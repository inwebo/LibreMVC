<h1>Users</h1>
<table>
    <thead>
        <th><td>id</td></th>
    </thead>
</table>
<?php

    foreach($this->users as $k => $v) {
        echo '<tr><td>'.$v->id.'</td></tr>';
    }

?>