<?php

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

<main class="main-login container login-block">

    <div>
        <img src="./assets/img/logo-super-dark.png" alt="SmartMoney logo" class="login-logo">


        <form class="login-form" action="/accounts" method="post">

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