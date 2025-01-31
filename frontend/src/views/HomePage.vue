<!-- HomePage.vue -->
<template>
    <div class="base-container">
      <NavBar />
      <main>
        <h1>Newly added</h1>
        <BookList :books="books" />
      </main>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue'
  import { useStore } from 'vuex'
  import NavBar from '@/components/NavBar.vue'
  import BookList from '@/components/BookList.vue'
  
  export default {
    name: 'HomePage',
    components: {
      NavBar,
      BookList
    },
    setup() {
      const store = useStore()
      // Add dummy data
      const books = ref([
        {
          id: 1,
          title: 'Book title',
          author: 'Book author',
          description: 'Book description',
        },
        {
          id: 2,
          title: 'Book title',
          author: 'Book author',
          description: 'Book description, dfsadfsdfahsdkfhj dfkjslafkdfjald dklfajsdkfjsdal fdasjkldsaljfkasdjfl kaj',
        },
        {
          id: 3,
          title: 'Book title',
          author: 'Book author',
          description: 'Book description',
        }
    ])
  
      const fetchBooks = async () => {
        try {
          const response = await fetch(`${import.meta.env.VITE_API_URL}/api/books`, {
            headers: {
              'Authorization': `Bearer ${store.state.user.token}`
            }
          })
          if (response.ok) {
            const data = await response.json()
            books.value = data
          }
        } catch (error) {
          console.error('Error fetching books:', error)
        }
      }
  
      onMounted(() => {
        fetchBooks()
      })
  
      return {
        books
      }
    }
  }
  </script>
  
  <style>
  /* Możesz zaimportować globalne style CSS */
  @import '@/assets/base.css';
  @import '@/assets/books.css';
  </style>