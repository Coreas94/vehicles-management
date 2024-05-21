<template>
   <div class="container mt-5">
      <h1 class="mb-4">Crear nuevo usuario</h1>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <form @submit.prevent="createUser">
         <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" v-model="user.name" class="form-control" id="name" required>
         </div>
         <div class="mb-3">
            <label for="surname" class="form-label">Apellido</label>
            <input type="text" v-model="user.surname" class="form-control" id="surname" required>
         </div>
         <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="email" v-model="user.email" class="form-control" id="email" required>
         </div>
         
         <button type="submit" class="btn btn-primary">Crear</button>
      </form>
   </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
   setup() {
      const user = ref({
         name: '',
         surname: '',
         email: '',
         password: ''
      });
      const errorMessage = ref('');
      const successMessage = ref('');
      const router = useRouter();

      const createUser = async () => {
        const uri = 'http://localhost:8000/api/users'
         await axios.post(uri, user.value)
         .then(response => {
            successMessage.value = response.data.success;
            errorMessage.value = '';
            setTimeout(() => {
               router.push({ name: 'Users' });
            }, 3000);
         })
         .catch(error => {
            if(error.response.data.error){
               errorMessage.value = error.response.data.error;
            }
            successMessage.value = '';
         });
      };

      return {
         successMessage,
         user,
         errorMessage,
         createUser
      };
   }
}
</script>
