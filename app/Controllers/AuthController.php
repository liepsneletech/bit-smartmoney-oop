<?php

namespace app\Controllers;

class AuthController

{
    public function login(): string
    {
        $currentPage = 'Prisijungimas';
        return Application::renderView('login', compact('currentPage'));
    }

    public function logout(): string
    {
        $admins = Application::$adminsFileReader->showAll();

        foreach ($admins as $admin) {
            if ($admin['email'] === $_POST['email']) {
                if ($admin['pass'] === md5($_POST['pass'])) {
                    $_SESSION['admin'] = $admin;
                    Application::redirect('/accounts');
                }
            }
        }

        return Application::redirect('/login');

    }
}