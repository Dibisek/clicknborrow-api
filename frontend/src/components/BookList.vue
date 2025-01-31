<!-- BookList.vue -->
<template>
    <section class="books-container">
      <div v-for="book in books" :key="book.id" :id="'project-' + book.id">
        <div class="top-box">
          <img :src="getBookImageUrl(book.photo)" alt="Book Cover">
          
          <p class="description">{{ book.description }}</p>
        </div>
        <h2 class="book-title koho-title">{{ book.title }}</h2>
        <div class="bottom-box" :id="book.id">
          <p class="book-author">{{ book.author }}</p>
          <div class="func-container">
            <div class="bookmark-container">
              <div 
                class="bookmark" 
                @click="toggleBookmark(book.id)"
              >
                <i :class="[
                  isBookmarked(book.id) ? 'fa-solid' : 'fa-regular',
                  'fa-bookmark'
                ]"></i>
              </div>
            </div>
          </div>
  
          <router-link :to="'/bookDetails/' + book.id">
            <i class="fa-regular fa-share-from-square"></i>
          </router-link>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue'
  import { useStore } from 'vuex'

  // As dummy image use the image from the assets/img folder
  // import bookImage from '@/assets/img/previmg.jpeg
  
  export default {
    name: 'BookList',
    props: {
      books: {
        type: Array,
        required: true
      }
    },
    setup(props) {
      const store = useStore()
      const bookmarks = ref([])
  
      const getBookImageUrl = (photo) => {
        return `${import.meta.env.VITE_API_URL}/storage/books/${photo}`
      }
  
    //   const isBookmarked = (bookId) => {
    //     return bookmarks.value.includes(bookId)
    //   }

        const isBookmarked = (bookId) => {
            return false;
        }
  
      const toggleBookmark = async (bookId) => {
        try {
          if (isBookmarked(bookId)) {
            await store.dispatch('removeBookmark', bookId)
            bookmarks.value = bookmarks.value.filter(id => id !== bookId)
          } else {
            await store.dispatch('addBookmark', bookId)
            bookmarks.value.push(bookId)
          }
        } catch (error) {
          console.error('Error toggling bookmark:', error)
        }
      }
  
      const fetchBookmarks = async () => {
        try {
          const response = await fetch(`${import.meta.env.VITE_API_URL}/api/bookmarks`, {
            headers: {
              'Authorization': `Bearer ${store.state.user.token}`
            }
          })
          if (response.ok) {
            const data = await response.json()
            bookmarks.value = data.map(bookmark => bookmark.book_id)
          }
        } catch (error) {
          console.error('Error fetching bookmarks:', error)
        }
      }
  
      onMounted(() => {
        fetchBookmarks()
      })
  
      return {
        bookmarks,
        isBookmarked,
        toggleBookmark,
        getBookImageUrl
      }
    }
  }
  </script>