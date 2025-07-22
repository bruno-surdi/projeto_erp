<?php
declare(strict_types=1);

namespace core\controllers;

class Controller
{
    public function model($model)
    {
        $model = "core\\models\\$model.php";
        return new $model();
    }

    public function view($view, $data = [])
    {
        require_once "views/$view.php";
    }
}
