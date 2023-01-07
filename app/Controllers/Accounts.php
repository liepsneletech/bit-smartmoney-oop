<?php

namespace app\Controllers;

use app\DB\FileReader;

class Accounts
{
    public function login(): string
    {
        $currentPage = 'Prisijungimas';
        return Application::renderView('login', compact('currentPage'));
    }

    public function logout(): string
    {
        $pageTitle = 'Prisijungimas';
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
        return Application::renderView('create-account', compact('currentPage', 'active'));
    }

    public function save()
    {
        $user = [
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'iban' => $_POST['iban'],
            'personal-number' => $_POST['id'],
            'balance' => 0
        ];
        Application::$usersFileReader->create($user);
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
        if (isset($_POST['balance'])) {
            $user = Application::$usersFileReader->show($id);

            if (preg_match('/^(?:[0-9]*[.])?[0-9]+$/', $_POST['balance'])) {
                $amount = (float)$_POST['balance'];
            } else {
                return 'Negalima suma';
            }
        }

        if (isset($_POST['withdraw_amount'])) {
            $user = Application::$usersFileReader->show($id);

            if (preg_match('/^(?:[0-9]*[.])?[0-9]+$/', $_POST['withdraw_amount'])) {
                $amount = (float)$_POST['withdraw_amount'];
            } else {
                return 'Nevalidi suma';
            }

            if ($amount > $user['money']) {
                return 'Suma viršija turimas lėšas';
            } else if ($amount > 0) {
                $user['money'] = round($user['money'] - $amount, 2);

                Application::$usersFileReader->update($id, $user);
                return Application::redirect('/accounts');
            } else {
                return 'Negalima nuskaičiuoti nulinės';
            }
        }
    }


    public function delete($id)
    {
        $user = Application::$usersFileReader->show($id);
        if ($user['money'] == 0) {
            Application::$usersFileReader->delete($id);
            return Application::redirect('/accounts');
        } else {
            return 'Sąskaitos, kurioje yra lėšų, ištrinti negalima.';
        }
    }

    public function error(): string
    {
        $currentPage = '404';
        return Application::renderView('error', compact('currentPage'));
    }
}
