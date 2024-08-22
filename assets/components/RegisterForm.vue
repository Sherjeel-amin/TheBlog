<template>
  <div class="registration-form">
    <h1>Register</h1>
    <form @submit.prevent="submitForm" data-controller="focus validate" data-action="validate#validate" data-validate-target="form">

      <div>
        <label for="username">Username:</label>
        <input v-model="form.username" type="text" id="username" required data-focus-target="username">
      </div>

      <div>
        <label for="email">Email:</label>
        <input v-model="form.email" type="email" id="email" required>
      </div>

      <div>
        <label for="password">Password:</label>
        <input v-model="form.password" type="password" id="password" required>
      </div>

      <div>
        <label for="gender">Gender:</label>
        <select v-model="form.gender" id="gender" required>
          <option disabled value="">Choose your gender</option>
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div>
        <label for="bio">Bio:</label>
        <textarea v-model="form.bio" id="bio" required></textarea>
      </div>

      <div v-if="error" class="error">{{ error }}</div>

      <button type="submit">Register</button>
      <p> Already have an account? <a href="/users/login">Login here</a></p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import '../styles/RegisterForm.css';

export default {
  data() {
    return {
      form: {
        username: '',
        email: '',
        password: '',
        gender: '',
        bio: ''
      },
      error: null,
    };
  },
  methods: {
    async submitForm() {
      try {
        const response = await axios.post('/api/register', this.form);

        if (response.data.success) {
          window.location.href = '/users/login';
        }
      } catch (error) {
        this.error = error.response.data.message || 'An error occurred during registration.';
      }
    }
  }
};
</script>
