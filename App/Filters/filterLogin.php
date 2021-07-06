<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Controllers\Usuarios;

class filterLogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $log = session()->get('id_usuario');

        if ($log == null) {
            return redirect()->to(base_url("/"));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $this->detallesRoles->verificarPermisos($this->session->id_rol, 'productosCatalogo');
    }
}
