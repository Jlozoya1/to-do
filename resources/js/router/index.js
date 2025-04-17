import {  createRouter, createWebHistory } from 'vue-router'
import tasksLayout from '../spa/pages/tasks/layout.vue'
import tasksIndex from '../spa/pages/tasks/index.vue';
import settingsIndex from '../spa/pages/settings/index.vue';
import settingsLayout from '../spa/pages/settings/layout.vue';
import dashboardCharts from '../spa/pages/dashboardCharts/index.vue';
import defaultLayout from '../spa/pages/default/layout.vue';
import home from '../spa/pages/home/index.vue';
const routes = [
  {
    path: '/',
    name: 'home',
    component: home,
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
