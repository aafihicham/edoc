<template>
  <div class="flex flex-col bg-gray-300 p-10 font-sans-serif items-center justify-center">
    <div class="relative h-auto bg-white rounded-lg shadow-lg w-4/5">
      <div class="relative border-b-2">
        <h1 class="text-3xl m-4 text-gray-600">Upload Document</h1>
      </div>
      <div class="relative p-4">
        <form @submit.prevent="uploadDocument" enctype="multipart/form-data">
          <div class="mb-4 pt-0 flex flex-col">
            <label class="mb-2 text-gray-800 text-lg font-light" for="title">Title</label>
            <input v-model="form.title" type="text" id="title" class="border-2 rounded h-10 px-6 text-lg text-gray-600 focus:outline-none focus:ring focus:border-blue-300" required />
          </div>
          <div class="mb-4 pt-0 flex flex-col">
            <label class="mb-2 text-gray-800 text-lg font-light" for="documentType">Document Type</label>
            <input v-model="form.documentType" type="text" id="documentType" class="border-2 rounded h-10 px-6 text-lg text-gray-600 focus:outline-none focus:ring focus:border-blue-300" required />
          </div>
          <div class="mb-4 pt-0 flex flex-col">
            <label class="mb-2 text-gray-800 text-lg font-light" for="categoryId">Select Category</label>
            <select v-model="form.categoryId" id="categoryId" class="border-2 rounded h-10 px-6 text-lg text-gray-600 focus:outline-none focus:ring focus:border-blue-300" required>
              <option value="" disabled>Select a category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.label }}</option>
            </select>
          </div>
          <div class="pt-0 flex flex-col">
            <label class="mb-4 text-gray-600 text-lg font-light" for="document">Upload Document</label>
            <label for="document" class="flex flex-col items-center justify-center border-4 border-gray-300 border-dashed rounded h-36 px-6 text-lg text-gray-600 focus:outline-none focus:ring focus:border-blue-300 cursor-pointer">
              <svg class="w-8 h-8 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
              </svg>
              <span class="mt-2 text-base leading-normal text-blue-500 font-bold">Select a file</span>
              <input type="file" id="document" @change="handleFileUpload" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx" required />
            </label>
            <p class="py-2 text-gray-400">Accepted file types: .pdf, .doc, .docx, .xls, .xlsx</p>
            <p v-if="selectedFile" class="mt-2 text-gray-600">Selected file: {{ selectedFile.name }}</p>
          </div>
          <div class="relative pt-0 flex flex-col p-4 w-full">
            <input type="submit" value="Upload" class="bg-blue-500 text-white h-16 rounded-lg font-bold hover:bg-blue-600">
          </div>
        </form>
      </div>
      <div class="relative p-4">
        <h2 class="text-2xl text-gray-600 mb-4">Your Documents</h2>
        <table class="min-w-full bg-white border shadow">
          <thead>
            <tr class="bg-gray-200">
              <th class="py-2 px-4 border">Title</th>
              <th class="py-2 px-4 border">Document Type</th>
              <th class="py-2 px-4 border">Category</th>
              <th class="py-2 px-4 border">Uploaded At</th>
              <th class="py-2 px-4 border">Actions</th> <!-- Changed from Status to Actions -->
            </tr>
          </thead>
          <tbody>
              <tr v-for="document in documents" :key="document.id">
                <td class="py-2 px-4 border">{{ document.title }}</td>
                <td class="py-2 px-4 border">{{ document.documentType }}</td>
                <td class="py-2 px-4 border">{{ document.category ? document.category.label : 'N/A' }}</td> <!-- Display category name -->
                <td class="py-2 px-4 border">{{ formatDate(document.created_at) }}</td>
                <td class="py-2 px-4 border">
                  <button @click="deleteDocument(document.id)" class="text-red-500">Delete</button>
                </td>
              </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import dayjs from 'dayjs';

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
});

axiosInstance.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
    console.log('Token found:', token);
  } else {
    console.error('No token found in local storage');
  }
  return config;
}, (error) => {
  return Promise.reject(error);
});

export default {
  data() {
    return {
      form: {
        title: '',
        documentType: '',
        document: null,
        categoryId: '',
      },
      documents: [],
      categories: [],
      selectedFile: null,
    };
  },
  methods: {

    formatDate(date) {
      return dayjs(date).format('YYYY-MM-DD [time] HH:mm'); // Format the date as desired
    },
    
    handleFileUpload(event) {
      this.form.document = event.target.files[0];
      this.selectedFile = event.target.files[0];
    },
    async uploadDocument() {
      const formData = new FormData();
      formData.append('title', this.form.title);
      formData.append('documentType', this.form.documentType);
      formData.append('document', this.form.document);
      formData.append('categoryId', this.form.categoryId);

      console.log('Form data being sent:', formData);

      try {
        await axiosInstance.post('/documents', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        await this.fetchDocuments();
        this.resetForm();
      } catch (error) {
        console.error('Error uploading document:', error);
        alert('Failed to upload document. Please try again.');
      }
    },
    async fetchDocuments() {
      try {
        const response = await axiosInstance.get('/documents');
        console.log('Documents response:', response.data);
        if (Array.isArray(response.data)) {
          this.documents = response.data;
        } else {
          console.error('Documents response is not an array:', response.data);
          alert('Failed to fetch documents. Please try again later.');
        }
      } catch (error) {
        console.error('Error fetching documents:', error);
        if (error.response && error.response.status === 401) {
          alert('Unauthorized. Please check your token.');
        } else {
          alert('Failed to fetch documents. Please try again later.');
        }
      }
    },
    async fetchCategories() {
      try {
        const response = await axiosInstance.get('/categories');
        console.log('Categories response:', response.data);
        if (Array.isArray(response.data)) {
          this.categories = response.data;
        } else {
          console.error('No categories found or data is not an array:', response.data);
          alert('Failed to fetch categories. Please try again later.');
        }
      } catch (error) {
        console.error('Error fetching categories:', error);
        alert('Failed to fetch categories. Please try again later.');
      }
    },
    async deleteDocument(id) {
      try {
        await axiosInstance.delete(`/documents/${id}`);
        await this.fetchDocuments();
        alert('Document deleted successfully.');
      } catch (error) {
        console.error('Error deleting document:', error);
        alert('Failed to delete document. Please try again.');
      }
    },
    resetForm() {
      this.form.title = '';
      this.form.documentType = '';
      this.form.document = null;
      this.form.categoryId = '';
      this.selectedFile = null;
    },
  },
  mounted() {
    this.fetchCategories();
    this.fetchDocuments();
  },
};
</script>

<style scoped>
/* Add any scoped styles you need here */
</style>
