<template>
  <div>
    <h2>Login</h2>
    <button @click="loginWithGoogle">Login with Google</button>
  </div>
</template>

<script setup>
import axios from 'axios'

function loginWithGoogle() {
  // Redirect to backend OAuth endpoint or open popup
  alert('Implement Google OAuth flow');
}
</script>
