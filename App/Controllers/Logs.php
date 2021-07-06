<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogsModel;

class Logs extends BaseController
{
    protected $logs;
    protected $request;
    protected $reglas;

    public function __construct()
    {
        $this->logs = new LogsModel();
    }

    public function index()
    {
        $logs = $this->logs->findAll();

        $data = ['titulo' => 'Logs de acceso', 'datos' => $logs];

        echo view('header');
        echo view('logs/logs_acceso', $data);
        echo view('footer');
    }

    public function logs_usuario($id_usuario)
    {
        $logs = $this->logs->where('id_usuario', $id_usuario)->findAll();

        $data = ['titulo' => 'Registros del usuario', 'datos' => $logs];

        echo view('header');
        echo view('logs/logs_usuario', $data);
        echo view('footer');
    }

    public function respaldo_database()
    {
        echo view('header');
        echo view('logs/generar_respaldo');
        echo view('footer');
    }

    public function generar_respaldo()
    {
        $db_host = 'localhost';
        $db_name = 'po1s';
        $db_user = 'root';
        $db_pass = '379784577a';

        define("DB_USER",  $db_user);
        define("DB_PASSWORD", $db_pass);
        define("DB_NAME", $db_name);
        define("DB_HOST", $db_host);

        // define("BACKUP_DIR", 'myphp-backup-files'); // Comment this line to use same script's directory ('.')
        define("TABLES", 'pos'); // Full backup
        //define("TABLES", 'table1, table2, table3'); // Partial backup
        define("CHARSET", 'utf8');
        define("GZIP_BACKUP_FILE", true); // Set to false if you want plain SQL backup files (not gzipped)
        define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails

        return redirect()->to(base_url() . '/logs/respaldo_database');
    }
}
