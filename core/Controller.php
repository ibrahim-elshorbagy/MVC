<?php
namespace app\core;
use app\core\Middlewares\BaseMiddleware;
class Controller 
{

    protected array $middlewares = [];
    public string $action= '';
    /* ------------------- Rander the View  ------------------- */

    public function render($view,$params=[])
    {
        return Application::$app->view->renderView($view,$params);
    }

    /* ------------------- Rander layout ------------------- */


    public string $layout ='main';
    
    public function setLayout($layout){
        $this->layout=$layout;
    }

    /* ------------------- Register Middleware ------------------- */

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] =$middleware;
    }

    public function getMiddlewares():array
    {
        return $this->middlewares;
    }
}