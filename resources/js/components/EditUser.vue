<template>
   <div class="container mt-5">
      <h1 class="mb-4">Edit User</h1>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <form @submit.prevent="updateUser">
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
         <button type="submit" class="btn btn-primary">Actualizar</button>
      </form>
   </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';

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
      const route = useRoute();

      const fetchUser = async () => {
         try {
            const uri = `http://localhost:8000/api/users/${route.params.id}`;
            const response = await axios.get(uri);
            user.value = response.data;
         } catch (error) {
            console.error('Error fetching user:', error);
         }
      };

      const updateUser = async () => {
         try {
            const uri = `http://localhost:8000/api/users/${route.params.id}`;
            await axios.put(uri, user.value);
            successMessage.value = 'Usuario actualizado correctamente';
            errorMessage.value = '';
            setTimeout(() => {
               router.push({ name: 'Users' });
            }, 3000);
         } catch (error) {
            errorMessage.value = 'Error actualizando el usuario: ' + error.response.data.message;
            console.error('Error actualizando user:', error);
         }
      };

      onMounted(fetchUser);

      return {
         user,
         errorMessage,
         successMessage,
         updateUser
      };
   }
}
</script>
