
 window.onload = function() {
    
    let pantalla= location.pathname;
    let vista= pantalla.split("/",8);
    

    if (vista[4]=='revision_servicio_comunitario_unica_vista.php') {
        
        inputs_revision_servicio_comunitario_unitario();  

    }else if(vista[4]=='servicio_comunitario_vista.php'){
        
      inputs_solicitud_servicio();
      

    }else if(vista[4]=='equivalencias_vista.php'){
        
        inputs_solicitud_equivalencia();

    }else if(vista[4]=='revision_equivalencias_unica.php'){
        
        inputs_revision_servicio_comunitario_unitario();

    }else if(vista[4]=='carta_egresado_vista.php'){

       inputs_solicitud_carta_egresado();

    }else if(vista[4]=='revision_carta_egresado_unica_vista.php'){

        inputs_revision_servicio_comunitario_unitario();
     }else if(vista[4]=='expediente_graduacion_vista.php'){

       inputs_solicitud_equivalencia();

     }else if(vista[4]=='revision_expediente_graduacion_unica.php'){

        inputs_revision_servicio_comunitario_unitario();
      }
    
}



function inputs_solicitud_carta_egresado() {
    let cuenta = document.getElementById('cuenta');
    let nombre = document.getElementById('txt_verificados1');
    let apellido = document.getElementById('txt_verificados2');
    let correo = document.getElementById('correo');
    let btn = document.getElementById('btn_carta_egresado');

    correo.addEventListener('focus',e=>{
        copiar(correo);
        pegar(correo);
     })
    
    apellido.addEventListener('focus',e=>{
        copiar(apellido);
        pegar(apellido);
     })
    
    nombre.addEventListener('focus',e=>{
        copiar(nombre);
        pegar(nombre);
     })
    
    cuenta.addEventListener('focus',e=>{
        copiar(cuenta);
        pegar(cuenta);
     })



     btn.addEventListener('click',e=>{

        let identidad=validaridentidad(),
        finalizacion=validarfinalizacion(),
        comunitario=validarcomunitario(),
        certificado=validarcertificado();
       
        if (cuenta.value=='' || nombre.value=='' || apellido.value==''|| correo.value=='' 
        || identidad===undefined || finalizacion===undefined || comunitario===undefined || certificado===undefined) {
            
            e.preventDefault();
           message(msg.vacio,titulo.camposVacios,tipo.info); 


        }else if(identidad==finalizacion){
            
            e.preventDefault();
            message(msg.documentos, titulo.documento, tipo.info);

        }else if(identidad==comunitario){
            
            e.preventDefault();
            message(msg.documentos, titulo.documento, tipo.info);

        }else if(identidad==certificado){
            
            e.preventDefault();
            message(msg.documentos, titulo.documento, tipo.info);

        }else if(finalizacion==certificado){
            
            e.preventDefault();
            message(msg.documentos, titulo.documento, tipo.info);

        }else if(comunitario==certificado){
            
            e.preventDefault();
            message(msg.documentos, titulo.documento, tipo.info);

        }else if(finalizacion==comunitario){
            
            e.preventDefault();
            message(msg.documentos, titulo.documento, tipo.info);

        }else{

           
        }
    })
}


function inputs_solicitud_equivalencia() {
    let cuenta = document.getElementById('txt_cuenta');
    let nombre = document.getElementById('txt_verificado1');
    let apellido = document.getElementById('txt_verificado2');
    let correo = document.getElementById('txt_correo');
    let btn = document.getElementById('btn_equivalencias');

    correo.addEventListener('focus',e=>{
        copiar(correo);
        pegar(correo);
     })
    
    apellido.addEventListener('focus',e=>{
        copiar(apellido);
        pegar(apellido);
     })
    
    nombre.addEventListener('focus',e=>{
        copiar(nombre);
        pegar(nombre);
     })
    
    cuenta.addEventListener('focus',e=>{
        copiar(cuenta);
        pegar(cuenta);
     })



     btn.addEventListener('click',e=>{

        let resul=validarSolicitud(),
        historial=validarHistorial();
       
        if (cuenta.value=='' || nombre.value=='' || apellido.value==''|| correo.value=='' 
        || resul===undefined || historial===undefined) {
            e.preventDefault();
           message(msg.vacio,titulo.camposVacios,tipo.info); 
        }else if(resul==historial){
            e.preventDefault();
            message(msg.documentos, titulo.documento, tipo.info);
        }else{

          
        }
    })
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

function validaridentidad() {
    const input = document.getElementById('identidad');
    if(input.files && input.files[0]){
        let nombre_solicitud= input.files[0].name;
        
        return nombre_solicitud;
    
    }else{
        let nombre_solicitud=input.files[0];
        
        return nombre_solicitud;
    }
}

function validarcomunitario() {
    const input = document.getElementById('comunitario');
    if(input.files && input.files[0]){
        let nombre_solicitud= input.files[0].name;
        
        return nombre_solicitud;
    
    }else{
        let nombre_solicitud=input.files[0];
        
        return nombre_solicitud;
    }
}

function validarcertificado() {
    const input = document.getElementById('certificado');
    if(input.files && input.files[0]){
        let nombre_solicitud= input.files[0].name;
        
        return nombre_solicitud;
    
    }else{
        let nombre_solicitud=input.files[0];
        
        return nombre_solicitud;
    }
}

function validarfinalizacion() {
    const input = document.getElementById('finalizacion');
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




