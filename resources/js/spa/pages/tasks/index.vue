<template>
  <div class="container">
        <!-- <div class="form-container">
            <h2 class="text-center">Agregar Nueva Tarea</h2>
            <div id="task-form" class="mt-3">
                <div class="input-group">
                    <input v-model="newTaskName" type="text" id="task-name" class="form-control" placeholder="Nombre de la tarea" required>
                    <button @click="addTask" class="btn btn-primary">Añadir Tarea</button>
                </div>
              </div>
        </div> -->

        <div style="max-width: 600px; margin: 0 auto; padding: 20px; ">
            <h2 style="text-align: center;">Got Something to Do?</h2>
            <div id="task-form" style="margin-top: 2rem;">
                <div style="display: flex;">
                    <input v-model="newTaskName"
                        type="text"
                        id="task-name"
                        placeholder="Task Name"
                        required
                        style="flex: 1; padding: 0.5rem 0.5rem 0.5rem 1rem; border: 1px solid #ccc; border-radius: 10px 0 0 10px;">
                    <button @click="addTask"
                            style="padding: 0.5rem 1rem; background-color: #04284a; color: white; border: none; border-radius: 0 10px 10px 0; cursor: pointer;">
                        Add New Task
                    </button>
                </div>
            </div>
        </div>

        <h2 class="mt-5">All Your Tasks</h2>

        <a-table :dataSource="dataItems" :columns="columns" :loading="loading">
          <template #bodyCell="{ column, text, record, index }">

            <template v-if="column.dataIndex === 'name'">
              <a-input v-model:value="record.name" @input="onInputChange(record, 'update')">
                <template #prefix>
                  <EditFilled />
                </template>
              </a-input>
            </template>

            <template v-else-if="column.dataIndex === 'status'">
              <a-select
                v-model:value="record.status"
                style="width: 100%"
                @change="updateTaskAll(record, 'update')"
              >
                <a-select-option
                  v-for="status in statuses"
                  :key="status"
                  :value="status"
                  :disabled="isOptionSelected(status, record)"
                >
                {{ status }}
                </a-select-option>
              </a-select>
            </template>

            <template v-else-if="column.dataIndex === 'action'">
              <a-popconfirm
                v-if="dataItems.length"
                title="Sure to delete?"
                @confirm="updateTaskAll(task, 'delete')"
              >
              <!-- <button class="btn btn-danger">
                Delete
              </button> -->
              <a>
                <a-tag :color="'volcano'">
                  Delete
                </a-tag>
              </a>
              </a-popconfirm>
            </template>

          </template>
        </a-table>
    </div>
  </template>

<script>
  import { message } from 'ant-design-vue';
  import { EditFilled } from '@ant-design/icons-vue';
  import debounce from 'lodash/debounce';

    export default {
      data(){
        return {
          dataItems: [],
          statuses: ['Por Hacer', 'Pendiente', 'Completado'],
          newTaskName: '',
          loading: false,
          columns: [
            {
              title: 'Task',
              dataIndex: 'name',
              key: 'task',
            },
            {
              title: 'Status',
              dataIndex: 'status',
              key: 'status',
              width: '30%',
            },
            {
              title: 'Action',
              dataIndex: 'action',
              width: '10%',
              align: 'center'
            },
          ],
        }
      },
      components: {
        EditFilled
      },
      methods: {
        loadTasksFromDatabase(){
          this.loading = true;

          this.$axios.get('/tasksAPI')
            .then((response)=> {
              let items = response.data;
              this.dataItems.push(...items);
              this.loading = false;
            })
            .catch((error) => {
              this.loading = false;
              message.error ('Error from DB ', error);
            })
        },
        addTask(){
          if(this.newTaskName == ''){
            message.error('Please Insert Name Task');
            return;
          }

          let newTask = {
            name: this.newTaskName,
            status: 'Por Hacer',
          };

          this.sendAddTaskToServer(newTask);
        },
        sendAddTaskToServer(task){
          let queryParams = {
            name: task.name,
            status: task.status
          };

          this.$axios.post('/tasks', queryParams)
          .then(() => {
            this.dataItems = [];
            this.loadTasksFromDatabase();
            message.success('Task Succesfully Saved');
          })
          .catch((error) => {
            message.error('Error Saving Task', error);
          })
          .finally(() => {
            this.newTaskName = '';
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

          this.$axios.post('/taskUpdate', queryParams)
          .then(() => {
            action == 'delete'
            ? message.success('Task Succesfully Deleted')
            : message.success('Task Succesfully Updated');
          })
          .catch((error) => {
            message.error('An error has Ocurred', error);
          });

          if (action === 'delete') {
            this.dataItems = this.dataItems.filter(t => t.id !== task.id);
          }
        },
        isOptionSelected(status, currentRecord){
          return status == currentRecord.status;
        },
        onInputChange(task, action) {
          this.debouncedUpdateTask(task, action);
        }

      },
      computed: {

      },
      created(){
        this.debouncedUpdateTask = debounce((task, action) => {
          this.updateTaskAll(task, action);
        }, 3000);
      },
      mounted() {
        this.loadTasksFromDatabase();
      }

    }
</script>
