
<script type="text/javascript">
   $(document).ready(function () {
      document.getElementById("repPendientes").style.display ="none";
       document.getElementById("repPorUsuario").style.display ="none";
       document.getElementById("repPorActi").style.display ="none";
      document.getElementById("repPorDesc").style.display ="none";
      document.getElementById("repPorDescGen").style.display ="none";
   });
   //seleccionar ventana
   function actPorEmp(objOrigen){
   document.getElementById("repPendientes").style.display ="block";
   // document.getElementById("menu").style.display ="none";
    document.getElementById("repPorUsuario").style.display ="none";
     document.getElementById("repPorActi").style.display ="none";
     document.getElementById("repPorDesc").style.display ="none";
     document.getElementById("repPorDescGen").style.display ="none";
   }
   //cerrar ventana 
   function closePorEmp(objOrigen){
    document.getElementById("repPendientes").style.display ="none";
   }
   function actPorUs(objOrigen){
   document.getElementById("repPorUsuario").style.