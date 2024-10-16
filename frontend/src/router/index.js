import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/RegisterView.vue'
import LoginView from '../views/LoginView.vue'
import AuthService from '../services/AuthService'
import Test from '../views/Test.vue'


import DashboardLayout from '../layout/DashboardLayout.vue';
import Home from '../views/Dashboard/Home.vue';
import Profile from '../views/Dashboard/Profile.vue';
import Settings from '../views/Dashboard/Settings.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',

      component: () => import('../views/AboutView.vue')
    },

    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },

    {
      path: '/test',
      name: 'test',
      component: Test
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
        { path: 'profile', component: Profile },
        { path: 'settings', component: Settings }
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
  ]
})

export default router
