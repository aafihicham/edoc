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
        <p class="text-gray-600 pt-2">Sign in to your account.</p>
      </section>

      <section class="mt-10">
        <form @submit.prevent="submitForm" class="flex flex-col">
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
          <div class="flex justify-end">
            <a href="#" class="text-sm text-purple-600 hover:text-purple-700 hover:underline mb-6">Forgot your password?</a>
          </div>
          <button
            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
            type="submit"
          >
            Sign In
          </button>
        </form>
      </section>
    </main>

    <div class="max-w-lg mx-auto text-center mt-12 mb-6">
      <p class="text-white">Don't have an account? <router-link to="/register" class="font-bold hover:underline">Sign up</router-link>.</p>
    </div>

    <footer class="max-w-lg mx-auto flex justify-center text-white">
      <a href="#" class="hover:underline">Contact</a>
      <span class="mx-3">•</span>
      <a href="#" class="hover:underline">Privacy</a>
    </footer>
  </div>
</template>

<script>
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
  mounted() {
    if (this.isLoggedIn) {
      // Redirect to dashboard if already logged in
      this.$router.push('/dashboard');
    }
  },
  methods: {
    async submitForm() {
      // Input validation
      if (!this.email || !this.password) {
        alert('Please fill in both email and password.');
        return;
      }

      try {
        const response = await AuthService.login({ email: this.email, password: this.password });
        console.log('Response:', response);

        if (response && response.token && response.user) {
            const { user, token } = response;

            // Store the token in local storage
            localStorage.setItem('token', token);

        // Show a welcome message
        alert(`Welcome, ${user.name}! You have successfully logged in.`);

        // Redirect to the dashboard or any protected route after login
        this.$router.push('/dashboard');

      } else {
            throw new Error("Unexpected response structure");
        }

      } catch (error) {
        // Check for a response from the server
        if (error.response) {
          console.error('Login failed:', error.response.data);
          alert(`Login failed: ${error.response.data.message || 'Invalid credentials'}`);
        } else {
          // Handle network errors
          console.error('Network error:', error);
          alert('Login failed: Network error. Please check your connection or try again later.');
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