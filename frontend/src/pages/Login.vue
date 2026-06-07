<template>
  <div>
    <h2>Login</h2>
    <button @click="loginWithGoogle">Login with Google</button>
  </div>
</template>

<script setup>
import axios from '../utils/api'
import { onMounted, ref } from 'vue'

const token = ref(null)

function loginWithGoogle() {
  axios.get('/auth/google/redirect')
    .then(res => {
      const url = res.data.url
      const w = window.open(url, 'google_oauth', 'width=600,height=700')

      // Listen for message from popup
      function listener(e) {
        try {
          const data = typeof e.data === 'string' ? JSON.parse(e.data) : e.data
          if (data && data.token) {
            localStorage.setItem('api_token', data.token)
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.token
            alert('Logged in')
            window.removeEventListener('message', listener)
            if (w) w.close()
            window.location.href = '/'
          }
        } catch (err) {
          // ignore
        }
      }

      window.addEventListener('message', listener, false)
    })
    .catch(err => {
      alert('Unable to initiate Google OAuth')
    })
}
</script>
