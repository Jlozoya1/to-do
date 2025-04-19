<template>
  <div>
    <a-page-header>
    <template #extra>
       <span class="right-corner" > {{ title }} </span>
    </template>
    </a-page-header>
  </div>
</template>

<script setup>
  import { ref } from 'vue';
  import { BarsOutlined } from '@ant-design/icons-vue';
  import { message } from 'ant-design-vue';
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
        message.error('Error trying to Sign Out');
        // console.error('Error trying to Sign Out', error);
    })
  }

</script>

<style>
    .right-corner{
        display: flex;
        align-items: center;
        overflow: hidden;
        margin-right: 12px;
        margin-bottom: 0;
        color: rgba(0, 0, 0, 0.85);
        font-weight: 600;
        font-size: 20px;
        line-height: 32px;
    }
</style>
