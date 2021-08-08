<?php

namespace App\Controllers;

class Reportes extends BaseController
{
    public function index()
    {
        echo view('header');
        echo view('reportes/reportes');
        echo view('footer');
    }
}