<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smartmoney</title>
  <link href="/node_modules/@fortawesome/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="">
</head>

<body>

  <header class="header">
    <div class="header-content-box container">
      <a href="http://localhost/smartmoney/accounts.php"><img src="./assets/img/logo-dark+.png" alt="SmartMoney logo" class="header-logo-desktop"><img src="./assets/img/logo-dark-mobile.png" alt="SmartMoney logo" class="header-logo-mobile"></a>

      <nav class="main-nav">
        <a class="nav-link <?= $currentPage === 'accounts' ? 'active' : '' ?>" href="http://localhost/smartmoney/accounts.php">Sąskaitos</a>
        <a class="nav-link <?= $currentPage === 'create-account' ? 'active' : '' ?>" href="http://localhost/smartmoney/create-account.php">Sukurti sąskaitą</a>
        <form method="post" action="http://localhost/smartmoney/login.php?logout" class="d-inline-block">
          <button type="submit" class="nav-link logout-btn">Atsijungti<i class="fa-solid fa-arrow-right-from-bracket logout-icon"></i></button>
        </form>
      </nav>
    </div>
  </header>

  {{content}}

  <footer class="footer">

    Visos teisės saugomos &copy; <?php echo date("Y"); ?>

  </footer>

</body>

</html>