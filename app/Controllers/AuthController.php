<?php

namespace app\Controllers;

class AuthController

{
    public function login(): string
    {
        $currentPage = 'Prisijungimas';
        $admins = Application::$adminsFileReader->showAll();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return Application::renderView('login', compact('currentPage'));
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($admins as $admin) {
                if ($admin['email'] === $_POST['email']) {
                    if ($admin['pass'] === md5($_POST['pass'])) {
                        $_SESSION['admin'] = $admin;
                    }
                } else {
                    $_SESSION['error'] = 'Neteisingas el. paštas arba slaptažodis!';
                }
            }
        }
        return Application::redirect('/accounts');
    }

    public function logout(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            session_unset();
            session_destroy();
            return Application::redirect('/login');
        }

    }
}