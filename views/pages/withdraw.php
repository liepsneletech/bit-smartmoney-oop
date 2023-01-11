<?php

if (isset($_SESSION['error-amount'])) {
    $errorAmount = $_SESSION['error-amount'];
    unset($_SESSION['error-amount']);
}

if (isset($_SESSION['error-amount-withdraw-zero'])) {
    $errorAmount = $_SESSION['error-amount-withdraw-zero'];
    unset($_SESSION['error-amount-withdraw-zero']);
}

if (isset($_SESSION['error-amount-withdraw-too-much'])) {
    $errorAmount = $_SESSION['error-amount-withdraw-too-much'];
    unset($_SESSION['error-amount-withdraw-too-much']);
}

?>

<main class="container ">
    <div class="main-inner">
        <h1 class="main-title">Išimti lėšų iš sąskaitos</h1>

        <form action="/withdraw/update/<?= $user['id'] ?>" method="post"
              class="money-operation-box">
            <?= isset($errorAmount) ? "<p class='error-red'>$errorAmount</p>" : '' ?>


            <p class="full-name"><i class="fa-solid fa-user-large person-icon"></i>
                <?= $user['name'] . ' ' . $user['surname'] ?></p>
            <strong>Sąskaitos likutis: <?= number_format($user['balance'], 2, ',', ' ') ?> &euro;</strong>
            <input type="text" name="balance-withdraw" placeholder="Įrašykite sumą">
            <button type="submit" class="btn-main btn-yellow" name="withdraw">PATVIRTINTI</button>
            <div class="img-box"><img src="../../assets/img/withdraw-money-pic.png" alt="Withdraw money"
                                      class="withdraw-money-pic">
            </div>
        </form>
    </div>
</main>
