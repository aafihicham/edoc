<template>
    <div class="text-gray-900 bg-gray-200">
      <div class="p-4 flex">
        <h1 class="text-3xl">Roles Management</h1>
      </div>
      <div class="px-3 py-4 flex justify-center">
        <form @submit.prevent="createRole" class="w-full max-w-md">
          <input
            v-model="newRole.name"
            type="text"
            placeholder="Role Name"
            class="mb-4 p-2 border border-gray-300 rounded"
            required
          />
          <button
            type="submit"
            class="mb-4 text-sm bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded"
          >
            Create Role
          </button>
        </form>
      </div>
      <div class="px-3 py-4 flex justify-center">
        <table class="w-full text-md bg-white shadow-md rounded mb-4">
          <thead>
            <tr class="border-b">
              <th class="text-left p-3 px-5">Role Name</th>
              <th class="text-left p-3 px-5">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in roles" :key="role.id" class="border-b hover:bg-orange-100">
              <td class="p-3 px-5">{{ role.name }}</td>
              <td class="p-3 px-5 flex justify-end">
                <button @click="deleteRole(role.id)" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  import axiosInstance from '@/services/axiosInstance';
  
  export default {
    data() {
      return {
        newRole: {
          name: '',
        },
        roles: [],
      };
    },
    mounted() {
      this.fetchRoles();
    },
    methods: {
      async fetchRoles() {
        try {
          const response = await axiosInstance.get('/roles');
          this.roles = response.data;
        } catch (error) {
          console.error('Error fetching roles:', error);
        }
      },
      async createRole() {
        try {
          const response = await axiosInstance.post('/roles', this.newRole);
          this.roles.push(response.data);
          this.newRole.name = ''; // Clear input after submission
        } catch (error) {
          console.error('Error creating role:', error);
        }
      },
      async deleteRole(roleId) {
        try {
          await axiosInstance.delete(`/roles/${roleId}`);
          this.roles = this.roles.filter(role => role.id !== roleId);
        } catch (error) {
          console.error('Error deleting role:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any additional styles if needed */
  </style>
  