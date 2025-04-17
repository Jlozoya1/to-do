<template>
  <div class="container">
        <div class="form-container">
            <h2 class="text-center">Agregar Nueva Tarea</h2>
            <div id="task-form" class="mt-3">
                <div class="input-group">
                    <input v-model="newTaskName" type="text" id="task-name" class="form-control" placeholder="Nombre de la tarea" required>
                    <button @click="addTask" class="btn btn-primary">Añadir Tarea</button>
                </div>
              </div>
        </div>

        <h2 class="mt-5">Tus Tareas</h2>
        <table class="table table-dark table-hover mt-3">
            <thead>
                <tr>
                    <th>Tarea</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="task-list">
              <tr v-for="(task, index) in dataItems" :key="index">
                <td>
                  <input type="text" class="form-control" v-model="task.name" @input="updateTaskAll(task, 'update')"/>
                </td>

                <td>
                  <select class="form-control" v-model="task.status" @change="updateTaskAll(task, 'update')">
                    <option v-for="status in statuses" :key="status" :value="status">
                      {{ status }}
                    </option>
                  </select>
                </td>

                <td class="d-flex">
                  <!-- <button
                    class="btn btn-success me-2"
                    @click="updateTaskAll(task, 'update')"
                  >
                    Actualizar
                  </button> -->
                  <button
                    class="btn btn-danger"
                    @click="updateTaskAll(task, 'delete')"
                  >
                    Eliminar
                  </button>
                </td>

              </tr>
            </tbody>
        </table>
    </div>
  </template>

  <script>
    export default {
      data(){
        return {
          dataItems: [],
          statuses: ['Por Hacer', 'Pendiente', 'Completado'],
          newTaskName: '',
        }
      },
      methods: {
        loadTasksFromDatabase(){
          this.$axios.get('/tasksAPI')
            .then((response)=> {
              let items = response.data;
              console.log(response.data);
              this.dataItems.push(...items);
            })
            .catch(error => console.error ('Error from DB ', error));
        },
        addTask(){
          if(this.newTaskName != ''){
            let newTask = {
              name: this.newTaskName,
              status: 'Por Hacer',
            };

            this.sendAddTaskToServer(newTask);
          }
        },
        sendAddTaskToServer(task){
          let queryParams = {
            name: task.name,
            status: task.status
          };

          this.$axios.post('tasks', queryParams)
          .then(() => {
            // console.log('Tarea Guardada');
            this.dataItems = [];
            this.loadTasksFromDatabase();

          })
          .catch((error) => {
            console.error('Error Saving Task', error);
          });
        },
        updateTaskAll(task, action){
          let queryParams = {
            id: task.id,
            name: task.name,
            status: task.status,
            user_id: task.user_id,
            action: action
          };

          this.$axios.post('taskUpdate', queryParams)
          .then(() => {
            // console.log('Task Updated');
          })
          .catch((error) => {
            console.error('An error has Ocurred', error);
          });

          if (action === 'delete') {
            this.dataItems = this.dataItems.filter(t => t.id !== task.id);
          }
        },

      },
      computed: {

      },
      mounted() {
        this.loadTasksFromDatabase();
      }

    }
  </script>
