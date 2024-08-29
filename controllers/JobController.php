<?php
// controllers/JobController.php
namespace Controllers;
use MVC\Router;
class JobController
{
    public static function index(Router $router)
    {
        $router->render('pages/jobVacancy',[
            
        ]);
    }

}
