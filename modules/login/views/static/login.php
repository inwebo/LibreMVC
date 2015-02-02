<?php  var_dump($_SESSION['User']->is('Root')) ?>
<?php  var_dump($_SESSION['User']->has('write')) ?>
<?php if(isDefaultUser()) {?>
    <form class="form-signin" method="post" action="login/">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input name="user" type="text" placeholder="Email address" class="form-control">
        <input name="password" type="password" placeholder="Password" class="form-control">
        <label class="checkbox">
            <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
    </form>
<?php } else {?>
    <form class="form-signin" method="post" action="logout/">
        <h2 class="form-signin-heading">Please log out</h2>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Log out</button>
    </form>
<?php } ?>