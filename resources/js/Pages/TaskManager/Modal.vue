<template>
  <div>
    <button
        @click="showModal = true"
        class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
      Details
    </button>

    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50">
      <div class="bg-white rounded-lg p-8">
        <div class="flex justify-between items-center mb-4">
          <h1 class="text-xl font-bold">Details task</h1>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <!-- Task Name Field -->
        <div class="mb-4">
          <label for="taskName" class="block text-gray-700 font-bold mb-2">Task Name:</label>
          <p>{{task.name}}</p>
        </div>
        <!-- Description Field -->
        <div class="mb-4">
          <label for="description" class="block text-gray-700 font-bold mb-2">Description:</label>
          <p>{{task.description}}</p>
        </div>
        <!-- Status Field -->
        <div class="mb-4">
          <label for="status" class="block text-gray-700 font-bold mb-2">Status:</label>
          <p>{{ taskTranslated(task.status) }}</p>
        </div>
        <!-- Deadline Field -->
        <div class="mb-4">
          <label for="deadline" class="block text-gray-700 font-bold mb-2">Deadline:</label>
          <p>{{ formatDate(task.created_at) }}</p>
        </div>
        <!-- Priority Field -->
        <div class="mb-4">
          <label for="priority" class="block text-gray-700 font-bold mb-2">Priority:</label>
          <p>{{ task.priority }}</p>
        </div>
        <!-- Submit Button -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showModal: false
    };
  },
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  methods: {
    closeModal() {
      this.showModal = false;
    },
    submitTask(task) {
      this.$emit('update', task);
      this.closeModal();
    },
    formatDate(date) {
      const options = { timeZone: 'UTC', year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' };
      return new Date(date).toLocaleString('en-US', options);
    },
    taskTranslated(status) {
      if (status === 'IN_PROGRESS') {
        return 'IN PROGRESS'
      }
      return status;
    },
  }
};
</script>