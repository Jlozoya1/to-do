<template>
  <div>
    <header class="header">
      <div class="header-container">
        <div class="logo-wrapper">
          <a href="/" class="logo-link">
            <div class="logo-icon">
              <!-- SVG -->
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M12 6V12L16 14" stroke="white" stroke-width="2" stroke-linecap="round" />
                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" />
              </svg>
            </div>
            <span class="logo-text">To-Do</span>
          </a>
        </div>
        <!-- <nav class="nav-links">
          <a href="#features">Features</a>
          <a href="#how-it-works">How It Works</a>
          <a href="#testimonials">Testimonials</a>
          <a href="#pricing">Pricing</a>
          <a href="#faq">FAQ</a>
        </nav> -->
        <div style="display: flex; justify-content: flex-end;">

          <router-link :to="{name : 'loginIndex'}">
            <button class="download-btn" style="margin-right: 1rem;">Login</button>
          </router-link>

          <router-link :to="{name : 'registerIndex'}">
            <button class="download-btn">Register</button>
          </router-link>

        </div>
      </div>
    </header>
  </div>
</template>

<script>
  export default {
    components: {

    },
    data() {
      return {

      }
    },
    methods: {

    }
  }
</script>

<style>
  .header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 50;
  }

  .header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(20px);
  }

  .logo-wrapper,
  .logo-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .logo-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 9999px;
    background: linear-gradient(to bottom right, #021a30, #04284a); /* red-500 to orange-500 */
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .logo-text {
    font-weight: 500;
    color: white;
  }

  .nav-links {
    display: none;
  }

  @media (min-width: 768px) {
    .nav-links {
      display: flex;
      align-items: center;
      gap: 2rem;
    }

    .nav-links a {
      font-size: 0.875rem;
      color: #d1d5db; /* gray-300 */
      transition: color 0.2s;
    }

    .nav-links a:hover {
      color: white;
    }
  }

  .download-btn {
    background: linear-gradient(to right, #021a30, #043059);
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: opacity 0.2s;
  }

  .download-btn:hover {
    opacity: 0.9;
  }

</style>
