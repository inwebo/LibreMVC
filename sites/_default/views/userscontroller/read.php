<h1>Users</h1>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <table class="">
            <thead>
            <tr>
                <th>#</th>
                <th>id_role</th>
                <th>login</th>
                <th>password</th>
                <th>mail</th>
                <th>passPhrase</th>
                <th>publicKey</th>
                <th>privateKey</th>
                <th>Roles</th>
                <th>permissions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($this->users as $k => $v) {
                ?>
                <tr>
                    <td><?php echo $v->id ?></td>
                    <td><?php echo $v->id_role ?></td>
                    <td><?php echo $v->login ?></td>
                    <td><?php echo $v->password ?></td>
                    <td><?php echo $v->mail ?></td>
                    <td><?php echo $v->passPhrase ?></td>
                    <td><?php echo $v->publicKey ?></td>
                    <td><?php echo $v->privateKey ?></td>
                    <td><?php print_r( $v->Roles) ?></td>
                    <td><?php print_r( $v->permissions) ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
</div>