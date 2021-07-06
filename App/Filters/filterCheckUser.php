<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\detallesRolesPermisos;
use CodeIgniter\Exceptions\PageNotFoundException;

class filterCheckUser implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $detallesRoles = new detallesRolesPermisos();

        $id_rol = session()->get('id_rol');

        if ($id_rol !== null) {
            $uri = $request->uri;
            
            $path = $uri->getSegments();

            $new_path = $path[0];

            if(count($path) > 1){

                $new_path = $path[0]."/".$path[1];
                
            }

            if($detallesRoles->verificarAccesoUsuario($id_rol, $new_path)){
                
            }else{
                echo view('header');
                throw PageNotFoundException::forPageNotFound('No tiene acceso a esta pagina. Contacte con un administrador en caso de ser necesario');
                echo view('footer');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
