<?php

namespace app\Controllers;

use app\Models\FileReader;

class Accounts
{

  public static FileReader $fileReader;

  public function __construct()
  {
    self::$fileReader = new FileReader('users');
  }

  public function login(): string
  {
    $pageTitle = 'Prisijungimas';
    return Application::renderView('login', compact('pageTitle'));
  }

  public function index(): string
  {
    $users = self::$fileReader->showAll();
    $pageTitle = 'Sąskaitų sąrašas';
    $active = 'index';
    return Application::renderView('index', compact('users', 'pageTitle', 'active'));
  }

  public function create(): string
  {
    $pageTitle = 'Nauja sąskaita';
    $active = 'create-acc';
    return Application::renderView('create-acc', compact('pageTitle', 'active'));
  }

  public function save()
  {
    self::$fileReader->create($_POST);
    return Application::redirect('index');
  }

  public function add($id): string
  {
    $user = self::$fileReader->show($id);
    $pageTitle = 'Pridėti lėšas';
    return Application::renderView('add-money', compact('pageTitle', 'user'));
  }

  public function withdraw($id): string
  {
    $user = self::$fileReader->show($id);
    $pageTitle = 'Nuskaičiuoti lėšas';
    return Application::renderView('withdraw-money', compact('pageTitle', 'user'));
  }

  public function update($id)
  {
    self::$fileReader->update($id, $_POST);
    return Application::redirect('accounts');
  }

  public function delete($id): string
  {
    self::$fileReader->delete($id);
    return Application::redirect('index');
  }
}
