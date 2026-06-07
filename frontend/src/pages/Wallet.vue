<template>
  <div>
    <h1>Wallet</h1>
    <p>Balance: {{ wallet ? wallet.cash_balance : '0.00' }}</p>
    <form @submit.prevent="deposit">
      <input v-model.number="amount" type="number" step="0.01" />
      <button type="submit">Deposit</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const wallet = ref(null)
const amount = ref(0)

onMounted(async () => {
  try {
    const res = await axios.get('/api/wallet')
    wallet.value = res.data
  } catch (e) {
    // not authenticated
  }
})

async function deposit() {
  try {
    await axios.post('/api/wallet/deposit', { amount: amount.value })
    alert('Deposited')
  } catch (e) {
    alert('Error')
  }
}
</script>
