<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    header('Location: http://localhost/smartmoney/login.php');
    die;
  }

  $admins = unserialize(file_get_contents(__DIR__ . './admins'));
  foreach ($admins as $admin) {
    if ($admin['email'] === $_POST['email']) {
      if ($admin['pass'] === md5($_POST['pass'])) {
        $_SESSION['admin'] = $admin;
        header('Location: http://localhost/smartmoney/accounts.php');
        die;
      }
    }
  }
  header('Location: http://localhost/smartmoney/login.php?error');
  die;
}

if (isset($_GET['error'])) {
  $error = 'Neteisingas el. paštas arba slaptažodis! Bandykite dar kartą.';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN | SmartMoney</title>
  <link href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/custom.css">
</head>

<body>

  <main class="main-login container login-block">

    <div>
      <img src="./assets/img/logo-super-dark.png" alt="SmartMoney logo" class="login-logo">

      <form class="login-form" action="http://localhost/smartmoney/login.php" method="post">

        <div>
          <input type="email" id="email" placeholder="Įrašykite el. paštą" name="email">
        </div>
        <div>
          <input type="password" id="pass" placeholder="Įrašykite slaptažodį" name="pass">
        </div>

        <button type="submit" class="btn-main btn-green btn-submit">Prisijungti</button>
      </form>

      <p class="bank-name">SmartMoney</p>

      <?php if (isset($error)) : ?>
        <div class="error-red"><?= $error ?></div>
      <?php endif ?>

    </div>

  </main>

  <?php require __DIR__ . './inc/footer.php'; ?>