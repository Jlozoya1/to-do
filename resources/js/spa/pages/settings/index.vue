<template>
    <a-card title="Configuración de Perfil" style="width: 900px; margin: auto;">
      <template #extra v-if="!editando"><a @click="editando = true">Editar</a></template>
      <a-form layout="vertical">
        <!-- Nombre -->
        <a-form-item label="Nombre completo">
          <a-input v-model:value="form.nombre" :disabled="!editando" />
        </a-form-item>

        <!-- Email -->
        <a-form-item label="Correo electrónico">
          <a-input v-model:value="form.email" :disabled="!editando" />
        </a-form-item>

        <!-- Contraseña -->
        <a-form-item label="Nueva contraseña">
          <a-input-password v-model:value="form.password" :disabled="!editando" placeholder="Cambiar contraseña" />
        </a-form-item>

        <!-- Botones -->
        <div v-if="editando" style="text-align: right">
          <a-button @click="cancelar" style="margin-right: 8px">Cancelar</a-button>
          <a-button type="primary" @click="guardar">Guardar</a-button>
        </div>
      </a-form>
    </a-card>
  </template>

  <script setup>
    import { ref } from 'vue'
    import { message } from 'ant-design-vue'

    const form = ref({
      nombre: 'Juan Pérez',
      email: 'juan@email.com',
      password: ''
    })

    const original = ref({ ...form.value })
    const editando = ref(false)

    // function editButton() {
    //   return <a @click="editando.value = true">Editar</a>
    // }

    function cancelar() {
      form.value = { ...original.value }
      editando.value = false
    }

    function guardar() {
      original.value = { ...form.value }
      message.success('Cambios guardados')
      editando.value = false

      // Aquí podrías llamar a una API:
      // await axios.put('/api/profile', form.value)
    }
  </script>
