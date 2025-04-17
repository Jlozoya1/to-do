<template>
  <div>
    <a-page-header
      :title="title"
    >
    <template #extra>
      <!-- <a-button key="1" type="primary">Primary</a-button> -->
       <a-dropdown :trigger="['click']">
        <a class="ant-dropdown-link" @click.prevent>
          <BarsOutlined style="color: black; font-size: 30px;"/>
        </a>
        <template #overlay>
            <a-menu>
                <a-menu-item key="0" @click="logout">
                    <span>Sign Out</span>
                </a-menu-item>
            </a-menu>
        </template>
       </a-dropdown>
    </template>
    </a-page-header>
  </div>
</template>

<script setup>
  import { ref } from 'vue';
  import { BarsOutlined } from '@ant-design/icons-vue';
  import axios from 'axios';

  defineProps({
    title: String,
  })

  function logout(){
    axios.post('/logout')
    .then(() => {
        window.location.href = '/login';
    })
    .catch((error) => {
        console.error('Error trying to Sign Out', error);
    })
  }

</script>
