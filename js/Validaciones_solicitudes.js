
 window.onload = function() {
    
    let pantalla= location.pathname;
    let vista= pantalla.split("/",8);
    

    if (vista[4]=='revision_servicio_comunitario_unica_vista.php') {
        inputs_revision_servicio_comunitario_unitario();        
    }else if(vista[4]=='servicio_comunitario_vista.php'){
        
      inputs_solicitud_servicio();
      

    }else{
        console.log('no hay vista');
    }
  
}


function inputs_solicitud_servicio() {
    let cuenta = document.getElementById('txt_cuenta');
    let nombre = document.getElementById('txt_verificado1');
    let apellido = document.getElementById('txt_verificado2');
    let correo = document.getElementById('txt_correo');
    let proyecto = document.getElementById('txt_proyecto');
    let solicitud= document.getElementById('solicitud');
    let btn = document.getElementById('btn_servicio');

    cuenta.addEventListener('focus',e=>{
        copiar(cuenta);
        pegar(cuenta);
     })

    nombre.addEventListener('focus',e=>{
    copiar(nombre);
    pegar(nombre);
    })

    apellido.addEventListener('focus',e=>{
        copiar(apellido);
        pegar(apellido);
    })


    correo.addEventListener('focus',e=>{
        copiar(correo);
        pegar(correo);
    })

    proyecto.addEventListener('focus',e=>{
        copiar(proyecto);
        pegar(proyecto);
    })

    

    btn.addEventListener('click',e=>{

        let resul=validarSolicitud(),
        historial=validarHistorial();
       
      
           
        
       
        if (cuenta.value=='' || nombre.value=='' || apellido.value==''|| correo.value==''|| proyecto.value=='' 
        || resul===undefined || historial===undefined) {
            e.preventDefault();
           message(msg.vacio,titulo.camposVacios,tipo.info); 
        }else if(resul==historial){
            e.preventDefault();
            message(msg.documentos, titulo.documento, tipo.info);
        }else{
           setTimeout(() => {
            location.href=('../vistas/revision_servicio_comunitario_vista.php')
            message('listos para la redirección','REDIRECCION',tipo.succes);
           }, 20000);
        }
    })

 
}

function inputs_revision_servicio_comunitario_unitario() {
    let observacion = document.getElementById('observacion');
    
    let btn = document.getElementById('btn_guardar_cambio');
    

    
    observacion.addEventListener('focus',e=>{
        copiar(observacion);
        pegar(observacion);
     })

     observacion.addEventListener('blur',e=>{
         let valor=observacion.value;
         if (valor=='') {
             btn.setAttribute('disabled','');
             campo_vacio();
             observacion.focus();
         }else{
            btn.removeAttribute('disabled');
         }


     })

     


}



function validarSolicitud() {
    const input = document.getElementById('solicitud');
    if(input.files && input.files[0]){
        let nombre_solicitud= input.files[0].name;
        
        return nombre_solicitud;
    
    }else{
        let nombre_solicitud=input.files[0];
        
        return nombre_solicitud;
    }
}

function validarHistorial() {
    const input = document.getElementById('historial');
    if(input.files && input.files[0]){
        let nombre_solicitud= input.files[0].name;
        
        return nombre_solicitud;
    
    }else{
        let nombre_solicitud=input.files[0];
        
        return nombre_solicitud;
    }
}


tipo={
    info:'info',
    warning:'warning',
    success:'success',
    danger:'danger'
}

msg={
    copiar:"Por seguridad del sistema, la acción COPIAR esta deshabilitada",
    pegar:"Por seguridad del sistema, la acción PEGAR esta deshabilitada",
    vacio:"Recuerda completar todo los campos",
    documentos:"No se permite cargar documentos con el mismo nombre",
}

titulo={
    sistema:'NOTIFICACION DE EL SISTEMA',
    camposVacios:'VALIDACION DE CAMPOS',
    documento:'VALIDACION DE DOCUMENTOS',
}





function pegar(input) {
    input.onpaste = function(e) {
        e.preventDefault();
        console.log('fdfd');
       
        message(msg.pegar,titulo.sistema,tipo.info);
    }
}

function copiar(input) {
    input.oncopy = function(e) {
        e.preventDefault();
        console.log('fdfd');
        message(msg.copiar,titulo.sistema,tipo.info);
    } 
}

function campo_vacio(){
    
    
    message(msg.vacio,titulo.camposVacios,tipo.info);
}

function message(msg='desconocido',titulo='SISTEMA',tipo='info') {
    
   toastr[tipo](msg, titulo);

    toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }
}




