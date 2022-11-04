<?php 

include '../models/CreatePodcast.php';
include '../models/CreatePodcastUser.php';

class Podcast extends DB{

    private $db;
    private $d;
    private $podcastFile;
    private $podcastModel;
    public function __construct($data){
        $this->d = $data;
        $this->db = DB::conectarDB();  
    }

    /**
     * Obtiene la data de las cajas
     */
    public function createNewPodcast() {
        $baseFolder = '../files/podcast/';
        $this->podcastFile = $this->d->podcast->file;
        $this->podcastModel = $this->d->podcast->createPodcast;

        try {
            
            $newPodcast = new PodcastUser();
            if( $this->podcastModel->name_user !== '' && $this->podcastModel->check_terminos ) {
                $newPodcast->setNameUser($this->podcastModel->name_user);
                $newPodcast->setCheckTerminos($this->podcastModel->check_terminos);
                $baseSaveUrl = $baseFolder.$newPodcast->geNameUser().'-'.date('YmdHis').'.mp3';
                $newPodcast->setUrlPodcast('http://localhost/swAleteoCrea'.substr($baseSaveUrl,2));
                $newPodcast->setTimeAudio($this->podcastModel->time_audio);
                $newPodcast->setRegisterCreate(date('Y-m-d H:i:s'));
            } else  {
                return array('status' => 500, 'msg' => 'Terminos y condiciones no aceptados o no diligenciado el nombre de usuario.');
            }

            file_put_contents($baseSaveUrl, base64_decode($this->podcastFile));
            
            $insertPodcast = $this->db->prepare("INSERT INTO podcast_users (url_podcast, name_user,check_terminos,time_audio,register_create) VALUES(?,?,?,?,?)");

            if($insertPodcast->execute(
                array(
                    $newPodcast->geUrlPodcast(),
                    $newPodcast->geNameUser(),
                    $newPodcast->getCheckTerminos(),
                    $newPodcast->getTimeAudio(),
                    $newPodcast->getRegisterCreate()
                    )
                )){
                $id = $this->db->lastInsertId();
                return array('status'=>200,'msg'=>'Insertado correctamente','data'=>$id);
            } else {
                return array('status'=>501,'msg'=>'Error en inserción de información');
            }
            
        } catch (Throwable $th) {
            return array('status' => 500, 'msg' => $th->getMessage());
        }
    }

    public function getDataPodcastUser(){
        try{
            $data = array();
            $add = "";
            if(isset($this->d->idPodcast) && $this->d->idPodcast != ''){
                $add = " AND id = ?";
                array_push($data,$this->d->idPodcast);
            }
            $rdb = $this->db->prepare("SELECT * FROM podcast_users WHERE check_terminos = 1 {$add}");
            if($rdb->execute($data)){
                $data = $rdb->fetchAll(PDO::FETCH_OBJ);
                return array('status'=>200,'data'=>$data);
            }else{
                return array('status'=>501,'msg'=>'Error en obtener data');
            }
        }catch (Throwable $t){
            return array('status'=>500,'msg'=>$t->getMessage());
        }
    }

    public function getData(){
        try{
            $data = array();
            $add = "";
            if(isset($this->d->idPodcast) && $this->d->idPodcast != ''){
                $add = " AND id = ?";
                array_push($data,$this->d->idPodcast);
            }
            $rdb = $this->db->prepare("SELECT * FROM podcast_principal_bandas 
                                        INNER JOIN podcast_principal_canciones ON podcast_principal_canciones.id_parent = podcast_principal_bandas.id
                                       WHERE 1 = 1 {$add}");
            if($rdb->execute($data)){
                $data = $rdb->fetchAll(PDO::FETCH_OBJ);
                return array('status'=>200,'data'=>$data);
            }else{
                return array('status'=>501,'msg'=>'Error en obtener data');
            }
        }catch (Throwable $t){
            return array('status'=>500,'msg'=>$t->getMessage());
        }
    }

    /**
     * Inserción de registro en entidad Caja
     */
    public function insertRow(){
        try{
            if(isset($this->d->name)){
                $rdb = $this->db->prepare("INSERT INTO caja(name) VALUES(?)");
                if($rdb->execute(array($this->d->name))){
                    $id = $this->db->lastInsertId();
                    return array('status'=>200,'msg'=>'Insertado correctamente','data'=>$id);
                }else{
                    return array('status'=>501,'msg'=>'Error en inserción de información');
                }
            }else{
                return array('status'=>501,'msg'=>'Data incorrecta o incompleta. Por favor verifique.');
            }
        }catch (Throwable $t){
            return array('status'=>500,'msg'=>$t->getMessage());
        }
    }

    /**
     * Acctualiza un registro
     */
    public function updateRow(){
        try{
            if(isset($this->d->id) && isset($this->d->name)){
                $rdb = $this->db->prepare("UPDATE caja SET name = ? WHERE id = ?");
                if($rdb->execute(array($this->d->name,$this->d->id))){
                    return array('status'=>200,'msg'=>'Actualizado correctamente');
                }else{
                    return array('status'=>501,'msg'=>'Error en actualización de información');
                }
            }else{
                return array('status'=>501,'msg'=>'Data incorrecta o incompleta. Por favor verifique.');
            }
        }catch (Throwable $t){
            return array('status'=>500,'msg'=>$t->getMessage());
        }
    }

    /**
     * Elimina un registro
     */
    public function deleteRow(){
        try{
            if(isset($this->d->id)){
                $rdb = $this->db->prepare("DELETE FROM caja WHERE id = ?");
                if($rdb->execute(array($this->d->id))){
                    return array('status'=>200,'msg'=>'Eliminado correctamente');
                }else{
                    return array('status'=>501,'msg'=>'Error en eliminación. Puede que este registro esté asociado en otras tablas o no exista.');
                }
            }else{
                return array('status'=>501,'msg'=>'Data incorrecta o incompleta. Por favor verifique.');
            }
        }catch (Throwable $t){
            return array('status'=>500,'msg'=>$t->getMessage());
        }
    }
}

?>