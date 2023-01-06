<?php

namespace app\Controllers;

class Application
{
  public static string $root;
  public static Application $app;
  public static Accounts $accounts;

  public function __construct(string $root)
  {
    self::$root = $root;
    self::$app = $this;
    self::$accounts = new Accounts();
  }

  public function resolve()
  {
    $url = explode('/', $_SERVER['REQUEST_URI']);
    array_shift($url);
    return self::router($url);
  }


  private static function router(array $url)
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == 'OPTIONS') {
      header('Access-Control-Allow-Origin: *');
      header('Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE, PUT');
      header("Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With");
      header('Content-Type: application/json');
      return null;
    }

    if (!$url[0] && count($url) === 1 && $method === 'GET') {
      return self::$accounts->index();
    }

    if ($url[0] === 'login' && count($url) === 1 && $method === 'GET') {
      return self::$accounts->login();
    }

    if ($url[0] === 'accounts' && count($url) === 1 && $method === 'GET') {
      return self::$accounts->index();
    }

    if ($url[0] === 'create-acc' && count($url) === 1 && $method === 'GET') {
      return self::$accounts->create();
    }

    if ($url[0] === 'create-acc' && $url[1] === 'save' && count($url) == 2 && $method == 'POST') {
      return self::$accounts->save();
    }

    if ($url[0] === 'add-money' && count($url) == 2 && $method == 'GET') {
      return self::$accounts->add($url[1]);
    }

    if ($url[0] === 'withdraw-money' && count($url) == 2 && $method == 'GET') {
      return self::$accounts->withdraw($url[1]);
    }

    if (($url[0] === 'add-money' || $url[0] === 'withdraw-money') && $url[1] == 'update' && count($url) == 3 && $method == 'POST') {
      return self::$accounts->update($url[2]);
    }

    if ($url[0] === 'delete' && count($url) == 2 && $method == 'POST') {
      return self::$accounts->delete($url[1]);
    }


    return '404 NOT FOUND';
  }

  public static function renderView(string $page, array $params = []): string
  {
    ob_start();
    extract($params);
    require Application::$root . '/views/layouts/header.php';
    require Application::$root . "/views/pages/$page.php";
    return ob_get_clean();
  }

  public static function redirect($url)
  {
    header('Location: ' . self::$root . $url);
    return null;
  }
}
