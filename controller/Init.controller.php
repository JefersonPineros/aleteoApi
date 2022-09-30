<?php
include '../head.php';

class Init {
    
    private $controller;
    private $method;
    private $data;
    
    public function __construct(){

        $rawPOSTData = file_get_contents('php://input');
        $this->data = json_decode($rawPOSTData);
        $this->controller = ($this->data->controlador != NULL) ? $this->data->controlador : '';
        $this->method = ($this->data->metodo != NULL) ? $this->data->metodo : '';
        $this->init();
    }

    /**
     * Inicializa el proceso para determinar que controlador y que proceso realizará
     */
    private function init(){
        try{
            if(is_file(__DIR__."/".$this->controller.".controller.php")){
                require_once __DIR__."/".$this->controller.".controller.php";
                $c = new $this->controller($this->data);
                if(method_exists($c,$this->method)){
                    $m = $this->method;
                    echo json_encode($c->$m());
                }else{
                   echo json_encode(array('status'=>500,'msg'=>'Error en metodo'));
                }
            }else{
                echo json_encode(array('status'=>500,'msg'=>'Error en controlador'));
            }
        }catch(Throwable $t){
            echo json_encode(array('status'=>501,'msg'=>'Error: '.$t->getMessage()));
        }
    }
}

new Init();
