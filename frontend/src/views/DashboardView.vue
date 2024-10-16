<template>
    <h1>hi there</h1>
    <button v-if="isLoggedIn" @click="logout"
        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        Logout
    </button>

</template>

<script>

import axios from 'axios';
import AuthService from '../services/AuthService';



export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  computed: {
    isLoggedIn() {
      return !!localStorage.getItem('token');
    }
  },
  methods: {
    async submitForm() {
    },
    async logout() {
      try {
        await AuthService.logout();

        localStorage.removeItem('token');

        this.$router.push('/login');

        alert('You have successfully logged out.');

      } catch (error) {
        console.error('Logout failed:', error);
        alert('Logout failed. Please try again.');
      }
    }
  }
    
};

</script>