import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["username"];

  connect() {
    this.usernameTarget.focus();
  }
}
