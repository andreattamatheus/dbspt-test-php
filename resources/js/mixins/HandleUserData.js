export default {
  data() {
    return {
      isLoading: false,
    };
  },
  methods: {
    async getUserTasks() {
      console.log("getUserTasks");
      this.isLoading = true;
      try {
        await axios.get("api/v1/tasks")
          .then((response) => {
            this.taskList = response.data;
            console.log(this.taskList)

          })
          .catch((error) => {
            console.error("An error occurred:", error);
          });
      } catch (error) {
        console.error("An error occurred:", error);
      }
      this.isLoading = false;
    },
  },
};
