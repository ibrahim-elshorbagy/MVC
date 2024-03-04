<?php
namespace app\core; 
use app\core\db\Database;
use app\core\db\DbModel;
class Application
{


    public static string $ROOT_DIR;
    public static Application $app;   

    public string $userClass;

    public string $layout ='main';
    public Router $router ; 
    public View $view ; 
    public Request $request;
    public Response $response; 
    public Session $session;
    public Controller $controller;
    public Database $db;
    public ?UserModel $user;

    public function __construct($rootPath,array $config)
    {

        self::$ROOT_DIR =$rootPath;
        self::$app = $this;


    /* ---------------- objects --------------- */

        $this->request = new Request();
        $this->response = new Response();
        $this->db= new Database($config['db']);
        $this->session = new Session();
        $this->controller = new Controller();
        $this->view = new View();
        $this->router = new Router($this->request,$this->response);

    /* ---------------- User Config --------------- */

        $this->userClass =$config['userClass'];
        $primaryValue = $this->session->get('user');

        if($primaryValue)
            {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey =>$primaryValue]);
            }
            else{
                $this->user = null ;
            }

    }

    /* ---------------- Run  --------------- */


    public function run(){

        try{
        echo $this->router->reslove();
            }
            catch(\Exception $e){
                $this->response->setStatusCode($e->getCode());
                echo $this->view->renderView('_error',[
                    'exception' =>$e
                ]);
            }

    }

    /* ---------------- isGuest  --------------- */

    public static function isGuest(){
        return !self::$app->user;
    }
    /* ---------------- Login  --------------- */

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user',$primaryValue);
        return true;
    }

       /* ---------------- Login out --------------- */

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    /* ---------------- Controller getter setter --------------- */

  /*  public Controller $controller; //object created on router.php


    public function setController(Controller $controller){
        $this->controller =$controller;
    }
    
    public function getController(){
        return $this->controller;
    }
  */  
    
}
