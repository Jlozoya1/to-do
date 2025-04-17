<template>
  <div>
    <a-layout style="min-height: 100vh">
      <a-layout-sider v-model:collapsed="collapsed" collapsible>
        <div class="logo" >
          <img :src="logo" alt="logo" style="max-height: 64px;">
        </div>
        <a-menu v-model:selectedKeys="selectedKeys" theme="dark" mode="inline">
          <!-- <router-link :to="{name: 'asd'}">Dashboard</router-link> -->

          <a-menu-item key="1" @click="changeTitle('Dashboard')">
            <router-link :to="{name: 'dashboardCharts'}" @click.prevent>
              <div class="center-items">
                <LineChartOutlined />
                <span>Dashboard</span>
              </div>
            </router-link>
          </a-menu-item>
          <a-menu-item key="2" @click="changeTitle('New Tasks')">
            <router-link :to="{name: 'tasks'}" @click.prevent>
              <div class="center-items">
                <CarryOutOutlined />
                <span>New Tasks</span>
              </div>
            </router-link>
          </a-menu-item>
          <!-- <a-sub-menu key="sub1">
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
          </a-sub-menu> -->
          <a-menu-item key="9" @click="changeTitle('Settings')">
            <router-link :to="{name: 'settingsIndex'}" @click.prevent>
              <div class="center-items">
                <SettingOutlined/>
                <span>Settings</span>
              </div>
            </router-link>
          </a-menu-item>
        </a-menu>
      </a-layout-sider>
    <a-layout>
      <nav-bar :title="title"/>
      <router-view/>
    </a-layout>
  </a-layout>
  </div>
</template>

<script lang="ts" setup>
  import {
    CarryOutOutlined,
    UserOutlined,
    TeamOutlined,
    SettingOutlined,
    LineChartOutlined,
  } from '@ant-design/icons-vue';

  import logo from '@/assets/images/logo2.png';
  import { reactive, ref } from 'vue';
  import navBar from './navBar.vue';

  const collapsed = ref<boolean>(false);
  const selectedKeys = ref<string[]>(['1']);
  const title = ref<string>('Dashboard');

  function changeTitle(newTitle: string) {
    title.value = newTitle
  };
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
  .logo{
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .center-items{
    display: flex;
    align-items: center;
  }
</style>
