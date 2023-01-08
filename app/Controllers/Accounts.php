<?php

namespace app\Controllers;

use app\DB\FileReader;

session_start();

class Accounts
{
    public function login(): string
    {
        $currentPage = 'Prisijungimas';
        return Application::renderView('login', compact('currentPage'));
    }

    public function logout(): string
    {
        $currentPage = 'Prisijungimas';
        return Application::renderView('login', compact('currentPage'));
    }

    public function index(): string
    {
        $users = Application::$usersFileReader->showAll();
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
        $user = [
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'iban' => $_POST['iban'],
            'personal-number' => $_POST['personal-number'],
            'balance' => 0
        ];
        Application::$usersFileReader->create($user);
        $_SESSION['success-new-account'] = 'Sąskaita sėkmingai sukurta.';
        return Application::redirect('/accounts');
    }

    public function add($id): string
    {
        $user = Application::$usersFileReader->show($id);
        $currentPage = 'Pridėti lėšas';
        return Application::renderView('add', compact('currentPage', 'user'));
    }

    public function withdraw($id): string
    {
        $user = Application::$usersFileReader->show($id);
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
                $_SESSION['amount-error'] = 'Įveskite validžią sumą.';
                return null;
            }
            if ($amount > 0) {
                $user['balance'] = round($user['balance'] + $amount, 2);

                Application::$usersFileReader->update($id, $user);
                return Application::redirect('/accounts');
            } else {
                return 'Negalima pridėti sumos lygios nuliui.';
            }
        }

        if (isset($_POST['balance-withdraw'])) {
            $user = Application::$usersFileReader->show($id);

            if (preg_match('/^(?:[0-9]*[.])?[0-9]+$/', $_POST['balance-withdraw'])) {
                $amount = (float)$_POST['balance-withdraw'];
            } else {
                return 'Įveskite validžią sumą.';
            }

            if ($amount > $user['balance']) {
                return 'Suma negali būti didesnė už turimas lėšas';
            } else if ($amount > 0) {
                $user['balance'] = round($user['balance'] - $amount, 2);

                Application::$usersFileReader->update($id, $user);
                return Application::redirect('/accounts');
            } else {
                return 'Negalima nuskaičiuoti nulinės sumos.';
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
