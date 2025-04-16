import { createMemoryHistory, createRouter } from 'vue-router'
import tasksLayout from '../spa/pages/tasks/layout.vue'
import tasksIndex from '../spa/pages/tasks/index.vue';
import settingsIndex from '../spa/pages/settings/index.vue';
import settingsLayout from '../spa/pages/settings/layout.vue';
import dashboardCharts from '../spa/pages/dashboardCharts/index.vue';

const routes = [
  {
    path: '/',
    name: 'default',
    component: dashboardCharts
  },
  {
    path: '/tasks',
    name: 'tasks',
    component: tasksIndex
  },
  // {
  //   path: '/dashboard',
  //   name: 'dashboard',
  //   component: dashboardLayout,
  //   children: [
  //   {
  //       path: '',
  //       name: 'dashboardIndex',
  //       component: dashboardIndex
  //   },
  //   ]
  // },
  {
    path: '/settings',
    name: 'settingsIndex',
    component: settingsIndex
  },
  {
    path: '/dashboardCharts',
    name: 'dashboardCharts',
    component: dashboardCharts
  },
];

const router = createRouter({
  history: createMemoryHistory(),
  routes
});

export default router;
