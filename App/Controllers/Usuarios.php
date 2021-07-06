<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\CajasModel;
use App\Models\RolesModel;
use App\Models\LogsModel;
use Error;
use Exception;
use Imagenes;

class Usuarios extends BaseController
{
    protected $usuarios;
    protected $request;
    protected $reglas;
    protected $reglasLogin;
    protected $reglasUpdatePassword;
    protected $cajas;
    protected $roles;
    protected $logs;

    public function __construct()
    {

        $this->usuarios = new UsuariosModel();
        $this->cajas = new CajasModel();
        $this->roles = new RolesModel();
        $this->logs = new LogsModel();

        helper(['form']);
        $this->reglasUpdatePassword = [
            'repassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'matches' => 'Las contraseñas no coinciden.'
                ]
            ]
        ];
        $this->reglas = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'is_unique' => 'El campo {field} debe ser unico'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_caja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];

        $this->reglasUpdate = [
            'usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_caja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'imagen_usuario' => [
                'rules' => 'mime_in[imagen_usuario,image/png]',
                'errors' => [
                    'mime_in' => 'Ingresar solo en formato PNG'
                ]
            ]
        ];

        $this->reglasLogin = [
            'usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $usuarios = $this->usuarios->where('activo', $activo)->findAll();
        $cajas = $this->cajas->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();

        $data = [
            'titulo' => 'Usuarios',
            'datos' => $usuarios,
            'cajas' => $cajas,
            'roles' => $roles
        ];

        echo view('header');
        echo view('usuarios/usuarios', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $usuarios = $this->usuarios->where('activo', $activo)->findAll();
        $cajas = $this->cajas->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $data = ['titulo' => 'Usuarios eliminados', 'datos' => $usuarios, 'roles' => $roles, 'cajas' => $cajas];

        echo view('header');
        echo view('usuarios/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $usuarios = $this->usuarios->where('activo', 1)->findAll();
        $cajas = $this->cajas->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();

        $data = [
            'titulo' => 'Agregar usuario',
            'datos' => $usuarios,
            'cajas' => $cajas,
            'roles' => $roles
        ];

        echo view('header');
        echo view('usuarios/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $this->usuarios->save(
                [
                    "usuario" => $this->request->getPost('usuario'),
                    "password" => $hash,
                    "nombre" => $this->request->getPost('nombre'),
                    "id_rol" => $this->request->getPost('id_rol'),
                    "id_caja" => $this->request->getPost('id_caja')
                ]
            );

            $id = $this->usuarios->getInsertID();

            if ($this->request->getPost('src_avatar') != '') {
                Imagenes::LoadAndSaveImage($this->request->getPost('src_avatar'), $id);
            } else {
                Imagenes::guardarImagen("images/avatars/users-upload/$id.png", 'imagen_usuario', './images/avatars/users-upload', "$id.png");
            }

            return redirect()->to(base_url() . '/usuarios')->with('res', 'ok');
        } else {
            $usuarios = $this->usuarios->where('activo', 1)->findAll();
            $cajas = $this->cajas->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();

            $data = [
                'titulo' => 'Usuarios',
                'datos' => $usuarios,
                'cajas' => $cajas,
                'roles' => $roles,
                'validation' => $this->validator
            ];

            echo view('header');
            echo view('usuarios/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $usuario = $this->usuarios->where('id', $id)->first();
        $cajas = $this->cajas->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();

        if ($valid != null) {

            $data = [
                'titulo' => 'Editar usuario',
                'datos' => $usuario,
                'cajas' => $cajas,
                'roles' => $roles,
                'validation' => $valid
            ];
        } else {

            $data = [
                'titulo' => 'Editar usuario',
                'datos' => $usuario,
                'cajas' => $cajas,
                'roles' => $roles
            ];
        }

        echo view('header');
        echo view('usuarios/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglasUpdate)) {

            $this->usuarios->update(
                $this->request->getPost('id'),
                [
                    "usuario" => $this->request->getPost('usuario'),
                    "nombre" => $this->request->getPost('nombre'),
                    "id_rol" => $this->request->getPost('id_rol'),
                    "id_caja" => $this->request->getPost('id_caja')
                ]
            );

            $id =  $this->request->getPost('id');

            if ($this->request->getFile('imagen_usuario')->getFileName() != '' || $this->request->getPost('src_avatar') != '') {
                if ($this->request->getPost('src_avatar') != '') {
                    Imagenes::LoadAndSaveImage($this->request->getPost('src_avatar'), $id);
                } else {
                    Imagenes::guardarImagen("images/avatars/users-upload/$id.png", 'imagen_usuario', './images/avatars/users-upload', "$id.png");
                }
            }

            $this->UpdateSession($this->request->getPost('nombre'), $this->request->getPost('id_rol'), $this->request->getPost('id_caja'));

            return redirect()->to(base_url() . '/usuarios')->with('res', 'ok');
        } else {

            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->request = \Config\Services::request();

        $this->usuarios->update(
            $id,
            [
                "activo" => 0
            ]
        );

        return redirect()->to(base_url() . '/usuarios');
    }

    public function reingresar($id)
    {
        $this->request = \Config\Services::request();

        $this->usuarios->update(
            $id,
            [
                "activo" => 1
            ]
        );

        return redirect()->to(base_url() . '/usuarios');
    }

    public function login()
    {
        echo view('login');
    }

    public function valida()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglasLogin)) {
            $usuario = $this->request->getPost('usuario');
            $password = $this->request->getPost('password');
            $datosUsuario = $this->usuarios->where('usuario', $usuario)->first();

            if ($datosUsuario != null) {
                if (password_verify($password, $datosUsuario['password'])) {
                    $datosSesion = [
                        'id_usuario' => $datosUsuario['id'],
                        'nombre' => $datosUsuario['nombre'],
                        'id_caja' => $datosUsuario['id_caja'],
                        'id_rol' => $datosUsuario['id_rol']
                    ];

                    $this->crearLogs($datosUsuario['id'], 'Inicio de sesión');

                    $session = session();
                    $session->set($datosSesion);

                    return redirect()->to(base_url() . '/inicio');
                } else {
                    $data['error'] = "Las contraseñas no coinciden.";
                    echo view('login', $data);
                }
            } else {
                $data['error'] = "El usuario no existe.";
                echo view('login', $data);
            }
        } else {
            $data = ['validation' => $this->validator];
            echo view('login', $data);
        }
    }

    public function logout()
    {
        $session = session();

        $this->crearLogs($session->id_usuario, 'Cierre de sesión');

        $session->destroy();
        return redirect()->to(base_url());
    }

    public function cambia_password($id = null)
    {
        $usuario = $this->usuarios->where('id', $id)->first();

        $data = [
            'titulo' => 'Cambiar contraseña',
            'usuario' => $usuario
        ];

        echo view('header');
        echo view('usuarios/cambia_password', $data);
        echo view('footer');
    }

    public function actualizar_password($id = null)
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglasUpdatePassword)) {

            // $session = session();
            $idUsuario = $id;

            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $this->usuarios->update(
                $idUsuario,
                [
                    "password" => $hash
                ]
            );

            $usuario = $this->usuarios->where('id', $idUsuario)->first();

            $data = [
                'titulo' => 'Cambiar contraseña',
                'usuario' => $usuario,
                'mensaje' => 'Contraseña actualizada'
            ];

            echo view('header');
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        } else {
            // $session = session();
            $idUsuario = $id;

            $usuario = $this->usuarios->where('id', $idUsuario)->first();

            $data = [
                'titulo' => 'Cambiar contraseña',
                'usuario' => $usuario,
                'validation' => $this->validator
            ];

            echo view('header');
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        }
    }

    public function crearLogs($id_usuario, $evento)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $detalles = $_SERVER['HTTP_USER_AGENT'];

        $this->logs->save([
            'id_usuario' => $id_usuario,
            'evento' => $evento,
            'ip' => $ip,
            'detalles' => $detalles
        ]);
    }

    public function UpdateSession($nombre, $id_caja, $id_rol)
    {
        $_SESSION["nombre"] = $nombre;
        $_SESSION["id_caja"] = $id_caja;
        $_SESSION["id_rol"] = $id_rol;
    }

    public static function SimularFileUpload($url_image)
    {
        $_FILES = [
            'image' => [
                'name' => 'lorem',
                'type' => 'image/png',
                'size' => filesize($url_image),
                'tmp_name' => $url_image,
                'error' => 0,
            ]
        ];

        return $_FILES;
    }
}
