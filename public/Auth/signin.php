<?php require_once('../../private/initialize.php'); ?>


<?php include('../../private/signin.php'); ?>
<?php $page_title = 'Home'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>



<div class="wrapper contain">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
        <?php echo $accountNotExistErr; ?>
        <?php echo $emailPwdErr; ?>

    <form action="" method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="username" id="username" />
            <?php echo $email_empty_err; ?>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password"
                   id="password" />
            <?php echo $pass_empty_err; ?>
        </div>

        <button type="submit" name="login" id="sign_in" class="btn btn-outline-primary btn-lg btn-block">Sign
            in</button>
    </form>
</div>
<?php include(SHARED_PATH . '/footer.php'); ?>