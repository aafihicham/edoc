<template>
    <aside class="w-64 h-screen bg-gray-800 text-white p-4">
      <ul>
        <li><router-link to="/dashboard" class="block py-2 px-4 hover:bg-gray-600">Home</router-link></li>
        <li><router-link to="/dashboard/profile" class="block py-2 px-4 hover:bg-gray-600">Profile</router-link></li>
        <li><router-link to="/dashboard/settings" class="block py-2 px-4 hover:bg-gray-600">Settings</router-link></li>
      </ul>
    </aside>
  </template>
  
  <script>
  export default {};
  </script>
  