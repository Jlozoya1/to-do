<template>
  <div>
    <a-layout style="min-height: 100vh">
      <a-layout-sider v-model:collapsed="collapsed" collapsible>
        <div class="logo" />
        <a-menu v-model:selectedKeys="selectedKeys" theme="dark" mode="inline">
          <!-- <router-link :to="{name: 'asd'}">Dashboard</router-link> -->

          <a-menu-item key="1">
            <router-link :to="{name: 'dashboardCharts'}">
              <pie-chart-outlined />
              <span>Dashboard</span>
            </router-link>
          </a-menu-item>
          <a-menu-item key="2">
            <router-link :to="{name: 'tasks'}">
              <desktop-outlined />
              <span>New Tasks</span>
            </router-link>
          </a-menu-item>
          <a-sub-menu key="sub1">
            <template #title>
              <span>
                <user-outlined />
                <span>User</span>
              </span>
            </template>
            <a-menu-item key="3">Tom</a-menu-item>
            <a-menu-item key="4">Bill</a-menu-item>
            <a-menu-item key="5">Alex</a-menu-item>
          </a-sub-menu>
          <a-sub-menu key="sub2">
            <template #title>
              <span>
                <team-outlined />
                <span>Team</span>
              </span>
            </template>
            <a-menu-item key="6">Team 1</a-menu-item>
            <a-menu-item key="8">Team 2</a-menu-item>
          </a-sub-menu>
          <a-menu-item key="9">
            <router-link :to="{name: 'settingsIndex'}">
              <file-outlined />
              <span>Settings</span>
            </router-link>
          </a-menu-item>
        </a-menu>
      </a-layout-sider>
    <a-layout>
      <router-view/>
    </a-layout>
  </a-layout>
  </div>
</template>

<script lang="ts" setup>
  import {
    PieChartOutlined,
    DesktopOutlined,
    UserOutlined,
    TeamOutlined,
    FileOutlined,
  } from '@ant-design/icons-vue';
  import { ref } from 'vue';

  const collapsed = ref<boolean>(false);
  const selectedKeys = ref<string[]>(['1']);

  let menu = [
    {
      type: 'menu',
      key: 48,
      routeName: "dashboardasd",
      isSelected(){
        this.$router.push({name: 'asd'});
      }
      // allowAccess: "insurance.profile",
      // name: "DASHBOARD",
      // icon(){
      //   return Vue.prototype.$_h(
      //     'ProfileOutlined',
      //   );
      // },
      // isSelected(){
      //   return true;
      // }
    },
  ];
  function gonme(){
    this.$router.push({name: 'asd'});
  }
</script>

<style scoped>
  #components-layout-demo-side .logo {
    height: 32px;
    margin: 16px;
    background: rgba(255, 255, 255, 0.3);
  }

  .site-layout .site-layout-background {
    background: #fff;
  }
  [data-theme='dark'] .site-layout .site-layout-background {
    background: #141414;
  }
</style>
