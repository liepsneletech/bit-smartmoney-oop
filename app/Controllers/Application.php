<?php

namespace app\Controllers;

class Application
{
  public static string $root;
  public static Application $app;
  public Router $router;
  private Controller $controller;

  public function __construct(string $root)
  {
    self::$root = $root;
    self::$app = $this;
    $this->router = new Router();
  }

  public function resolve(): void
  {
    $method = $this->router->getMethod();
    $path = $this->router->getPath();
    $action = $this->router->getRoute($method, $path);

    if (!$action) {
      // Todo: setStatusCode();
      echo '404 Not Found';
    }

    $this->setController($action[0]);
    $action[0] = $this->getController();
    call_user_func($action);
  }

  public function setController(string $controller): void
  {
    $this->controller = new $controller;
  }

  public function getController(): Controller
  {
    return $this->controller;
  }
}
