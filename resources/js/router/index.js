import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/pages/HomePage.vue';
import CheckClothing from '../components/pages/user/CheckClothing.vue';
import AddClothing from '../components/pages/admin/AddClothing.vue';
import NotFound from '../components/pages/NotFound.vue';

const routes = [
    {
        path: '/',
        component: Home,
        name: 'Home', 
    },
    {
        path: '/user/CheckClothing',
        component: CheckClothing,
        name: 'CheckClothing', 
    },
    {
        path: '/admin/AddClothing',
        component: AddClothing,
        name: 'AddClothing', 
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFound,
        name: 'NotFound', 
    },
    
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;