<?php
  if(!isset($page_title)) { $page_title = 'Staff Area'; }
$logged_in = check_login_status();

function runMyFunction()
{
    session_destroy();
}

if (isset($_GET['logout'])) {
    runMyFunction();
}

?>

<!doctype html>

<html lang="en">
  <head>
    <title>Eveeents - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="/stylesheets/style.css" />
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <link ref="stylesheet" type="text/css" href="stylesheet/snackbar.min.css" />
  </head>

  <body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
      <a class="navbar-brand" href="/index.php">Logo</a>
      <form class="form-inline" action="/action_page.php">
          <input class="form-control mr-sm-2" type="text" placeholder="Search">
          <button class="btn btn-success" type="submit">Search</button>
      </form>

      <ul class="nav navbar-nav navbar-right">
         <?= $logged_in ? '<li><a href="index.php?logout=true"  class="navbar-link navbar-text navbar-right"><span class="glyphicon glyphicon-user"></span> Logout</a></li>' : '<li><a href="/Auth/signin.php" class="navbar-link navbar-text"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>' ?>
      </ul>
  </nav>
