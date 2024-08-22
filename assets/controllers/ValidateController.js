// assets/controllers/validate_controller.js

import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["form"];

  validate(event) {
    if (this.formTarget.checkValidity() === false) {
      event.preventDefault();
      alert("Please fill out all required fields.");
    }
  }
}
