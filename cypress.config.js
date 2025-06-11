const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    baseUrl: "http://localhost:8000", // ou a porta que você usa no artisan serve
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});