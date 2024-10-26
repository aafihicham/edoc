<template>
  <aside class="h-screen flex flex-row bg-gray-100">
    <div :class="['flex flex-col bg-cyan-950 rounded-r-3xl overflow-hidden transition-all duration-300', collapsed ? 'w-16' : 'w-56']">
      <div class="flex items-center justify-between h-20 shadow-md px-4">
        <h1 v-if="!collapsed" class="text-3xl uppercase text-indigo-500 transition-opacity duration-300">Edoc</h1>
        <button @click="toggleSidebar" class="text-yellow-500 focus:outline-none">
          <font-awesome-icon :icon="collapsed ? ['fas', 'chevron-right'] : ['fas', 'chevron-left']" />
        </button>
      </div>
      <ul class="flex flex-col py-4">
        <li>
          <router-link to="/dashboard/home" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-yellow-500 hover:text-sky-500">
            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-yellow-500"><font-awesome-icon :icon="['fas', 'list-check']" /></span>
            <span v-if="!collapsed" class="text-sm font-medium transition-opacity duration-300">Dashboard</span>
          </router-link>
        </li>
        <li>
          <router-link to="/dashboard/documents" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-yellow-500 hover:text-sky-500">
            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-yellow-500"><font-awesome-icon :icon="['fas', 'file-lines']" /></span>
            <span v-if="!collapsed" class="text-sm font-medium transition-opacity duration-300">Manage documents</span>
          </router-link>
        </li>
        <li>
          <router-link to="/dashboard/categories" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-yellow-500 hover:text-sky-500">
            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-yellow-500"><font-awesome-icon :icon="['fas', 'list']" /></span>
            <span v-if="!collapsed" class="text-sm font-medium transition-opacity duration-300">Manage categories</span>
          </router-link>
        </li>
        <li>
          <router-link to="/dashboard/profile" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-yellow-500 hover:text-sky-500">
            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-yellow-500"><font-awesome-icon :icon="['fas', 'user']" /></span>
            <span v-if="!collapsed" class="text-sm font-medium transition-opacity duration-300">Profile</span>
          </router-link>
        </li>
        <li>
          <router-link to="/dashboard/users" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-yellow-500 hover:text-sky-500">
            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-yellow-500"><font-awesome-icon :icon="['fas', 'user']" /></span>
            <span v-if="!collapsed" class="text-sm font-medium transition-opacity duration-300">Users management</span>
          </router-link>
        </li>
        <li>
          <router-link to="/dashboard/roles" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-yellow-500 hover:text-sky-500">
            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-yellow-500"><font-awesome-icon :icon="['fas', 'user']" /></span>
            <span v-if="!collapsed" class="text-sm font-medium transition-opacity duration-300">Roles</span>
          </router-link>
        </li>
        <li>
          <a href="#" @click.prevent="logout" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-red-500 hover:text-red-800">
            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-red-400"><font-awesome-icon :icon="['fas', 'right-from-bracket']" /></span>
            <span v-if="!collapsed" class="text-sm font-medium transition-opacity duration-300">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>

export default {


  data() {
    return {
      collapsed: false 
    };
  },

  
  methods: {
      logout() {
        localStorage.removeItem('token');
        this.$router.push('/login');
      },
      toggleSidebar() {
      this.collapsed = !this.collapsed;
    }
    }

    
};
</script>
