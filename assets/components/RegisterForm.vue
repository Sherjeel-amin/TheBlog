<template>
  <div class="registration-form">
    <h1>Register</h1>
    <form @submit.prevent="submitForm">
      <!-- Username Field -->
      <div>
        <label for="username">Username:</label>
        <input v-model="form.username" type="text" id="username" required>
      </div>

      <!-- Email Field -->
      <div>
        <label for="email">Email:</label>
        <input v-model="form.email" type="email" id="email" required>
      </div>

      <!-- Password Field -->
      <div>
        <label for="password">Password:</label>
        <input v-model="form.password" type="password" id="password" required>
      </div>

      <!-- Gender Field -->
      <div>
        <label for="gender">Gender:</label>
        <select v-model="form.gender" id="gender" required>
          <option disabled value="">Choose your gender</option>
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <!-- Bio Field -->
      <div>
        <label for="bio">Bio:</label>
        <textarea v-model="form.bio" id="bio" required></textarea>
      </div>

      <!-- Error Message -->
      <div v-if="error" class="error">{{ error }}</div>

      <!-- Submit Button -->
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

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

<style scoped>
.registration-form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>
