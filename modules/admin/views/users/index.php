<table border="solid" style="display:block;width: 100%">
    <tr>
        <td>id</td>
        <td>login</td>
        <td>Mail</td>
        <td>password</td>
        <td>passPhrase</td>
        <td>Public key</td>
        <td>Private key</td>
        <td>Roles</td>
        <td>Permissions</td>
    </tr>
<?php while($this->users->valid()) { ?>
<?php $user = $this->users->current(); ?>
<?php $roles = $this->users->current()->getRoles(); ?>
<tr>
    <td><?php echo $user->id ?></td>
    <td><?php echo $user->login ?></td>
    <td><?php echo $user->mail ?></td>
    <td><?php echo $user->password ?></td>
    <td><?php echo $user->passPhrase ?></td>
    <td><?php echo $user->publicKey ?></td>
    <td><?php echo $user->privateKey ?></td>
    <td>
        <table border>
            <tr>
                <td>id</td>
                <td>role</td>
            </tr>
            <?php while($roles->valid()) { ?>
                <?php $role = $roles->current(); ?>
                <td><?php echo $role->id?></td>
                <td><?php echo $role->type?></td>
                <td></td>
            <?php $roles->next();} ?>
        </table>
    </td>
    <td>
        <table border>
            <tr>
                <td>id</td>
                <td>name</td>
            </tr>
            <?php $roles->rewind() ?>
            <?php while($roles->valid()) { ?>
                <?php $role = $roles->current(); ?>
                <?php $permissions = $roles->current()->getPermissions(); ?>
                    <?php while($permissions->valid()) { ?>
                    <?php $permission = $permissions->current(); ?>
                    <td><?php echo $permission->id ?></td>
                    <td><?php echo $permission->name ?></td>
                    <?php $permissions->next();} ?>
                <?php $roles->next();} ?>
        </table>
    </td>
</tr>
<?php $this->users->next() ?>
<?php } ?>
</table>