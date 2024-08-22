// Stimulus setup
import { Application } from "@hotwired/stimulus";
import FocusController from "./controllers/FocusController";
import ValidateController from "./controllers/ValidateController";

const application = Application.start();
application.register("focus", FocusController);
application.register("validate", ValidateController);

// Vue.js setup
import Vue from 'vue';
import RegisterForm from './components/RegisterForm.vue';

new Vue({
  render: h => h(RegisterForm),
}).$mount('#app');
