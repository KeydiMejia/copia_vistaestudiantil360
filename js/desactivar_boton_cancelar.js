function habilitar_eliminar(){ 
    $estado=$sql_tabla["ROWS"][$counter]["descripcion"];
                    if ($estado=="NUEVO"){
                        document.getElementById("btn_cancelar").disable= false;
                    }else{
                        document.getElementById("btn_cancelar").disable= true;
                    }
                }
