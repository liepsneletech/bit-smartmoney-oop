<main class=" container">
    <div class="main-inner">
        <h1 class="main-title">Sukurti sąskaitą</h1>

        <!--        <img src="./assets/img/money-ill.png" alt="Money illustration" class="money-pic">-->
        <form class="registration-form" action="/create-account/save" method="post">

            <?= isset($errorName) ? "<p class='error-red'>$errorName</p>" : '' ?>
            <?= isset($errorSurname) ? "<p class='error-red'>$errorSurname</p>" : '' ?>
            <?= isset($errorPersonalNumber) ? "<p class='error-red'>$errorPersonalNumber</p>" : '' ?>
            <?= isset($errorPersonalNumberExists) ? "<p class='error-red'>$errorPersonalNumberExists</p>" : '' ?>

            <input type="text" id="name" placeholder="Vardas*" name="name" required>

            <input type="text" id="surname" placeholder="Pavardė*" name="surname" required>

            <input type="number" id="personal-number" placeholder="Asmens kodas*" name="personal-number" required>

            <input type="text" id="iban" placeholder="IBAN*" name="iban" value="<?= generateIBAN($users) ?>"
                   readonly>

            <button type="submit" name="submit" class="btn-main btn-green"><i
                        class="fa-solid fa-user-plus add-person-icon"></i> SUKURTI
            </button>
        </form>

        <?php if (isset($error)) : ?>
            <div class="warning-red" role="alert"><?= $error ?></div>
        <?php endif ?>
    </div>

</main>
