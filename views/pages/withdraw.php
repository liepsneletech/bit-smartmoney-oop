<main class="container ">
    <div class="main-inner">
        <h1 class="main-title">Išimti lėšų iš sąskaitos</h1>

        <form action="http://localhost/smartmoney/withdrawal.php?id=<?= $id ?>" method="post"
              class="money-operation-box">
            <?= isset($errorAmount) ? "<p class='error-red'>$errorAmount</p>" : '' ?>


            <p class="full-name"><i class="fa-solid fa-user-large person-icon"></i>
                <?= $user['name'] . ' ' . $user['surname'] ?></p>
            <strong>Sąskaitos likutis: <?= number_format($user['balance'], 2, ',', ' ') ?> &euro;</strong>
            <input type="text" name="balance" placeholder="Įrašykite sumą">
            <button type="submit" class="btn-main btn-yellow" name="withdraw">PATVIRTINTI</button>
            <div class="img-box"><img src="../../assets/img/withdraw-money-pic.png" alt="Withdraw money"
                                      class="withdraw-money-pic">
            </div>
        </form>
    </div>
</main>
