import { createRouter, createWebHistory } from 'vue-router';
import {jwtDecode} from 'jwt-decode';

import Home from '../components/pages/HomePage.vue';
import HistoryPage from '../components/pages/user/HistoryPage.vue';
import AddClothing from '../components/pages/admin/AddClothing.vue';
import AddCategory from '../components/pages/admin/AddCategory.vue';
import AllCategories from '../components/pages/admin/AllCategories.vue';
import NotFound from '../components/pages/NotFound.vue';
import LoginPage from '../components/pages/LoginPage.vue';
import RegisterPage from '../components/pages/RegisterPage.vue';
import AdminDashboard from '../components/pages/admin/AdminDashboard.vue';
import AllTransactions from '../components/pages/admin/AllTransactions.vue';
import AllClothing from '../components/pages/admin/AllClothing.vue';
import AllUsers from '../components/pages/admin/AllUsers.vue';
import UserProfileSettings from '../components/pages/UserProfileSettings.vue';
import PasswordResetPage from '../components/pages/PasswordResetPage.vue';
import AccountSettingsPage from '../components/pages/AccountSettingsPage.vue';
import RegisterAdminPage from '../components/pages/admin/RegisterAdminPage.vue';

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
    path: '/admin/all-clothing',
    component: AllClothing,
    name: 'AllClothing',
    meta: { requiresRole: ['ADMIN'] },
  },
  {
    path: '/admin/add-category',
    component: AddCategory,
    name: 'AddCategory',
    meta: { requiresRole: ['ADMIN'] },
  },
  {
    path: '/admin/all-categories',
    component: AllCategories,
    name: 'AllCategories',
    meta: { requiresRole: ['ADMIN'] },
  },
  {
    path: '/admin/all-transactions',
    component: AllTransactions,
    name: 'AllTransactions',
    meta: { requiresRole: ['ADMIN'] },
  },
  {
    path: '/admin/all-users',
    component: AllUsers,
    name: 'AllUsers',
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
    path: '/register',
    component: RegisterPage,
    name: 'register',
  },
  {
    path: '/settings/update-profile',
    component: UserProfileSettings,
    name: 'UserProfileSettings',
    meta: { requiresRole: ['PENGGUNA', 'ADMIN'] },
  },
  {
    path: '/settings/reset-password',
    component: PasswordResetPage,
    name: 'PasswordResetPage',
    meta: { requiresRole: ['PENGGUNA', 'ADMIN'] },
  },
  {
    path: '/settings',
    component: AccountSettingsPage,
    name: 'AccountSettingsPage',
    meta: { requiresRole: ['PENGGUNA', 'ADMIN'] },
  },
  {
    path: '/admin/register',
    component: RegisterAdminPage,
    name: 'RegisterAdminPage',
    meta: { requiresRole: ['ADMIN'] },
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

  if (!isLoggedIn && to.name !== 'login' && to.name !== 'register') {
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


// router.beforeEach((to, from, next) => {
//   const token = localStorage.getItem('token');
//   let role = null;

//   if (token) {
//     try {
//       const decodedToken = jwtDecode(token);
//       role = decodedToken.role;
//       console.log('Role:', role);
//     } catch (error) {
//       console.error('Invalid token:', error);
//       return next({ name: 'login' });
//     }
//   }

//   const isLoggedIn = !!role;

//   if (!isLoggedIn && to.name !== 'login') {
//     return next({ name: 'login' });
//   }

//   if (to.path === '/' && isLoggedIn) {
//     if (role === 'ADMIN' && to.name !== 'admin') {
//       return next({ name: 'admin' });
//     } else if (role === 'PENGGUNA' && to.name !== 'Home') {
//       return next({ name: 'Home' });
//     }
//   }

//   if (to.matched.some(record => record.meta.requiresRole)) {
//     const requiredRole = to.meta.requiresRole;
//     if (isLoggedIn && requiredRole.includes(role)) {
//       next(); // Allow access if role matches
//     } else {
//       next({ name: 'NotFound' });
//     }
//   } else {
//     next(); // Allow navigation if no role is required
//   }
// });

export default router;