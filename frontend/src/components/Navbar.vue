<template>
    <nav class="bg-purple-600 p-4">
      <ul class="flex justify-between">
        <li class="text-white font-bold">Dashboard</li>
        <li class="text-white">
          <button @click="logout">Logout</button>
        </li>
      </ul>
    </nav>
  </template>
  
  <script>
  export default {
    methods: {
      logout() {
        localStorage.removeItem('token');
        this.$router.push('/login');
      }
    }
  };
  </script>
  