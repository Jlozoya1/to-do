import {  createRouter, createWebHistory } from 'vue-router'
import tasksLayout from '../spa/pages/tasks/layout.vue'
import tasksIndex from '../spa/pages/tasks/index.vue';
import settingsIndex from '../spa/pages/settings/index.vue';
import settingsLayout from '../spa/pages/settings/layout.vue';
import dashboardCharts from '../spa/pages/dashboardCharts/index.vue';
import defaultLayout from '../spa/pages/default/layout.vue';
import loginLayout from '../spa/pages/login/layout.vue';
import loginIndex from '../spa/pages/login/index.vue';
import registerLayout from '../spa/pages/register/layout.vue';
import registerIndex from '../spa/pages/register/index.vue';
import home from '../spa/pages/home/index.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: home,
  },
  {
    path: '/login',
    name: 'loginLayout',
    component: loginLayout,
    children:[
        {
            path: '',
            name: 'loginIndex',
            component: loginIndex
        },
    ]
  },
  {
    path: '/register',
    name: 'register',
    component: registerLayout,
    children:[
        {
            path: '',
            name: 'registerIndex',
            component: registerIndex
        },
    ]
  },
  {
    path: '/dashboard',
    name: 'default',
    component: defaultLayout,
    children: [
      {
        path: '',
        name: 'dashboardCharts',
        component: dashboardCharts
      },
      {
        path: 'tasks',
        name: 'tasks',
        component: tasksIndex
      },
      {
        path: 'settings',
        name: 'settingsIndex',
        component: settingsIndex
      },
    ]
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
