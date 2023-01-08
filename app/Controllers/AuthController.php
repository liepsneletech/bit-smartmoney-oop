<?php

namespace app\Controllers;

class AuthController

{
    public function login(): string
    {
        $admins = Application::$usersFileReader->showAll();
        $currentPage = 'Prisijungimas';

        return Application::renderView('login', compact('currentPage'));
    }
}
