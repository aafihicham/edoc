<template>
    <div class="flex">
      <!-- Sidebar -->
      <Sidebar />
  
      <!-- Main content -->
      <div class="flex-1">
        <!-- Navbar -->
        <Navbar />
  
        <!-- Main Content -->
        <div class="p-6">
          <router-view />
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Navbar from '../components/Navbar.vue';
  import Sidebar from '../components/Sidebar.vue';
  
  export default {
    components: {
      Navbar,
      Sidebar
    }
  };
  </script>
  
  <style scoped>
  .flex {
    display: flex;
    min-height: 100vh;
  }
  .flex-1 {
    flex: 1;
    background-color: #f4f4f4;
  }
  </style>
  