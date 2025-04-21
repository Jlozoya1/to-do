<template>
    <section class="hero-section">
      <!-- Fondo interactivo simulado -->
      <div class="interactive-grid"></div>

      <div class="shine-border">
        <div class="hero-content">
          <h1>
            <span class="gradient-text">Boost Your Productivity</span> <br />
            <span class="gradient-text">One Task at a Time</span>
          </h1>
          <p>
            To-Do is a simple yet powerful technique that helps you organize your tasks more effectively.
            It not only keeps you on track but also makes it easier to switch between projects and complete each task with clarity and focus.
          </p>
          <div class="button-group">
            <button class="btn-outline">Watch Demo</button>
            <button class="btn-gradient">Download Now</button>
          </div>
        </div>

        <div class="shine-border timer-box">
          <div class="timer-content">
            <div class="timer-left">
              <div class="pomodoro-timer">⏱ Task Organizator</div>
            </div>
            <div class="timer-right">
              <div class="card">
                <h3>Today's Progress</h3>
                <div class="stats">
                  <div>
                    <p class="stat-number red">4</p>
                    <p class="stat-label">Task Dues</p>
                  </div>
                  <div>
                    <p class="stat-number orange">2h</p>
                    <p class="stat-label">Focus Time</p>
                  </div>
                  <div>
                    <p class="stat-number yellow">3</p>
                    <p class="stat-label">Tasks Done</p>
                  </div>
                </div>
              </div>
              <div class="card">
                <h3>Current Task</h3>
                <div class="task">
                  <div class="dot red"></div>
                  <span>Complete landing page design</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>

  <script setup>
  // No lógica aún, solo estática
  </script>

  <style scoped>
  .hero-section {
    position: relative;
    min-height: 100vh;
    padding: 8rem 1.5rem 4rem;
    background: black;
    overflow: hidden;
  }

  .interactive-grid {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px);
    background-size: 40px 40px;
    opacity: 0.3;
  }

  .shine-border {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 1rem;
    overflow: hidden;
    background: rgba(255,255,255,0.02);
    z-index: 10;
  }

  .hero-content {
    text-align: center;
    margin-bottom: 4rem;
  }

  .hero-content h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
    line-height: 1.2;
  }

  .gradient-text {
    background: linear-gradient(to right, #021a30, #043059);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .hero-content p {
    color: #ccc;
    font-size: 1.125rem;
    max-width: 600px;
    margin: 0 auto 2rem;
  }

  .button-group {
    display: flex;
    justify-content: center;
    gap: 1rem;
  }

  button {
    padding: 0.75rem 1.5rem;
    font-weight: bold;
    border-radius: 0.5rem;
    cursor: pointer;
    border: none;
    font-size: 1rem;
  }

  .btn-outline {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
  }

  .btn-outline:hover {
    background: rgba(255,255,255,0.1);
  }

  .btn-gradient {
    background: linear-gradient(to right, #021a30, #043059);
    color: white;
  }

  .btn-gradient:hover {
    opacity: 0.9;
  }

  .timer-box {
    margin-top: 2rem;
    background: rgba(0, 0, 0, 0.8);
    padding: 2rem;
    border-radius: 1rem;
  }

  .timer-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  @media (min-width: 768px) {
    .timer-content {
      grid-template-columns: 1fr 1fr;
      align-items: center;
    }
  }

  .pomodoro-timer {
    background: rgba(255,255,255,0.05);
    padding: 2rem;
    border-radius: 1rem;
    text-align: center;
    font-size: 1.5rem;
    color: white;
  }

  .timer-right .card {
    background: rgba(255,255,255,0.05);
    padding: 1.5rem;
    border-radius: 1rem;
    border: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 1.5rem;
  }

  .card h3 {
    font-size: 1.25rem;
    margin-bottom: 1rem;
    color: white;
  }

  .stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    text-align: center;
    gap: 1rem;
  }

  .stat-number {
    font-size: 2rem;
    font-weight: bold;
  }

  .stat-label {
    font-size: 0.75rem;
    color: #aaa;
  }

  .red { color: #f87171; }
  .orange { color: #fb923c; }
  .yellow { color: #facc15; }

  .task {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
  }

  .dot {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
  }

  .dot.red {
    background-color: red;
  }
  </style>
