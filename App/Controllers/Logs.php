<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogsModel;
use mysqli;

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
        $db_name = 'pos';
        $db_user = 'root';
        $db_pass = '379784577a';

        Logs::Export_Database($db_host, $db_user, $db_pass, $db_name);
    }

    public static function Export_Database($host,$user,$pass,$name, $tables=false, $backup_name=false )
    {
        $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";
            
            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        // $backup_name = $backup_name ? $backup_name : $name.".sql";
        $backup_name = "respaldo_app.sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; 
        exit;
    }
}
