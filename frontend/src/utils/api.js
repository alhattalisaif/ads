import axios from 'axios'

const instance = axios.create({
  baseURL: (import.meta.env.VITE_API_BASE_URL) ? import.meta.env.VITE_API_BASE_URL : '/api',
  withCredentials: false
})

const token = localStorage.getItem('api_token')
if (token) {
  instance.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

export default instance
