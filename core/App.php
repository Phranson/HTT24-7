<?php
class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        if ($url && file_exists('controllers/' . ucfirst(strtolower($url[0])) . '.php')) {
            $this->controller = ucfirst(strtolower($url[0]));
            unset($url[0]);
        } elseif (!$url) {
            $this->controller = 'DashboardController';
        } else {
            header("Location: 404.php");
            exit();
        }
        require_once 'controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                header("Location: 404.php");
                exit();
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return null;
    }
}
