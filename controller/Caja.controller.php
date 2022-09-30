<?php 

class Caja extends DB{

    private $db;
    private $d;
    public function __construct($data){
        $this->d = $data;
        $this->db = DB::conectarDB();
    }

    /**
     * Obtiene la data de las cajas
     */
    public function getData(){
        try{
            $data = array();
            $add = "";
            if(isset($this->d->idCaja) && $this->d->idCaja != ''){
                $add = " AND id = ?";
                array_push($data,$this->d->idCaja);
            }
            $rdb = $this->db->prepare("SELECT * FROM caja WHERE 1 = 1 {$add}");
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