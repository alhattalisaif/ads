<template>
  <div class="user-page">
    <h1>صفحة المستخدم</h1>

    <section class="profile">
      <h2>الملف الشخصي</h2>
      <p><strong>الاسم:</strong> {{ user.name }}</p>
      <p><strong>البريد:</strong> {{ user.email }}</p>
      <p><strong>الدور:</strong> {{ user.role }}</p>

      <button @click="logout">تسجيل الخروج</button>
    </section>

    <section class="wallet" v-if="user.wallet">
      <h2>المحفظة</h2>
      <p>الرصيد النقدي: {{ formatCurrency(user.wallet.cash_balance) }}</p>
      <p>الرصيد الإضافي: {{ formatCurrency(user.wallet.bonus_balance) }}</p>
    </section>

    <section class="ads">
      <h2>إعلاناتي</h2>
      <div v-if="ads.length === 0">لا توجد إعلانات حتى الآن.</div>
      <ul>
        <li v-for="ad in ads" :key="ad.id">
          <h3>{{ ad.title }} <small>— {{ ad.status }}</small></h3>
          <p>{{ ad.content }}</p>
          <p><strong>السعر:</strong> {{ formatCurrency(ad.price) }}</p>
        </li>
      </ul>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../utils/api'

const user = ref({ name: '', email: '' })
const ads = ref([])

function formatCurrency(val) {
  if (val === null || val === undefined) return '0.00'
  return parseFloat(val).toFixed(2)
}

async function loadUser() {
  try {
    const res = await api.get('/user')
    user.value = res.data
    ads.value = res.data.ads || []
  } catch (e) {
    // not authenticated or error
    console.error(e)
  }
}

function logout() {
  localStorage.removeItem('api_token')
  api.defaults.headers.common['Authorization'] = null
  window.location.href = '/login'
}

onMounted(loadUser)
</script>

<style scoped>
.user-page { padding: 1rem }
.profile, .wallet, .ads { margin-bottom: 1.5rem }
</style>
