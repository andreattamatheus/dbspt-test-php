export default {
  methods:{
    validateForm() {
      let isValid = true;
      for (let key in this.form) {
          if (!this.form[key].trim()) {
              this.validationErrors[key] = `${key.charAt(0).toUpperCase() + key.slice(1)} is required.`;
              isValid = false;
          } else {
              this.validationErrors[key] = null;
          }
      }
      return isValid;
    },

    convertErrorFromArray(error) {
      const transformedErrors = {};
      for (let field in error.response.data.errors) {
          transformedErrors[field] = error.response.data.errors[field][0];
      }
      return transformedErrors;
    }
  }

}
