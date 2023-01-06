<?php

session_start();

if (isset($_SESSION['error-name'])) {
  $errorName = $_SESSION['error-name'];
  unset($_SESSION['error-name']);
}

if (isset($_SESSION['error-surname'])) {
  $errorSurname = $_SESSION['error-surname'];
  unset($_SESSION['error-surname']);
}

if (isset($_SESSION['error-personal-number'])) {
  $errorPersonalNumber = $_SESSION['error-personal-number'];
  unset($_SESSION['error-personal-number']);
}

if (isset($_SESSION['error-personal-number-exists'])) {
  $errorPersonalNumberExists = $_SESSION['error-personal-number-exists'];
  unset($_SESSION['error-personal-number-exists']);
}

$currentPage = 'create-account';

if (!isset($_SESSION['admin'])) {
  header('Location: http://localhost/smartmoney/login.php?error');
  die;
};

$users = unserialize(file_get_contents(__DIR__ . '/users'));

$ibanValue = rand(0, 9) . rand(0, 9) . ' ' . '0014' . ' ' . '7' . rand(0, 9) . rand(0, 9) . rand(0, 9) . ' ' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9)  . ' ' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if (preg_match('/^([a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+([\s]?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+|[\']?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]*)){4,}$/', $_POST['name'])) {
    $name = $_POST['name'];
  } else {
    $_SESSION['error-name'] = 'Vardas nėra validus.';
    header('Location: http://localhost/smartmoney/create-account.php');
    die;
  }
  if (preg_match('/^([a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+([\s]?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+|[\']?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]*)){4,}$/', $_POST['surname'])) {
    $surname = $_POST['surname'];
  } else {
    $_SESSION['error-surname'] = 'Pavardė nėra validi.';
    header('Location: http://localhost/smartmoney/create-account.php');
    die;
  }

  if (preg_match('/^[1-6]\d{2}(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])\d{4}$/', $_POST['personal-number'])) {
    foreach ($users as $user) {
      if ($user['personal-number'] == (int) $_POST['personal-number']) {
        $_SESSION['error-personal-number-exists'] = 'Toks asmens kodas jau užregistruotas.';
        header('Location: http://localhost/smartmoney/create-account.php');
        die;
      }
    }
  } else {
    $_SESSION['error-personal-number'] = 'Neteisingas asmens kodas.';
    header('Location: http://localhost/smartmoney/create-account.php');
    die;
  }

  $personalNumber = (int) $_POST['personal-number'];

  $newUser = ['id' => rand(1000000, 9999999), 'name' => $name, 'surname' => $surname, 'personal-number' => $personalNumber, 'iban' => $ibanValue, 'balance' => 0];

  $users[] = $newUser;

  file_put_contents(__DIR__ . '/users', serialize($users));

  $_SESSION['success-new-account'] = 'Sėkmingai sukūrėte naują sąskaitą.';


  header('Location: http://localhost/smartmoney/accounts.php');
}

require __DIR__ . './inc/header.php';

?>

<main class=" container">
  <div class="main-inner">
    <h1 class="main-title">Sukurti sąskaitą</h1>


    <!-- <img src="./assets/img/money-ill.png" alt="Money illustration" class="money-pic"> -->
    <form class="registration-form" action="http://localhost/smartmoney/create-account.php" method="post">

      <?= isset($errorName) ? "<p class='error-red'>$errorName</p>" : '' ?>
      <?= isset($errorSurname) ? "<p class='error-red'>$errorSurname</p>" : '' ?>
      <?= isset($errorPersonalNumber) ? "<p class='error-red'>$errorPersonalNumber</p>" : '' ?>
      <?= isset($errorPersonalNumberExists) ? "<p class='error-red'>$errorPersonalNumberExists</p>" : '' ?>

      <input type="text" id="name" placeholder="Vardas*" name="name" required>

      <input type="text" id="surname" placeholder="Pavardė*" name="surname" required>

      <input type="number" id="personal-number" placeholder="Asmens kodas*" name="personal-number" required>

      <input type="text" id="iban" placeholder="IBAN*" name="iban" value="LT <?= $ibanValue ?>" readonly>

      <button type="submit" name="submit" class="btn-main btn-green"><i class="fa-solid fa-user-plus add-person-icon"></i> SUKURTI</button>
    </form>

    <?php if (isset($error)) : ?>
      <div class="warning-red" role="alert"><?= $error ?></div>
    <?php endif ?>
  </div>

</main>
<?php require __DIR__ . './inc/footer.php'; ?>