<template>
  <div class="login-container">
    <!-- Columna izquierda - Formulario de login -->
    <div class="form-column">
      <div class="form-wrapper">
        <div class="form-header">
          <h2>Welcome</h2>
          <p>We are Better than Jira</p>
        </div>

        <form @submit.prevent="handleLogin" class="login-form">
          <div class="form-fields">
            <div class="form-group">
              <label for="email">Email</label>
              <div class="input-wrapper">
                <div class="input-icon">
                  <mail-icon />
                </div>
                <input
                  id="email"
                  v-model="email"
                  type="email"
                  required
                  placeholder="example@email.com"
                />
              </div>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-wrapper">
                <div class="input-icon">
                  <lock-icon />
                </div>
                <input
                  id="password"
                  v-model="password"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  placeholder="••••••••"
                />
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="password-toggle"
                >
                  <eye-icon v-if="showPassword" />
                  <eye-off-icon v-else />
                </button>
              </div>
            </div>
          </div>

          <!-- <div class="form-options">
            <div class="remember-me">
              <input
                id="remember-me"
                v-model="rememberMe"
                type="checkbox"
              />
              <label for="remember-me">Recordarme</label>
            </div>

            <div class="forgot-password">
              <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
          </div> -->

          <div class="form-actions">
            <button
              type="submit"
              class="btn-primary"
              :disabled="loading"
            >
              <loader-icon v-if="loading" class="loader-icon" />
              {{ loading ? 'Logging In...' : 'Log In' }}
            </button>
          </div>
        </form>

        <!-- <div class="social-login">
          <div class="divider">
            <span>O continúa con</span>
          </div>

          <div class="social-buttons">
            <button type="button" class="btn-social">
              <google-icon />
              Google
            </button>
            <button type="button" class="btn-social">
              <facebook-icon />
              Facebook
            </button>
          </div>
        </div> -->

        <p class="signup-link">
          Create an Account
          <a href="/register">Here</a>
        </p>
      </div>
    </div>

    <!-- Columna derecha - Imagen -->
    <div class="image-column">
      <div class="image-wrapper">
        <!-- <img
          src="/placeholder.svg?height=600&width=800"
          alt="Login illustration"
        /> -->
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { message } from 'ant-design-vue'
import {
  Mail as MailIcon,
  Lock as LockIcon,
  Eye as EyeIcon,
  EyeOff as EyeOffIcon,
  Loader as LoaderIcon,
  Facebook as FacebookIcon,
  Mail as GoogleIcon
} from 'lucide-vue-next';

// Estado del formulario
const email = ref('');
const password = ref('');
const rememberMe = ref(false);
const showPassword = ref(false);
const loading = ref(false);

// Método para manejar el inicio de sesión
const handleLogin = async () => {
  loading.value = true;
  let queryParams = {
      email: email.value,
      password: password.value,
  }

  try {
    // Aquí iría la lógica de autenticación
    // console.log('Iniciando sesión con:', {
    //   email: email.value,
    //   password: password.value,
    //   rememberMe: rememberMe.value
    // });
    await axios.post('/login', queryParams);

    // Redirección después del login exitoso
    window.location.href = '/dashboard';
  } catch (error) {
    message.error('Please Try Again');
    console.error('Error al iniciar sesión:', error);
  } finally {
    loading.value = false;
    message.success('Logged In Successfully')
  }
};
</script>

<style>
:root {
  --color-primary: #9333ea;
  --color-primary-dark: #7e22ce;
  --color-gray-100: #f3f4f6;
  --color-gray-200: #e5e7eb;
  --color-gray-300: #d1d5db;
  --color-gray-400: #9ca3af;
  --color-gray-500: #6b7280;
  --color-gray-600: #4b5563;
  --color-gray-700: #374151;
  --color-gray-800: #1f2937;
  --color-gray-900: #111827;
  --color-white: #ffffff;
  --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --border-radius: 0.375rem;
  --spacing-1: 0.25rem;
  --spacing-2: 0.5rem;
  --spacing-3: 0.75rem;
  --spacing-4: 1rem;
  --spacing-6: 1.5rem;
  --spacing-8: 2rem;
  --spacing-10: 2.5rem;
  --spacing-12: 3rem;
  --font-sans: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: var(--font-sans);
  color: var(--color-gray-800);
  line-height: 1.5;
}

.login-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
}

.form-column {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: var(--spacing-6);
  flex: 1;
}

.form-wrapper {
  width: 100%;
  max-width: 400px;
  margin: 0 auto;
}

.form-header {
  text-align: center;
  margin-bottom: var(--spacing-8);
}

.form-header h2 {
  font-size: 1.875rem;
  font-weight: 700;
  margin-bottom: var(--spacing-2);
}

.form-header p {
  color: var(--color-gray-600);
  font-size: 0.875rem;
}

.login-form {
  margin-top: var(--spacing-8);
}

.form-fields {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-4);
  margin-bottom: var(--spacing-6);
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: var(--spacing-1);
  color: var(--color-gray-700);
}

.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon {
  position: absolute;
  left: var(--spacing-3);
  color: var(--color-gray-400);
  display: flex;
  align-items: center;
  justify-content: center;
}

.input-icon svg {
  width: 1.25rem;
  height: 1.25rem;
}

.input-wrapper input {
  width: 100%;
  padding: var(--spacing-2) var(--spacing-3) var(--spacing-2) var(--spacing-10);
  border: 1px solid var(--color-gray-300);
  border-radius: var(--border-radius);
  font-size: 0.875rem;
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.input-wrapper input:focus {
  border-color: var(--color-primary);
  box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
}

.password-toggle {
  position: absolute;
  right: var(--spacing-3);
  background: none;
  border: none;
  color: var(--color-gray-400);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.password-toggle:hover {
  color: var(--color-gray-500);
}

.password-toggle svg {
  width: 1.25rem;
  height: 1.25rem;
}

.form-options {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: var(--spacing-6);
}

.remember-me {
  display: flex;
  align-items: center;
}

.remember-me input[type="checkbox"] {
  width: 1rem;
  height: 1rem;
  margin-right: var(--spacing-2);
  accent-color: var(--color-primary);
}

.remember-me label {
  font-size: 0.875rem;
  color: var(--color-gray-700);
}

.forgot-password a {
  font-size: 0.875rem;
  color: var(--color-primary);
  text-decoration: none;
  font-weight: 500;
}

.forgot-password a:hover {
  color: var(--color-primary-dark);
  text-decoration: underline;
}

.form-actions {
  margin-bottom: var(--spacing-6);
}

.btn-primary {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: var(--spacing-2) var(--spacing-4);
  background-color: var(--color-primary);
  color: var(--color-white);
  border: none;
  border-radius: var(--border-radius);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
  box-shadow: var(--shadow);
}

.btn-primary:hover {
  background-color: var(--color-primary-dark);
}

.btn-primary:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.loader-icon {
  animation: spin 1s linear infinite;
  margin-right: var(--spacing-2);
  width: 1rem;
  height: 1rem;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.social-login {
  margin-top: var(--spacing-6);
}

.divider {
  position: relative;
  text-align: center;
  margin-bottom: var(--spacing-6);
}

.divider::before {
  content: "";
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background-color: var(--color-gray-300);
}

.divider span {
  position: relative;
  padding: 0 var(--spacing-2);
  background-color: var(--color-white);
  color: var(--color-gray-500);
  font-size: 0.875rem;
}

.social-buttons {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--spacing-3);
}

.btn-social {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: var(--spacing-2) var(--spacing-4);
  background-color: var(--color-white);
  border: 1px solid var(--color-gray-300);
  border-radius: var(--border-radius);
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--color-gray-700);
  cursor: pointer;
  transition: background-color 0.2s;
  box-shadow: var(--shadow-sm);
}

.btn-social:hover {
  background-color: var(--color-gray-100);
}

.btn-social svg {
  margin-right: var(--spacing-2);
  width: 1.25rem;
  height: 1.25rem;
}

.signup-link {
  margin-top: var(--spacing-6);
  text-align: center;
  font-size: 0.875rem;
  color: var(--color-gray-600);
}

.signup-link a {
  color: var(--color-primary);
  font-weight: 500;
  text-decoration: none;
}

.signup-link a:hover {
  color: var(--color-primary-dark);
  text-decoration: underline;
}

.image-column {
  display: none;
  background-color: rgba(147, 51, 234, 0.1);
}

.image-wrapper {
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: var(--spacing-6);
}

.image-wrapper img {
  max-height: 100%;
  max-width: 100%;
  object-fit: cover;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow-lg);
}

/* Media queries para responsividad */
@media (min-width: 768px) {
  .login-container {
    flex-direction: row;
  }

  .form-column {
    width: 50%;
  }

  .image-column {
    display: block;
    width: 50%;
  }
}
</style>
