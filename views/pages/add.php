<main class="container">
    <div class="main-inner">
        <h1 class="main-title">Įnešti lėšų į sąskaitą</h1>

        <form action="/add/update/<?= $user['id'] ?>" method="post" class="money-operation-box">
            <?= isset($errorAmount) ? "<p class='error-red'>$errorAmount</p>" : '' ?>

            <p class="full-name"><i class="fa-solid fa-user-large person-icon"></i>
                <?= $user['name'] . ' ' . $user['surname'] ?></p>
            <strong>Sąskaitos likutis: <?= number_format($user['balance'], 2, ',', ' ') ?> &euro;</strong>
            <input type="text" name="balance-add" placeholder="Įrašykite sumą">
            <button type="submit" class="btn-main btn-green" name="add">PATVIRTINTI</button>
            <div class="img-box"><img src="../../assets/img/add-money-pic.png" alt="Add money" class="add-money-pic">
            </div>
        </form>
    </div>

</main>