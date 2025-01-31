<!-- Register.vue -->
<template>
    <div class="container">
      <div class="flex-row-center-center">
        <img src="@/assets/img/Logotype.svg" alt="logo" class="login-logo">
      </div>
      <div class="flex-row-center-center">
        <h1>Sign up</h1>
  
        <form class="flex-row-center-center" @submit.prevent="handleSubmit">
          <input 
            v-model="formData.firstname"
            type="text" 
            placeholder="First Name*" 
            class="btn-gradient"
            :class="{ 'error': errors.firstname }"
            required
          >
          <input 
            v-model="formData.surname"
            type="text" 
            placeholder="Last Name*" 
            class="btn-gradient"
            :class="{ 'error': errors.surname }"
            required
          >
          <input 
            v-model="formData.phone_nb"
            type="tel" 
            placeholder="Phone Number" 
            class="btn-gradient"
            :class="{ 'error': errors.phone_nb }"
          >
          <input 
            v-model="formData.email"
            type="email" 
            placeholder="Email*" 
            class="btn-gradient"
            :class="{ 'error': errors.email }"
            required
          >
          <input 
            v-model="formData.password"
            type="password" 
            placeholder="Password*" 
            class="btn-gradient"
            :class="{ 'error': errors.password }"
            required
          >
          <input 
            v-model="formData.password_conf"
            type="password" 
            placeholder="Confirm Password*" 
            class="btn-gradient"
            :class="{ 'error': errors.password_conf }"
            required
          >
          
          <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
          <button type="submit" :disabled="isLoading">
            {{ isLoading ? 'Loading...' : 'Confirm' }}
          </button>
        </form>
  
        <router-link to="/login" class="sign-up-btn">Sign in</router-link>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, reactive } from 'vue'
  import { useRouter } from 'vue-router'
  
  export default {
    name: 'RegisterView',
    setup() {
      const router = useRouter()
      const isLoading = ref(false)
      const errorMessage = ref('')
      
      const formData = reactive({
        firstname: '',
        surname: '',
        phone_nb: '',
        email: '',
        password: '',
        password_conf: ''
      })
      
      const errors = reactive({
        firstname: false,
        surname: false,
        phone_nb: false,
        email: false,
        password: false,
        password_conf: false
      })
  
      const validateForm = () => {
        let isValid = true
        
        // Reset errors
        Object.keys(errors).forEach(key => errors[key] = false)
        errorMessage.value = ''
  
        // Required fields validation
        if (!formData.firstname.trim()) {
          errors.firstname = true
          errorMessage.value = 'First name is required'
          isValid = false
        }
  
        if (!formData.surname.trim()) {
          errors.surname = true
          errorMessage.value = 'Last name is required'
          isValid = false
        }
  
        if (!formData.email.trim()) {
          errors.email = true
          errorMessage.value = 'Email is required'
          isValid = false
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
          errors.email = true
          errorMessage.value = 'Invalid email format'
          isValid = false
        }
  
        if (!formData.password) {
          errors.password = true
          errorMessage.value = 'Password is required'
          isValid = false
        } else if (formData.password.length < 6) {
          errors.password = true
          errorMessage.value = 'Password must be at least 6 characters long'
          isValid = false
        }
  
        if (formData.password !== formData.password_conf) {
          errors.password_conf = true
          errorMessage.value = 'Passwords do not match'
          isValid = false
        }
  
        // Phone number validation (optional)
        if (formData.phone_nb && !/^\+?[\d\s-]{9,}$/.test(formData.phone_nb)) {
          errors.phone_nb = true
          errorMessage.value = 'Invalid phone number format'
          isValid = false
        }
  
        return isValid
      }
  
      const handleSubmit = async () => {
        if (!validateForm()) {
          return
        }
  
        try {
          isLoading.value = true
          const response = await fetch('http://your-api-url/api/register', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              ...formData,
              password_confirmation: formData.password_conf // Dostosuj nazwę pola według API
            })
          })
  
          const data = await response.json()
  
          if (!response.ok) {
            throw new Error(data.message || 'Registration failed')
          }
  
          // Opcjonalnie: automatyczne logowanie po rejestracji
          // localStorage.setItem('token', data.token)
          
          // Przekierowanie na stronę logowania
          router.push('/login')
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
  .error {
    border-color: red;
  }
  
  .error-message {
    color: red;
    margin: 8px 0;
  }
  
  /* Reszta stylów z oryginalnego CSS */
  </style>