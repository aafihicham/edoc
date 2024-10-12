<template>
    <div class="body-bg min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0" style="font-family: 'Lato', sans-serif;">
      <header class="max-w-lg mx-auto">
        <a href="#">
          <h1 class="text-4xl font-bold text-white text-center">eDoc document management</h1>
        </a>
      </header>
  
      <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
          <h3 class="font-bold text-2xl">Welcome to Startup</h3>
          <p class="text-gray-600 pt-2">Create your account.</p>
        </section>
  
        <section class="mt-10">
          <form @submit.prevent="submitForm" class="flex flex-col">
            <div class="mb-6 pt-3 rounded bg-gray-200">
                  <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="name">Name</label>
                  <input
                    type="text"
                    id="name"
                    v-model="name"
                    class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
                  />
                </div>
            <div class="mb-6 pt-3 rounded bg-gray-200">
              <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
              <input
                type="text"
                id="email"
                v-model="email"
                class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
              />
            </div>
            <div class="mb-6 pt-3 rounded bg-gray-200">
              <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
              <input
                type="password"
                id="password"
                v-model="password"
                class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
              />
            </div>
            <button
              class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
              type="submit"
            >
              Register
            </button>
          </form>
        </section>
      </main>
  
      <div class="max-w-lg mx-auto text-center mt-12 mb-6">
        <p class="text-white">Already have an account? <RouterLink to="/login" class="font-bold hover:underline">Sign in</RouterLink>.</p>
      </div>
  
      <footer class="max-w-lg mx-auto flex justify-center text-white">
        <a href="#" class="hover:underline">Contact</a>
        <span class="mx-3">•</span>
        <a href="#" class="hover:underline">Privacy</a>
      </footer>
    </div>
  </template>
  
  <script>

import http from 'axios';
import { RouterLink } from 'vue-router';

  export default {
    data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: ''
    };
  },
  methods: {
  async submitForm() {
    try {
      const response = await http.post('http://127.0.0.1:8000/api/register', {
        name: this.name,
        email: this.email,
        password: this.password,
      });
      console.log(response.data);

      // Notification on successful registration
      alert('Registration successful! You will be redirected to the login page.');

      // Redirect to login page
      this.$router.push('/login');
      
    } catch (error) {
      console.error(error); // Log the full error for debugging

      // Check if error.response exists
      if (error.response) {
        alert('Registration failed: ' + error.response.data.message);
      } else {
        alert('Registration failed due to a network error or server issue.');
      }
    }
  }
}
};
</script>
  
  <style scoped>
  .body-bg {
    background-color: #9921e8;
    background-image: linear-gradient(315deg, #9921e8 0%, #5f72be 74%);
  }
  </style>  