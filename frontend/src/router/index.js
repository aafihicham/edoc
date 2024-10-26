import { createRouter, createWebHistory } from 'vue-router'
import RegisterView from '../views/auth/RegisterView.vue'
import LoginView from '../views/auth/LoginView.vue'


import DashboardLayout from '../layout/DashboardLayout.vue';
import Home from '../views/Dashboard/Home.vue';
import Profile from '../views/Dashboard/Profile.vue';
import Settings from '../views/Dashboard/Settings.vue';
import Documents from '../views/Dashboard/Documents.vue';
import Categories from '../views/Dashboard/Categories.vue';
import UsersManagement from '../views/Dashboard/UsersManagement.vue';
import Roles from '../views/Dashboard/Roles.vue';


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [

    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },

    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/dashboard',
      name: 'DashboardLayout',
      component: DashboardLayout,
      children: [
        { path: 'home', component: Home },
        { path: 'profile/:publisherId', component: Profile, props: true }, 
        { path: 'profile', component: Profile, props: { publisherId: null } },
        { path: 'settings', component: Settings },
        { path: 'documents', component: Documents },
        { path: 'categories', component: Categories },
        { path: 'users', component: UsersManagement },
        { path: 'roles', component: Roles }
      ],
      beforeEnter: (to, from, next) => {
        const isLoggedIn = !!localStorage.getItem('token');
        if (isLoggedIn) {
          next();
        } else {
          next({ path: '/login' });
        }
      }
    },
    {
      path: '/',
      redirect: '/dashboard'
    },

  ]
})

export default router
