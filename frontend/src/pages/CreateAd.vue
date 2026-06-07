<template>
  <div>
    <h1>Create Ad</h1>
    <form @submit.prevent="submit">
      <div>
        <label>Title</label>
        <input v-model="title" />
      </div>
      <div>
        <label>Content</label>
        <textarea v-model="content"></textarea>
      </div>
      <div>
        <label>Price</label>
        <input type="number" v-model.number="price" />
      </div>
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue'

const title = ref('')
const content = ref('')
const price = ref(0)

async function submit() {
  try {
    const res = await axios.post('/api/ads', { title: title.value, content: content.value, price: price.value })
    alert('Ad created')
  } catch (e) {
    alert('Error creating ad')
  }
}
</script>
