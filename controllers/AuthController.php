<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\models\LoginForm;
use app\core\Middlewares\AuthMiddleware;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    /* ---------------- login --------------- */

    public function login(Request $request,Response $response)
    {
        $loginForm = new LoginForm();
        if($request->isPost()){
            $loginForm->loadData($request->getBody());


            if($loginForm->validate() && $loginForm->login())
            {

                $response->redirect('/');
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login',
        [
            'model'=>$loginForm,
        ]);
    }

    /* ---------------- register --------------- */

    public function register(Request $request)
    {

        
        $User = new User(); //object

    /* ---------------- register POST --------------- */

    if($request->isPost())
        {
            $User->loadData($request->getBody());//send data to model

            if($User->validate() && $User->save())
            {
            Application::$app->session->setFlash('success','Thanks For Regstering');
            Application::$app->response->redirect('/');
            exit;

            }

                return $this->render('register',
                [
                    'model'=>$User //save register Model object is params of the page
                ]);

        }

    /* ---------------- register Get --------------- */

        $this->setLayout('auth');
        return $this->render('register',
        [
            'model'=>$User
        ]

        );


    }

    /* ---------------- logout --------------- */

    public function logout(Request $request,Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    /* ---------------- profile --------------- */

    public function profile()
    {
        return $this->render('profile');
    }

}

