<?php 

include '../models/CreatePodcast.php';
include '../models/CreatePodcastUser.php';

class Visita extends DB{

    private $db;
    private $d;
    public function __construct($data){
        $this->d = $data;
        $this->db = DB::conectarDB();  
    }

    /**
     * Inserta la visita tnato en visitador como en visitas
     */
    public function insertVisita(){
        try{
            $ip = $this->d->ip;
            $page = $this->d->page;
            $d = date('Y-m-d H:i:s');
            $data = array(
                $ip,
                $d
            );

            $rdb = $this->db->prepare("SELECT * FROM visitador WHERE id_visitador = ?");
            if($rdb->execute(array($ip))){
                $obj = $rdb->fetchAll(PDO::FETCH_OBJ);
                if(!(count($obj)>0)){
                    // Inserta en visitador
                    $rdb = $this->db->prepare("INSERT INTO visitador(id_visitador,fecha_primer_visita) VALUES (?,?)");
                    if($rdb->execute($data)){
                    }else{
                        return array('status'=>501,'msg'=>'Error en insertar visitador');
                    }
                }
                // Inserción de visita
                array_push($data,$page); // Se añade la página al arreglo
                $rdb = $this->db->prepare("INSERT INTO visitas(id_visitador,fecha_visita,pagina) VALUES (?,?,?)");
                if($rdb->execute($data)){
                    return array('status'=>200,'msg'=>'Inserción correcta de visitas');
                }else{
                    return array('status'=>501,'msg'=>'Error en insertar visita');
                }
            }else{
                return array('status'=>501,'msg'=>'Error en obtener data');
            }
        } catch (Throwable $th) {
            return array('status' => 500, 'msg' => $th->getMessage());
        }
    }
}