<?php

namespace app\Controllers;

use app\DB\FileReader;

class Accounts
{

  public static FileReader $fileReader;

  public function __construct()
  {
    self::$fileReader = new FileReader('users');
  }

  public function login(): string
  {
    $currentPage = 'Prisijungimas';
    return Application::renderView('login', compact('currentPage'));
  }

  public function index(): string
  {
    $users = self::$fileReader->showAll();
    $currentPage = 'Sąskaitų sąrašas';
    $active = 'index';
    return Application::renderView('index', compact('users', 'currentPage', 'active'));
  }

  public function create(): string
  {
    $currentPage = 'Sąskaitos kūrimas';
    $active = 'create-account';
    return Application::renderView('create-account', compact('currentPage', 'active'));
  }

  public function save()
  {
    self::$fileReader->create($_POST);
    return Application::redirect('index');
  }

  public function add($id): string
  {
    $user = self::$fileReader->show($id);
    $currentPage = 'Lėšų įnešimas';
    return Application::renderView('add', compact('currentPage', 'user'));
  }

  public function withdraw($id): string
  {
    $user = self::$fileReader->show($id);
    $currentPage = 'Lėšų nuskaičiavimas';
    return Application::renderView('withdraw', compact('currentPage', 'user'));
  }

  public function update($id)
  {
    self::$fileReader->update($id, $_POST);
    return Application::redirect('accounts');
  }

  public function delete($id)
  {
    self::$fileReader->delete($id);
    return Application::redirect('index');
  }
}
