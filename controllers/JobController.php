<?php
// controllers/JobController.php
namespace Controllers;

use Model\VacanteModel;

class JobController
{
    // Obtenemos las vacantes
    public static function getVacantes()
    {
        // Instanciamos el modelo
        $model = new VacanteModel();
        return $model->getVacantes();
    }
}
