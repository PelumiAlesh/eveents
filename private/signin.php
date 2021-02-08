<?php
global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $verificationRequiredErr, $email_empty_err, $pass_empty_err, $db;

if(isset($_POST['login'])) {
    $username_signin        = $_POST['username'];
    $password_signin     = SHA1($_POST['password']);
    $unHashed_password     = $_POST['password'];

    // clean data
    $user_email = filter_var($username_signin, FILTER_SANITIZE_EMAIL);
    $pswd = mysqli_real_escape_string($db, $password_signin);

    // Query if email exists in db
    $sql = "SELECT * From users WHERE username = '{$username_signin}' ";
    $query = mysqli_query($db, $sql);
    $rowCount = mysqli_num_rows($query);

    // If query fails, show the reason
    if(!$query){
        die("SQL query failed: " . mysqli_error($db));
    }

    if(!empty($username_signin) && !empty(trim($unHashed_password))) {
        // Check if email exist
        if($rowCount <= 0) {
            $accountNotExistErr = '<div class="alert alert-danger">
                        User account does not exist.
                    </div>';
        } else {
            // Fetch user data and store in php session
            while($row = mysqli_fetch_array($query)) {
                $id            = $row['id'];
                $username         = $row['username'];
                $pass_word     = $row['password'];
                $isAdmin     = $row['isAdmin'];
            }

            // Verify password
            $password = password_verify($password_signin, $pass_word);

            if($username_signin == $username && $password_signin == $pass_word) {
                header("Location: /admin/events.php");

                $_SESSION['id'] = $id;
                $_SESSION['email'] = $username;
                $_SESSION['isAdmin'] = $isAdmin;
            } else {
                $emailPwdErr = '<div class="alert alert-danger">
                              Either email or password is incorrect.
                          </div>';
            }


        }

    } else {
        if(empty($username_signin)){
            $email_empty_err = "<div class='alert alert-danger email_alert'>
                            Email not provided.
                    </div>";
        }

        if(empty(trim($unHashed_password ))){
            $pass_empty_err = "<div class='alert alert-danger email_alert'>
                            Password not provided.
                        </div>";
        }
    }

}