<!-- Login.vue -->
<template>
    <div class="container">
      <div class="flex-row-center-center">
        <img src="@/assets/img/Logotype.svg" alt="logo" class="login-logo">
      </div>
      <div class="flex-row-center-center">
        <h1>Sign in</h1>
  
        <form class="flex-row-center-center" @submit.prevent="handleSubmit">
          <input 
            v-model="formData.email"
            type="email" 
            placeholder="Email" 
            class="btn-gradient"
            :class="{ 'error': errors.email }"
          >
          <input 
            v-model="formData.password"
            type="password" 
            placeholder="Password" 
            class="btn-gradient"
            :class="{ 'error': errors.password }"
          >
          <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
          <button type="submit" :disabled="isLoading">
            {{ isLoading ? 'Loading...' : 'Confirm' }}
          </button>
        </form>
  
        <router-link to="/register" class="sign-up-btn">Sign up</router-link>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, reactive } from 'vue'
  import { useRouter } from 'vue-router'
  // Add environment variables
  const apiUrl = import.meta.env.VITE_API_URL
  
  export default {
    name: 'LoginView',
    setup() {
      const router = useRouter()
      const isLoading = ref(false)
      const errorMessage = ref('')
      
      const formData = reactive({
        email: '',
        password: ''
      })
      
      const errors = reactive({
        email: false,
        password: false
      })
  
      const handleSubmit = async () => {
        // Reset errors
        errors.email = false
        errors.password = false
        errorMessage.value = ''
  
        // Simple validation
        if (!formData.email) {
          errors.email = true
          errorMessage.value = 'Email is required'
          return
        }
        if (!formData.password) {
          errors.password = true
          errorMessage.value = 'Password is required'
          return
        }
  
        try {
          isLoading.value = true
          const response = await fetch(apiUrl + '/login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
          })
  
          const data = await response.json()
  
          if (!response.ok) {
            throw new Error(data.message || 'Login failed')
          }
  
          // Store the token in localStorage or your preferred storage method
          localStorage.setItem('token', data.token)
          
          // Redirect to dashboard or home page
          router.push('/dashboard')
        } catch (error) {
          errorMessage.value = error.message
        } finally {
          isLoading.value = false
        }
      }
  
      return {
        formData,
        errors,
        errorMessage,
        isLoading,
        handleSubmit
      }
    }
  }
  </script>
  
  <style scoped>
  .container {
    /* Zachowaj style z oryginalnego CSS */
  }
  
  .error-message {
    color: red;
    margin: 8px 0;
  }
  
  .error {
    border-color: red;
  }
  
  /* Reszta stylów z oryginalnego CSS */
  </style>