<template>
  <div class="flex">
    <div class="w-full flex items-start justify-left bg-background-primary font-sans vl-parent" ref="formContainer">
      <loading v-model:active="isLoading" :is-full-page="fullPage" />
      <div class="bg-white rounded shadow p-6 m-4 w-full">
        <div class="mb-4">
          <h1 class="text-grey-darkest text-xl font-bold">Create your task</h1>
          <div class="flex mt-4">
            <input :class="errorMessage ? 'border-red-300' : ''" class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker"
              placeholder="Add task name" v-model="newTask.name" />
            <input :class="errorMessage ? 'border-red-300' : ''" class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker"
              placeholder="Add description" v-model="newTask.description" />
            <button @click="createTask"
                    :disabled="!newTask.name"
              class="flex-no-shrink px-4 border-2 rounded text-teal hover:text-gray-500 text-green border-green font-bold">
              +
            </button>
          </div>
          <div v-if="errorMessage" class="flex w-64 items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 mt-4" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
              <span class="font-medium">{{errorMessage}}</span>.
            </div>
          </div>

        </div>

        <div>
          <h1 class="text-grey-darkest text-xl font-bold mt-12 mb-4">Mainbox</h1>

          <div v-for="task in taskList" :key="task.id" class="flex mb-4 items-center w-full rounded">
            <div class="flex w-6/12 rounded">
              <input :disabled="task.is_finish" @keyup.enter="updateTask(task)" v-model="task.name"
                :class="task.is_finish ? 'line-through text-green' : 'border-green-700'" class="w-10/12 mr-2 text-grey-darkest p-2 columns-6	rounded" />
            </div>
            <div class="flex w-4/12 rounded items-center justify-center">
               <span :class="task.is_finish ? 'bg-gray-100 dark:bg-gray-900 dark:text-gray-300' : 'bg-green-100 text-white-800 dark:bg-green-900 dark:text-gray-300'"
                        class="w-6/12   inline-flex items-center justify-center text-xs font-medium px-2.5 py-0.5 rounded-full">
                  <span class="h-2 me-1 bg-green-500 rounded-full py-4"></span>
                {{ taskTranslated(task.status) }}
                </span>
            </div>

            <div class="flex w-3/12">
              <button
                  v-if="isPending(task.status)" @click="updateTask(task, true)"
                   class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                Start
              </button>
              <button
                  v-if="!task.is_finish" @click="finishTask(task)"
                  class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                Finish
              </button>
              <Modal :task="task" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import HandleUserData from '@/mixins/HandleUserData';
import Modal from "./Modal.vue";

export default {
  name: "TaskListView",
  components: {
    Modal,
    Loading,
  },
  mixins: [HandleUserData],
  data() {
    return {
      isLoading: false,
      fullPage: false,
      newTask: {
        name: ''
      },
      taskList: [],
      accessToken: '',
      errorMessage: null
    };
  },
  mounted() {
    this.getUserTasks();
  },
  methods: {
    setTaskComplete(id) {
      this.taskList.filter((task) => {
        if (task === id) {
          task.isComplete = !task.isComplete;
        }
      });
    },

    async createTask() {
      this.isLoading = true;
      await axios.post('api/v1/tasks', this.newTask).then(response => {
        if (response.status === 202 && response.data.id) {
          this.errorMessage = null
          let taskCreated = {
            id: response.data.id,
            name: response.data.name,
            isComplete: false
          }
          this.taskList.unshift(taskCreated)
        } else {
          this.getUserTasks();
        }
      }).catch(error => {
        this.errorMessage = error.response.data.errors.name[0];
      })
      this.isLoading = false;
    },

    async updateTask(taskToUpdate, updateStatus = false) {
      this.isLoading = true;
      try {
        const response = await axios.put('api/v1/tasks',
          {
            'taskId': taskToUpdate.id,
            'name': taskToUpdate?.name,
            'status': updateStatus
          })
        if (response.status === 200) {
          const index = this.taskList.findIndex((task) => task.id === taskToUpdate.id);
          if (index > -1) {
            this.taskList[index].name = taskToUpdate.name;
          }

        }
      } catch (error) {
        console.error("An error occurred:", error);
      } finally {
        await this.getUserTasks();
        this.isLoading = false;
      }
    },

    async finishTask(taskToUpdate) {
      this.isLoading = true;
      try {
        const response = await axios.put('api/v1/tasks/finishTask',
          {
            'taskId': taskToUpdate.id,
          })
      } catch (error) {
        console.error("An error occurred:", error);
      } finally {
        await this.getUserTasks();
        this.isLoading = false;
      }
    },

    async removeTask(taskId) {
      this.isLoading = true;

      await axios.delete(`api/v1/tasks/${taskId}`).then(response => {
        if (response.status === 204) {
          const task = this.taskList.findIndex((task) => task.id === taskId);
          if (task > -1) {
            this.taskList.splice(task, 1);
          }
        }
      }).catch(error => {
        console.error("An error occurred:", error);

      })

      this.isLoading = false;
    },
    taskTranslated(status) {
      if (status === 'IN_PROGRESS') {
        return 'IN PROGRESS'
      }
      return status;
    },
    isPending(status) {
      return status === 'PENDING';
    },
  },
  watch: {
    taskList() {
      }
  }
};
</script>

<style scoped>

  .in_progress {}
  .pending {}
  .completed {

  }

</style>