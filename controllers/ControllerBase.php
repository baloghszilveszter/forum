<?php

class ControllerBase
{
    protected $pdo;

    private $layout = 'main';

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    protected function render($template, $data = [])
    {
        $controller = lcfirst(str_replace('Controller', '', get_called_class()));
        $tmplPath = 'views/'.$controller.'/'.$template.'.php';
        extract($data);
        ob_start();
        if (file_exists($tmplPath)) {
            include($tmplPath);
        } else {
            die('template not found');
        }
        $content = ob_get_contents();
        ob_end_clean();
        return $this->renderLayout($content);
    }

    protected function redirect($url)
    {
        header("Location: $url");
    }

    protected function setLayout($layoutName)
    {
        $this->layout = $layoutName;
    }

    private function renderLayout($content)
    {
        ob_start();
        include('views/layouts/'.$this->layout.'.php');
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    private function getConnection()
    {
        try {
            $dsn = DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            return new PDO($dsn, DB_USER, DB_PASS);
        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }
}
