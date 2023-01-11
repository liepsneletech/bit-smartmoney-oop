<?php

namespace app\Controllers;

class Accounts
{
    public function index(): string
    {
        $users = Application::$usersFileReader->showAll();

        foreach ($users as $user) {
            $arrOfSurnames[] = $user['surname'];
        }
        array_multisort($arrOfSurnames, SORT_ASC, $users);
        $currentPage = 'Sąskaitų sąrašas';
        $active = 'index';
        return Application::renderView('index', compact('users', 'currentPage', 'active'));
    }

    public function create(): string
    {
        $users = Application::$usersFileReader->showAll();
        $currentPage = 'Sąskaitos kūrimas';
        $active = 'create-account';
        return Application::renderView('create-account', compact('users', 'currentPage', 'active'));
    }

    public function save()
    {
        $users = Application::$usersFileReader->showAll();
        $user = [
            'iban' => $_POST['iban'],
            'balance' => 0
        ];

        if (preg_match('/^([a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+([\s]?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+|[\']?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]*)){4,}$/', $_POST['name'])) {
            $user['name'] = $_POST['name'];
        } else {
            $_SESSION['error-name'] = 'Vardas nėra validus.';
            return Application::redirect('/create-account');
        }
        if (preg_match('/^([a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+([\s]?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+|[\']?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]*)){4,}$/', $_POST['surname'])) {
            $user['surname'] = $_POST['surname'];
        } else {
            $_SESSION['error-surname'] = 'Pavardė nėra validi.';
            return Application::redirect('/create-account');
        }
        if (preg_match('/^[1-6]\d{2}(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])\d{4}$/', $_POST['personal-number']) &&
            validatePersonalNum($users, $_POST['personal-number'])) {
            $user['personal-number'] = $_POST['personal-number'];
        } else {
            $_SESSION['error-personal-number'] = 'Toks asmens kodas jau egzistuoja.';
            return Application::redirect('/create-account');
        }

        Application::$usersFileReader->create($user);
        $_SESSION['success-new-account'] = 'Sąskaita sėkmingai sukurta.';
        return Application::redirect('/accounts');
    }

    public function add($id): string
    {
        $user = Application::$usersFileReader->show($id);
        if (!$user) {
            return $this->error();
        }
        $currentPage = 'Pridėti lėšas';
        return Application::renderView('add', compact('currentPage', 'user'));
    }

    public function withdraw($id): string
    {
        $user = Application::$usersFileReader->show($id);
        if (!$user) {
            return $this->error();
        }
        $currentPage = 'Lėšų nuskaičiavimas';
        return Application::renderView('withdraw', compact('currentPage', 'user'));
    }

    public function update($id)
    {
        if (isset($_POST['balance-add'])) {
            $user = Application::$usersFileReader->show($id);

            if (preg_match('/^(?:[0-9]*[.])?[0-9]+$/', $_POST['balance-add'])) {
                $amount = (float)$_POST['balance-add'];
            } else {
                $_SESSION['error-amount'] = 'Įveskite validžią sumą.';
                return Application::redirect("/add/$id");
            }
            if ($amount > 0) {
                $user['balance'] = round($user['balance'] + $amount, 2);
                $_SESSION['success-add'] = 'Sėkmingai pridėjote lėšų.';
                Application::$usersFileReader->update($id, $user);
                return Application::redirect('/accounts');
            } else {
                $_SESSION['error-amount-add-zero'] = 'Negalima pridėti nulinės sumos.';
                return Application::redirect("/add/$id");
            }
        }

        if (isset($_POST['balance-withdraw'])) {
            $user = Application::$usersFileReader->show($id);

            if (preg_match('/^(?:[0-9]*[.])?[0-9]+$/', $_POST['balance-withdraw'])) {
                $amount = (float)$_POST['balance-withdraw'];
            } else {
                $_SESSION['error-amount'] = 'Įveskite validžią sumą';
                return Application::redirect("/withdraw/$id");
            }

            if ($amount > $user['balance']) {
                $_SESSION['error-amount-withdraw-too-much'] = 'Suma negali būti didesnė už lėšas.';
                return Application::redirect("/withdraw/$id");
            } else if ($amount > 0) {
                $user['balance'] = round($user['balance'] - $amount, 2);
                $_SESSION['success-withdraw'] = 'Sėkmingai minusavote lėšas.';
                Application::$usersFileReader->update($id, $user);
                return Application::redirect('/accounts');
            } else {
                $_SESSION['error-amount-add-zero'] = 'Negalima atimti nulinės sumos.';
                return Application::redirect("/add/$id");
            }
        }
    }

    public function delete($id)
    {
        $user = Application::$usersFileReader->show($id);
        if ($user['balance'] == 0) {
            Application::$usersFileReader->delete($id);
            $_SESSION['success-delete'] = 'Sąskaita sėkmingai ištrinta.';
            return Application::redirect('/accounts');
        } else {
            $_SESSION['error-delete'] = 'Negalima ištrinti sąskaitos, kurioje yra lėšų.';
            return Application::redirect('/accounts');
        }
    }

    public function error(): string
    {
        $currentPage = '404';
        return Application::renderView('error', compact('currentPage'));
    }
}
