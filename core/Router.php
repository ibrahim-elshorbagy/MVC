<?php
namespace app\core;

use app\core\exception\ForbiddenException;
use app\core\exception\NotFoundException;

class Router
{


    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request,Response $response)
    {
        $this->request =$request;
        $this->response =$response;
    }

    /* ------------------- indxing paths ------------------- */

    public function get($path,$callback){ //store paths from index

        $this->routes['get'][$path]=$callback;
    }

    public function post($path,$callback)
    {
        $this->routes['post'][$path]=$callback;
    }

    /* ------------------- Resolve the path ------------------- */

    public function reslove(){ 
    
        //get path info from request.php
        $path = $this->request->getPath();
        $method = $this->request->method();

        //get the callback from the array
        
        $callback =$this->routes[$method][$path] ?? false;

        //opening the page

        if($callback === false)
        {
            

            throw new NotFoundException(); // this or this
            return Application::$app->view->renderView('_404');

            
        }


        if(is_string($callback))
        {
            
            return Application::$app->view->renderView($callback);
        } 

        if (is_array($callback)) //[Controller_class/Method]
        {

            Application::$app->controller =new $callback[0];
            Application::$app->controller->action = $callback[1];
            $callback[0]=Application::$app->controller;
            
            foreach(Application::$app->controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }


        return call_user_func($callback,$this->request,$this->response);
    }


}