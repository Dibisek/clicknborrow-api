<!-- NavBar.vue -->
<template>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <nav>
      <router-link to="/homepage">
        <img src="@/assets/img/logo_vert.svg" alt="Vertical Logo">
      </router-link>
      <ul>
        <li>
          <router-link to="/homepage" class="bar-btn" title="Homepage">
            <i class="fa-solid fa-house"></i>
          </router-link>
        </li>
        <li>
          <router-link to="/search" class="bar-btn" title="Search books">
            <i class="fa-solid fa-magnifying-glass"></i>
          </router-link>
        </li>
        <!-- Menu dla admina -->
        <template v-if="isAdmin">
          <li>
            <router-link to="/addBook" class="bar-btn" title="Add book">
              <i class="fa-solid fa-book-medical"></i>
            </router-link>
          </li>
          <li>
            <router-link to="/reservationsAdmin" class="bar-btn" title="Show pending reservations">
              <i class="fa-regular fa-address-card"></i>
            </router-link>
          </li>
        </template>
        <!-- Menu dla zwykłego użytkownika -->
        <template v-else>
          <li>
            <router-link to="/bookmarks" class="bar-btn" title="Bookmarks">
              <i class="fa-solid fa-book-bookmark"></i>
            </router-link>
          </li>
          <li>
            <router-link to="/history" class="bar-btn" title="Reservations history">
              <i class="fa-regular fa-clock"></i>
            </router-link>
          </li>
        </template>
        <li>
          <a @click.prevent="handleLogout" href="#" class="bar-btn" title="Logout">
            <i class="fa-solid fa-door-open"></i>
          </a>
        </li>
      </ul>
    </nav>
  </template>
  
  <script>
  import { computed } from 'vue'
  import { useRouter } from 'vue-router'
  import { useStore } from 'vuex'
  
  export default {
    name: 'NavBar',
    setup() {
      const router = useRouter()
      const store = useStore()
  
      // Pobieranie stanu użytkownika ze store
    //   const isAdmin = computed(() => store.state.user?.isAdmin || false)
      // Add isAdmin to false
        const isAdmin =  false
  
      // Obsługa wylogowania
      const handleLogout = async () => {
        try {
          await store.dispatch('logout')
          router.push('/login')
        } catch (error) {
          console.error('Logout failed:', error)
        }
      }
  
      return {
        isAdmin,
        handleLogout
      }
    }
  }
  </script>
  
  <style scoped>
  
  </style>