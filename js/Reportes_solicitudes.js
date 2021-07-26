

// $tabla=   document.getElementsByTagName('input').item[0];
// funcion para reporte de equivalencias
function pdf() { 
   $input=   document.getElementsByClassName('form-control-sm')
   $buscar=$input[1].value;
   let hash= btoa($buscar);
   // location.href ="../Controlador/Reporte_especialidades.php";
  

   if ($buscar!=='') {
  
      let url="../Controlador/Reporte_especialidades.php?ruby="+hash+"",
      nombre_ventana="Reporte_de_Equivalencias_Filtrado";
      
      
      window.open(url,nombre_ventana);
      
   }else{
      let url="../Controlador/Reporte_especialidades.php?ruby=",
          nombre_ventana="Reporte_de_Equivalencias";
     
      window.open(url,nombre_ventana);
   }
   
}

//funcion para reporte de carta egresado 
function pdf_carta() { 
   $input=   document.getElementsByClassName('form-control-sm')
   $buscar=$input[1].value;
   let hash= btoa($buscar);
   // location.href ="../Controlador/Reporte_especialidades.php";
  

   if ($buscar!=='') {
  
      let url="../Controlador/Reporte_especialidades.php?perl="+hash+"",
      nombre_ventana="Reporte_de_Equivalencias_Filtrado";
      
      
      window.open(url,nombre_ventana);
      
   }else{
      let url="../Controlador/Reporte_especialidades.php?perl=",
          nombre_ventana="Reporte_de_Equivalencias";
     
      window.open(url,nombre_ventana);
   }
   
}

function pdf_expediente() { 
   $input=   document.getElementsByClassName('form-control-sm')
   $buscar=$input[1].value;
   let hash= btoa($buscar);
   // location.href ="../Controlador/Reporte_especialidades.php";
  

   if ($buscar!=='') {
  
      let url="../Controlador/Reporte_especialidades.php?scala="+hash+"",
      nombre_ventana="Reporte_de_Equivalencias_Filtrado";
      
      
      window.open(url,nombre_ventana);
      
   }else{
      let url="../Controlador/Reporte_especialidades.php?scala=",
          nombre_ventana="Reporte_de_Equivalencias";
     
      window.open(url,nombre_ventana);
   }
   
}

function pdf_servicio() { 
   $input=   document.getElementsByClassName('form-control-sm')
   $buscar=$input[1].value;
   let hash= btoa($buscar);
   // location.href ="../Controlador/Reporte_especialidades.php";
  

   if ($buscar!=='') {
  
      let url="../Controlador/Reporte_especialidades.php?php="+hash+"",
      nombre_ventana="Reporte_de_Equivalencias_Filtrado";
      
      
      window.open(url,nombre_ventana);
      
   }else{
      let url="../Controlador/Reporte_especialidades.php?php=",
          nombre_ventana="Reporte_de_Equivalencias";
     
      window.open(url,nombre_ventana);
   }
   
}