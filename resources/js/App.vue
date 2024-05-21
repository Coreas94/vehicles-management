<template>
   <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
               aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav flex-column">
                  <li class="nav-item">
                     <router-link class="nav-link" to="/"><h3>Sistema de control de vehiculos</h3></router-link>
                  </li>
                  <li>&nbsp;</li>
                  <li>&nbsp;</li>
                  <li class="nav-item">
                     <router-link class="nav-link" to="/"><b>Vehiculos</b></router-link>
                  </li>
                  <li class="nav-item">
                     <router-link class="nav-link" to="/users"><b>Usuarios</b></router-link>
                  </li>
                  <li class="nav-item">
                     <router-link class="nav-link" to="/import-excel"><b>Importar Excel</b></router-link>
                  </li>
                  <li class="nav-item">
                     <router-link class="nav-link" to="/vehicle-histories"><b>Historial de vehiculos</b></router-link>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="main-content">
         <router-view></router-view>
      </div>
   </div>
</template>

<script>
export default {
   name: 'App'
};
</script>

<style>
   .navbar {
      width: 10%;
      position: fixed;
      top: 0; 
      bottom: 0;
      left: 0;
      overflow-y: auto;
   }

   .main-content {
      padding: 20px;
      width: 100%;
   }
</style>
