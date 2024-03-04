<?php
namespace app\core; 


class View {
    public string $title='';

    /* ------------------- Rander the View ------------------- */

    public function renderView($view,$params=[]){ //the main Render function
        
        $viewContent=$this->renderOnlyView($view,$params);
        $layoutContent =$this->layoutContent();

        return str_replace('{{content}}',$viewContent,$layoutContent);
    }


    public function layoutContent() //get the layoute
    {
        $layout =Application::$app->layout;
        if(Application::$app->controller)
            {
            $layout = Application::$app->controller->layout; 
            }
        ob_start();
        include_once Application::$ROOT_DIR ."/views/layouts/$layout.php";
        return ob_get_clean();

    }

    protected function renderOnlyView($view,$params){ //get the content

        foreach($params as $key=>$value)           
        { 
            // params ['name'=>'Perfect Site']
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR ."/views/$view.php";
        return ob_get_clean();
    }

        public function renderContent($viewContent){ //Render just the layoute

        $layoutContent =$this->layoutContent();
        return str_replace('{{content}}',$viewContent,$layoutContent);

    }

    /* ------------------------------------------------------- */

}