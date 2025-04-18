<template>
  <div class="register-container">
    <!-- Fondo de partículas -->
    <div id="particles-background" class="particles-background"></div>

    <div class="register-content">
      <!-- Columna izquierda - Formulario de registro -->
      <div class="form-column">
        <div class="form-wrapper">
          <div class="form-header">
            <h2>Sign Up</h2>
            <!-- <p>Completa tus datos para registrarte</p> -->
          </div>

          <form @submit.prevent="handleRegister" class="register-form">
            <div class="form-fields">
              <div class="form-group">
                <label for="name">Name</label>
                <div class="input-wrapper">
                  <div class="input-icon">
                    <user-icon />
                  </div>
                  <input
                    id="name"
                    v-model="name"
                    type="text"
                    required
                    placeholder="Full Name"
                  />
                </div>
              </div>

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
                <div class="password-strength" v-if="password">
                  <div class="strength-meter">
                    <div
                      class="strength-value"
                      :style="{ width: passwordStrength + '%', backgroundColor: passwordStrengthColor }"
                    ></div>
                  </div>
                  <span class="strength-text" :style="{ color: passwordStrengthColor }">
                    {{ passwordStrengthText }}
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="input-wrapper">
                  <div class="input-icon">
                    <lock-icon />
                  </div>
                  <input
                    id="confirmPassword"
                    v-model="confirmPassword"
                    :type="showConfirmPassword ? 'text' : 'password'"
                    required
                    placeholder="••••••••"
                  />
                  <button
                    type="button"
                    @click="showConfirmPassword = !showConfirmPassword"
                    class="password-toggle"
                  >
                    <eye-icon v-if="showConfirmPassword" />
                    <eye-off-icon v-else />
                  </button>
                </div>
                <div class="password-match" v-if="confirmPassword && password">
                  <check-icon v-if="passwordsMatch" class="match-icon match" />
                  <x-icon v-else class="match-icon no-match" />
                  <span :class="passwordsMatch ? 'match' : 'no-match'">
                    {{ passwordsMatch ? 'Las contraseñas coinciden' : 'Las contraseñas no coinciden' }}
                  </span>
                </div>
              </div>
            </div>

            <div class="form-terms">
              <input
                id="terms"
                v-model="acceptTerms"
                type="checkbox"
                required
              />
              <label for="terms">
                Accept the <a href="#">Terms and Conditions</a> and the <a href="#">Privacy Policy</a>
              </label>
            </div>

            <div class="form-actions">
              <button
                type="submit"
                class="btn-primary"
                :disabled="loading || !isFormValid"
              >
                <loader-icon v-if="loading" class="loader-icon" />
                {{ loading ? 'Registering...' : 'Create Account' }}
              </button>
            </div>
          </form>

          <!-- <div class="social-login">
            <div class="divider">
              <span>O regístrate con</span>
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

          <p class="login-link">
            Already Have An Account?
            <a href="#">Log In</a>
          </p>
        </div>
      </div>

      <!-- Columna derecha - Imagen -->
      <div class="image-column">
        <div class="image-wrapper">
          <!-- <img
            src="/placeholder.svg?height=600&width=800"
            alt="Register illustration"
          /> -->
          <div class="image-overlay">
            <div class="testimonial">
              <div class="quote-icon">
                <quote-icon />
              </div>
              <blockquote>
                "Esta plataforma ha transformado la manera en que trabajo. La interfaz es intuitiva y el soporte es excepcional."
              </blockquote>
              <div class="testimonial-author">
                <div class="author-avatar">
                  <!-- <img src="/placeholder.svg?height=50&width=50" alt="Avatar" /> -->
                </div>
                <div class="author-info">
                  <div class="author-name">María González</div>
                  <div class="author-title">Diseñadora UX/UI</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { message } from 'ant-design-vue';
import {
  User as UserIcon,
  Mail as MailIcon,
  Lock as LockIcon,
  Eye as EyeIcon,
  EyeOff as EyeOffIcon,
  Loader as LoaderIcon,
  Facebook as FacebookIcon,
  Mail as GoogleIcon,
  Check as CheckIcon,
  X as XIcon,
  Quote as QuoteIcon
} from 'lucide-vue-next';

// Estado del formulario
const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const acceptTerms = ref(false);
const showPassword = ref(false);
const showConfirmPassword = ref(false);
const loading = ref(false);

// Validaciones
const passwordsMatch = computed(() => {
  return password.value && confirmPassword.value && password.value === confirmPassword.value;
});

const passwordStrength = computed(() => {
  if (!password.value) return 0;

  let strength = 0;

  // Longitud mínima
  if (password.value.length >= 8) strength += 25;

  // Contiene números
  if (/\d/.test(password.value)) strength += 25;

  // Contiene letras minúsculas y mayúsculas
  if (/[a-z]/.test(password.value) && /[A-Z]/.test(password.value)) strength += 25;

  // Contiene caracteres especiales
  if (/[^a-zA-Z0-9]/.test(password.value)) strength += 25;

  return strength;
});

const passwordStrengthText = computed(() => {
  const strength = passwordStrength.value;
  if (strength === 0) return '';
  if (strength <= 25) return 'Débil';
  if (strength <= 50) return 'Regular';
  if (strength <= 75) return 'Buena';
  return 'Fuerte';
});

const passwordStrengthColor = computed(() => {
  const strength = passwordStrength.value;
  if (strength <= 25) return '#f44336';
  if (strength <= 50) return '#ff9800';
  if (strength <= 75) return '#2196f3';
  return '#4caf50';
});

const isFormValid = computed(() => {
  return (
    name.value.trim() !== '' &&
    email.value.trim() !== '' &&
    password.value.length >= 8 &&
    passwordsMatch.value &&
    acceptTerms.value
  );
});

// Método para manejar el registro
const handleRegister = async () => {
  if (!isFormValid.value) return;

  loading.value = true;
  let queryParams = {
    name: name.value,
    email: email.value,
    password: password.value,
  };

  try {

    await axios.post('/register', queryParams);

    // Redirección después del registro exitoso
    window.location.href = '/login';
  } catch (error) {
    message.error('Please Try Again');
  } finally {
    message.success('User Successfully Created');
    loading.value = false;
  }
};

// Inicialización de partículas
// onMounted(() => {
//   initParticles();
// });

// function initParticles() {
//   const canvas = document.createElement('canvas');
//   const container = document.getElementById('particles-background');
//   container.appendChild(canvas);

//   const ctx = canvas.getContext('2d');
//   let particlesArray = [];

//   // Configuración de partículas
//   const particleCount = 100;
//   const particleColor = 'rgba(147, 51, 234, 0.5)';
//   const lineColor = 'rgba(147, 51, 234, 0.2)';
//   const particleRadius = 2;
//   const lineWidth = 1;
//   const lineDistance = 150;
//   const moveSpeed = 0.5;

//   // Redimensionar canvas
  // function resizeCanvas() {
  //   canvas.width = container.clientWidth;
  //   canvas.height = container.clientHeight;
  // }

//   // Crear partículas
//   // function createParticles() {
//   //   particlesArray = [];
//   //   for (let i = 0; i < particleCount; i++) {
//   //     particlesArray.push({
//   //       x: Math.random() * canvas.width,
//   //       y: Math.random() * canvas.height,
//   //       vx: Math.random() * moveSpeed * 2 - moveSpeed,
//   //       vy: Math.random() * moveSpeed * 2 - moveSpeed,
//   //       radius: Math.random() * particleRadius + 1,
//   //     });
//   //   }
//   // }

//   // Animar partículas
//   // function animateParticles() {
//   //   ctx.clearRect(0, 0, canvas.width, canvas.height);

//   //   // Actualizar y dibujar partículas
//   //   for (let i = 0; i < particlesArray.length; i++) {
//   //     const p = particlesArray[i];

//   //     // Mover partícula
//   //     p.x += p.vx;
//   //     p.y += p.vy;

//   //     // Rebotar en los bordes
//   //     if (p.x < 0 || p.x > canvas.width) p.vx = -p.vx;
//   //     if (p.y < 0 || p.y > canvas.height) p.vy = -p.vy;

//   //     // Dibujar partícula
//   //     ctx.beginPath();
//   //     ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
//   //     ctx.fillStyle = particleColor;
//   //     ctx.fill();

//   //     // Conectar partículas cercanas
//   //     for (let j = i + 1; j < particlesArray.length; j++) {
//   //       const p2 = particlesArray[j];
//   //       const dx = p.x - p2.x;
//   //       const dy = p.y - p2.y;
//   //       const distance = Math.sqrt(dx * dx + dy * dy);

//   //       if (distance < lineDistance) {
//   //         ctx.beginPath();
//   //         ctx.moveTo(p.x, p.y);
//   //         ctx.lineTo(p2.x, p2.y);
//   //         ctx.strokeStyle = lineColor;
//   //         ctx.lineWidth = lineWidth;
//   //         ctx.stroke();
//   //       }
//   //     }
//   //   }

//   //   requestAnimationFrame(animateParticles);
//   // }

//   // Inicializar
  window.addEventListener('resize', () => {
    // resizeCanvas();
    // createParticles();
  });

//   resizeCanvas();
//   // createParticles();
//   // animateParticles();
// }
</script>

<style>
:root {
  --color-primary: #04284a;
  --color-primary-dark: #021a30;
  --color-primary-light: #0a5aa3;
  --color-gray-100: #f3f4f6;
  --color-gray-200: #e5e7eb;
  --color-gray-300: #3c4757;
  --color-gray-400: #9ca3af;
  --color-gray-500: #6b7280;
  --color-gray-600: #4b5563;
  --color-gray-700: #374151;
  --color-gray-800: #1f2937;
  --color-gray-900: #111827;
  --color-white: #ffffff;
  --color-success: #4caf50;
  --color-error: #f44336;
  --color-warning: #ff9800;
  --color-info: #2196f3;
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

.register-container {
  position: relative;
  min-height: 100vh;
  width: 100%;
  overflow: hidden;
}

.particles-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
}

.register-content {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(5px);
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
  max-width: 450px;
  margin: 0 auto;
  background-color: var(--color-white);
  padding: var(--spacing-8);
  border-radius: var(--border-radius);
  box-shadow: var(--shadow-lg);
}

.form-header {
  text-align: center;
  margin-bottom: var(--spacing-8);
}

.form-header h2 {
  font-size: 1.875rem;
  font-weight: 700;
  margin-bottom: var(--spacing-2);
  color: var(--color-primary);
}

.form-header p {
  color: var(--color-gray-600);
  font-size: 0.875rem;
}

.register-form {
  margin-top: var(--spacing-6);
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

.password-strength {
  margin-top: var(--spacing-2);
  font-size: 0.75rem;
}

.strength-meter {
  height: 4px;
  background-color: var(--color-gray-200);
  border-radius: 2px;
  margin-bottom: var(--spacing-1);
  overflow: hidden;
}

.strength-value {
  height: 100%;
  border-radius: 2px;
  transition: width 0.3s, background-color 0.3s;
}

.strength-text {
  font-size: 0.75rem;
  font-weight: 500;
}

.password-match {
  display: flex;
  align-items: center;
  margin-top: var(--spacing-2);
  font-size: 0.75rem;
}

.match-icon {
  margin-right: var(--spacing-1);
  width: 0.875rem;
  height: 0.875rem;
}

.match {
  color: var(--color-success);
}

.no-match {
  color: var(--color-error);
}

.form-terms {
  display: flex;
  align-items: flex-start;
  margin-bottom: var(--spacing-6);
}

.form-terms input[type="checkbox"] {
  margin-top: 0.25rem;
  margin-right: var(--spacing-2);
  accent-color: var(--color-primary);
}

.form-terms label {
  font-size: 0.875rem;
  color: var(--color-gray-700);
}

.form-terms a {
  color: var(--color-primary);
  text-decoration: none;
}

.form-terms a:hover {
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
  padding: var(--spacing-3) var(--spacing-4);
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

.login-link {
  margin-top: var(--spacing-6);
  text-align: center;
  font-size: 0.875rem;
  color: var(--color-gray-600);
}

.login-link a {
  color: var(--color-primary);
  font-weight: 500;
  text-decoration: none;
}

.login-link a:hover {
  color: var(--color-primary-dark);
  text-decoration: underline;
}

.image-column {
  display: none;
  background-color: rgba(13, 13, 94, 0.05);
}

.image-wrapper {
  position: relative;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: var(--spacing-6);
  overflow: hidden;
}

.image-wrapper img {
  max-height: 100%;
  max-width: 100%;
  object-fit: cover;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow-lg);
  z-index: 1;
}

.image-overlay {
  position: absolute;
  bottom: var(--spacing-10);
  left: var(--spacing-10);
  right: var(--spacing-10);
  background-color: rgba(255, 255, 255, 0.9);
  border-radius: var(--border-radius);
  padding: var(--spacing-6);
  box-shadow: var(--shadow-lg);
  z-index: 2;
}

.testimonial {
  display: flex;
  flex-direction: column;
}

.quote-icon {
  color: var(--color-primary-light);
  margin-bottom: var(--spacing-2);
}

.quote-icon svg {
  width: 2rem;
  height: 2rem;
}

.testimonial blockquote {
  font-style: italic;
  margin-bottom: var(--spacing-4);
  color: var(--color-gray-700);
}

.testimonial-author {
  display: flex;
  align-items: center;
}

.author-avatar {
  margin-right: var(--spacing-3);
}

.author-avatar img {
  width: 3rem;
  height: 3rem;
  border-radius: 50%;
  object-fit: cover;
}

.author-name {
  font-weight: 600;
  color: var(--color-gray-900);
}

.author-title {
  font-size: 0.875rem;
  color: var(--color-gray-600);
}

/* Media queries para responsividad */
@media (min-width: 768px) {
  .register-content {
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
