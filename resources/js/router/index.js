import { createRouter, createWebHistory } from 'vue-router';
import {jwtDecode} from 'jwt-decode';

import Home from '../components/pages/HomePage.vue';
import HistoryPage from '../components/pages/user/HistoryPage.vue';
import AddClothing from '../components/pages/admin/AddClothing.vue';
import AddCategory from '../components/pages/admin/AddCategory.vue';
import NotFound from '../components/pages/NotFound.vue';
import LoginPage from '../components/pages/LoginPage.vue';
import AdminDashboard from '../components/pages/admin/AdminDashboard.vue';
import AllTransactions from '../components/pages/admin/AllTransactions.vue';

const routes = [
  {
    path: '/',
    component: Home,
    name: 'Home',
  },
  {
    path: '/user/HistoryPage',
    component: HistoryPage,
    name: 'HistoryPage',
    meta: { requiresRole: ['PENGGUNA', 'ADMIN'] },
  },
  {
    path: '/admin/add-clothing',
    component: AddClothing,
    name: 'AddClothing',
    meta: { requiresRole: ['ADMIN'] },
  },
  {
    path: '/admin/add-category',
    component: AddCategory,
    name: 'AddCategory',
    meta: { requiresRole: ['ADMIN'] },
  },
  {
    path: '/admin/all-transactions',
    component: AllTransactions,
    name: 'AllTransactions',
    meta: { requiresRole: ['ADMIN'] },
  },
  {
    path: '/admin',
    component: AdminDashboard,
    name: 'admin',
    meta: { requiresRole: ['ADMIN'] },
  },
  {
    path: '/login',
    component: LoginPage,
    name: 'login',
  },
  {
    path: '/:pathMatch(.*)*',
    component: NotFound,
    name: 'NotFound',
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  let role = null;

  if (token) {
    try {
      const decodedToken = jwtDecode(token);
      role = decodedToken.role;
      console.log('Role:', role);
    } catch (error) {
      console.error('Invalid token:', error);
      return next({ name: 'login' });
    }
  }

  const isLoggedIn = !!role;

  if (!isLoggedIn && to.name !== 'login') {
    return next({ name: 'login' });
  }

  if (to.path === '/' && isLoggedIn) {
    if (role === 'ADMIN' && to.name !== 'admin') {
      return next({ name: 'admin' });
    } else if (role === 'PENGGUNA' && to.name !== 'Home') {
      return next({ name: 'Home' });
    }
  }

  if (to.matched.some(record => record.meta.requiresRole)) {
    const requiredRole = to.meta.requiresRole;
    if (isLoggedIn && requiredRole.includes(role)) {
      next(); // Allow access if role matches
    } else {
      next({ name: 'NotFound' });
    }
  } else {
    next(); // Allow navigation if no role is required
  }
});

export default router;