import { createRouter, createWebHistory } from 'vue-router'
import ClientView from '../views/ClientView.vue'
import apiRequest from '@/axios.js';

const requireAuth = (to, from, next) => {
  apiRequest.get('/access', {
    withCredentials: true,
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  }).then(response => {
    if(response.data.success) {
      next();
    } else {
      next('/admin/login');
    }
  })
};

const routes = [
  {
    path: '/',
    name: 'client',
    component: ClientView,
    redirect: '/index',
    children: [
      {
        path: 'index',
        name: 'index-client',
        component: () => import('../components/client/IndexPage.vue'),
      },
      {
        path: 'hall/:sessionId',
        name: 'hall-client',
        component: () => import('../components/client/HallPage.vue'),
        props: true
      },
      {
        path: 'payment/:sessionId/:seatsId',
        name: 'payment-client',
        component: () => import('../components/client/PaymentPage.vue'),
        props: true
      },
    ],
  },
  {
    path: '/admin',
    name: 'admin',
    redirect: '/admin/login',
    component: () => import('../views/AdminView.vue'),
    children: [
      {
        path: 'login',
        name: 'login-admin',
        component: () => import('../components/admin/LoginPage.vue'),
      },
      {
        path: 'redactor',
        name: 'redactor-admin',
        component: () => import('../components/admin/RedactorPage.vue'),
        meta: { requiresAuth: true },
        beforeEnter: requireAuth
      },
    ]
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
