<template>
  <div class="body-bg min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0">
    <header class="max-w-lg mx-auto">
      <h1 class="text-4xl font-bold text-white text-center">Edit Profile</h1>
    </header>

    <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
      <section v-if="publisher">
        <h3 class="font-bold text-2xl mb-6">Update Your Information</h3>
        <form @submit.prevent="submitForm" class="flex flex-col">
          <!-- Name Field -->
          <div class="mb-6 pt-3 rounded bg-gray-200">
            <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="name">Name</label>
            <input
              type="text"
              id="name"
              v-model="publisher.name"
              class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
            />
          </div>

          <!-- Email Field -->
          <div class="mb-6 pt-3 rounded bg-gray-200">
            <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
            <input
              type="email"
              id="email"
              v-model="publisher.email"
              class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
            />
          </div>

          <!-- Password Field -->
          <div class="mb-6 pt-3 rounded bg-gray-200">
            <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
            <input
              type="password"
              id="password"
              v-model="password"
              class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
            />
          </div>

          <!-- Confirm Password Field -->
          <div class="mb-6 pt-3 rounded bg-gray-200">
            <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="confirmPassword">Confirm Password</label>
            <input
              type="password"
              id="confirmPassword"
              v-model="confirmPassword"
              class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
            />
          </div>

          <button
            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
            type="submit"
          >
            Save Changes
          </button>
        </form>
      </section>

      <section v-else>
        <p class="text-red-500">Failed to load publisher data. Please try again later.</p>
      </section>
    </main>
  </div>
</template>

<script>
import http from "axios";
import { ref, onMounted } from "vue"; // Import Vue's ref and onMounted

export default {
  props: {
    publisherId: {
      type: [Number, String],
      required: true,
    },
  },
  setup(props) {
    const publisher = ref(null);
    const password = ref("");
    const confirmPassword = ref("");

    // Check if publisherId is provided
    if (!props.publisherId) {
      alert("Publisher ID is required.");
      // Optionally, you can redirect or handle this case as needed.
    } else {
      fetchPublisher(); // Only fetch if publisherId is valid
    }

    const fetchPublisher = async () => {
      try {
        const response = await http.get(`http://127.0.0.1:8000/api/publishers/${props.publisherId}`);
        publisher.value = response.data.data.publisher;
      } catch (error) {
        console.error("Failed to load publisher data:", error);
      }
    };

    const submitForm = async () => {
      if (password.value && password.value !== confirmPassword.value) {
        alert("Passwords do not match.");
        return;
      }

      try {
        const response = await http.put(`http://127.0.0.1:8000/api/publishers/${props.publisherId}`, {
          name: publisher.value.name,
          email: publisher.value.email,
          password: password.value,
          password_confirmation: confirmPassword.value,
        });
        alert(response.data.message || "Profile updated successfully!");
      } catch (error) {
        console.error("Failed to update profile:", error);
        alert("Failed to update profile. Please try again later.");
      }
    };

    return {
      publisher,
      password,
      confirmPassword,
      submitForm,
    };
  },
};
</script>

<style scoped>
.body-bg {
  background-color: #9921e8;
  background-image: linear-gradient(315deg, #9921e8 0%, #5f72be 74%);
}
</style>
