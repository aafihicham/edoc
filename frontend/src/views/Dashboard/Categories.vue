<template>
  <div class="text-gray-900 bg-gray-200">
    <div class="p-4 flex justify-between">
      <h1 class="text-3xl">Categories</h1>
      <div>
        <input v-model="newCategoryLabel" placeholder="Enter new category" class="mr-2 px-2 py-1 border rounded">
        <button @click="createCategory" class="bg-green-500 text-white py-1 px-4 rounded">Add Category</button>
      </div>
    </div>

    <div v-if="categories.length > 0" class="px-3 py-4">
      <table class="w-full text-md bg-white shadow-md rounded mb-4">
        <thead>
          <tr class="border-b">
            <th class="text-left p-3 px-5">Category ID</th>
            <th class="text-left p-3 px-5">Category Name</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id" class="border-b hover:bg-orange-100">
            <td class="p-3 px-5">{{ category.id }}</td>
            <td class="p-3 px-5">
              <input v-model="category.label" class="bg-transparent">
            </td>
            <td class="p-3 px-5 flex justify-end">
              <button @click="updateCategory(category)" class="mr-3 bg-blue-500 text-white py-1 px-2 rounded">Save</button>
              <button @click="deleteCategory(category.id)" class="bg-red-500 text-white py-1 px-2 rounded">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else class="p-4">
      <p>No categories found. Create one now!</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      categories: [],
      newCategoryLabel: '',
    };
  },
  created() {
    this.fetchCategories();
  },
  methods: {
    // Fetch the categories from the API
    async fetchCategories() {
      try {
        const token = localStorage.getItem('token'); // Retrieve token from local storage
        const response = await axios.get('http://127.0.0.1:8000/api/categories', {
          headers: {
            Authorization: `Bearer ${token}` // Include token in request headers
          }
        });
        this.categories = response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },

    // Create a new category
    async createCategory() {
      if (!this.newCategoryLabel.trim()) {
        alert('Category label cannot be empty');
        return;
      }

      try {
        const token = localStorage.getItem('token'); // Retrieve token from local storage
        const response = await axios.post('http://127.0.0.1:8000/api/categories', {
          label: this.newCategoryLabel,
        }, {
          headers: {
            Authorization: `Bearer ${token}` // Include token in request headers
          }
        });
        this.categories.push(response.data);
        this.newCategoryLabel = ''; // Clear input field
      } catch (error) {
        console.error('Error creating category:', error);
      }
    },

    // Update an existing category
    async updateCategory(category) {
      try {
        const token = localStorage.getItem('token'); // Retrieve token from local storage
        await axios.put(`http://127.0.0.1:8000/api/categories/${category.id}`, {
          label: category.label,
        }, {
          headers: {
            Authorization: `Bearer ${token}` // Include token in request headers
          }
        });
        alert('Category updated successfully!');
      } catch (error) {
        console.error('Error updating category:', error);
      }
    },

    // Delete a category
    async deleteCategory(id) {
      try {
        const token = localStorage.getItem('token'); // Retrieve token from local storage
        await axios.delete(`http://127.0.0.1:8000/api/categories/${id}`, {
          headers: {
            Authorization: `Bearer ${token}` // Include token in request headers
          }
        });
        this.categories = this.categories.filter(category => category.id !== id);
        alert('Category deleted successfully!');
      } catch (error) {
        console.error('Error deleting category:', error);
      }
    }
  }
};
</script>
