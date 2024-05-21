<template>
   <div class="container mt-5">
      <h1 class="mb-4">Importar datos desde Excel</h1>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <div v-if="loading" class="alert alert-info">Cargando...</div>
      <input type="file" ref="file" @change="handleFileUpload" accept=".xlsx, .xls">
      <button @click="uploadFile">Importar Archivo</button>
   </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
   setup() {
      const successMessage = ref('');
      const errorMessage = ref('');
      const file = ref(null);
      const router = useRouter();
      const loading = ref(false);

      const handleFileUpload = (event) => {
         file.value = event.target.files[0];
      };

      const uploadFile = async () => {
         loading.value = true;
         const formData = new FormData();
         formData.append('file', file.value);
         
         try {
            const response = await axios.post('/api/import-excel', formData, {
               headers: {
                  'Content-Type': 'multipart/form-data'
               }
            });
            successMessage.value = response.data.success;
            errorMessage.value = '';
            setTimeout(() => {
               router.push({ name: 'Vehicles' });
            }, 3000);
         } catch (error) {
            if (error.response && error.response.data.error) {
               errorMessage.value = error.response.data.error;
            }
            successMessage.value = '';
         } finally {
            loading.value = false;
         }
         
      };

      return {
         successMessage,
         errorMessage,
         handleFileUpload,
         uploadFile,
         loading
      };
   }
}
</script>
