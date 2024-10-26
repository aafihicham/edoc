<template>
    <div class="text-gray-900 bg-gray-200">
        <div class="p-4 flex">
            <h1 class="text-3xl">Users</h1>
        </div>
        <div class="px-3 py-4 flex justify-center">
            <table class="w-full text-md bg-white shadow-md rounded mb-4">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-3 px-5">Name</th>
                        <th class="text-left p-3 px-5">Email</th>
                        <th class="text-left p-3 px-5">Current Role</th> <!-- Add column for role name -->
                        <th class="text-left p-3 px-5">Change Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="index" class="border-b hover:bg-orange-100 bg-gray-100">
                        <td class="p-3 px-5">
                            <input v-model="user.name" type="text" class="bg-transparent">
                        </td>
                        <td class="p-3 px-5">
                            <input v-model="user.email" type="text" class="bg-transparent">
                        </td>
                        <!-- Display the current role name -->
                        <td class="p-3 px-5">
                            {{ getRoleName(user.RoleId) }}  <!-- Use RoleId -->
                        </td>
                        <!-- Add role change dropdown -->
                        <td class="p-3 px-5">
                            <select v-model="user.RoleId" class="bg-transparent">
                                <option v-for="role in roles" :value="role.id" :key="role.id">{{ role.name }}</option>
                            </select>
                        </td>
                        <td class="p-3 px-5 flex justify-end">
                            <button @click="updateUser(user)" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">Save</button>
                            <button @click="deleteUser(user.id)" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">Delete</button>
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
            users: [],
            roles: [],
        };
    },
    methods: {
        async fetchUsersAndRoles() {
            try {
                const usersResponse = await axiosInstance.get('/users');
                const rolesResponse = await axiosInstance.get('/roles');
                this.users = usersResponse.data.map(user => ({
                    ...user,
                    RoleId: user.RoleId,  // Make sure 'RoleId' is correctly mapped
                }));
                this.roles = rolesResponse.data;
                console.log('Fetched users:', this.users);
            } catch (error) {
                console.error('Error fetching users or roles:', error);
            }
        },
        async updateUser(user) {
            try {
                const response = await axiosInstance.put(`/users/${user.id}`, {
                    name: user.name,
                    email: user.email,
                    RoleId: user.RoleId,  // Ensure consistency here
                });
                console.log('Update response:', response.data);
                alert('User updated successfully');
            } catch (error) {
                console.error('Error updating user:', error);
                alert('Error updating user');
            }
        },
        async deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                try {
                    await axiosInstance.delete(`/users/${userId}`);
                    this.users = this.users.filter(user => user.id !== userId);
                    alert('User deleted successfully');
                } catch (error) {
                    console.error('Error deleting user:', error);
                    alert('Error deleting user');
                }
            }
        },
        getRoleName(roleId) {
            const role = this.roles.find(r => r.id === roleId);
            return role ? role.name : 'Unknown';  // Updated to handle unknown roles
        },
    },
    mounted() {
        this.fetchUsersAndRoles();
    },
};
</script>
