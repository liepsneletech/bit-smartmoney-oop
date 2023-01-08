<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartmoney | <?= $currentPage ?></title>
    <!-- fontawesome -->
    <link href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- styles -->
    <link rel="stylesheet" href="../../assets/css/custom.css">
</head>

<body>

<?php if (isset($currentPage) && $currentPage !== 'Prisijungimas' && $currentPage !== '404') : ?>
<header class="header">

    <div class="header-content-box container">
        <a href="/"><img src="../../assets/img/logo-dark+.png" alt="SmartMoney logo" class="header-logo-desktop"><img
                    src="../../assets/img/logo-dark-mobile.png" alt="SmartMoney logo" class="header-logo-mobile"></a>
        <nav class="main-nav">
            <a class="nav-link <?= $active === 'index' ? 'active' : '' ?>" href="/accounts">Sąskaitos</a>
            <a class="nav-link <?= $active === 'create-account' ? 'active' : '' ?>" href="/create-account">Sukurti
                sąskaitą</a>
            <form method="post" action="/login" class="d-inline-block">
                <button type="submit" class="nav-link logout-btn">Atsijungti<i
                            class="fa-solid fa-arrow-right-from-bracket logout-icon"></i></button>
            </form>
        </nav>
    </div>

</header>
<?php endif ?>