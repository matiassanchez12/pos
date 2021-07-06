<?php 

use CodeIgniter\Config\Services;

class Imagenes
{
    public static function guardarImagen($rutaValidar, $idImagen, $rutaMove, $nombreImagen)
    {
        $req = new Services();
        $get = $req->request();

        if (is_writable($rutaValidar)) {
            unlink($rutaValidar);
        }
        // file_exists($rutaValidar)
        $img = $get->getFile($idImagen);

        if($img != null){
            $img->move($rutaMove, $nombreImagen);
            
            clearstatcache();

            return true;
        }

        return false;
    }

    public static function LoadAndSaveImage($url, $id)
    {
        $content = file_get_contents($url);

        if (file_exists("images/avatars/users-upload/$id.png")) {
            unlink("images/avatars/users-upload/$id.png");
        }

        file_put_contents("images/avatars/users-upload/$id.png", $content);

        clearstatcache();
    }
}
