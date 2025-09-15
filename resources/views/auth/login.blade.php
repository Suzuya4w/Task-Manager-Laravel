<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Manager | Login</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/logo-circle.png') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

  <style>
    :root {
      --primary-color: #2563eb;
      --primary-dark: #1d4ed8;
      --primary-light: #3b82f6;
      --secondary-color: #10b981;
      --text-dark: #1f2937;
      --text-light: #6b7280;
      --bg-light: #f8fafc;
      --bg-dark: #0f172a;
      --card-bg-light: #ffffff;
      --card-bg-dark: #1e293b;
      --input-bg-light: #ffffff;
      --input-bg-dark: #334155;
      --border-light: #e5e7eb;
      --border-dark: #475569;
    }
    
    body {
      margin: 0;
      font-family: 'Mona Sans', sans-serif;
      height: 100vh;
      display: flex;
      transition: all 0.4s ease;
    }

    /* Light Mode */
    body.light-mode {
      background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
      color: white;
    }

    /* Dark Mode */
    body.dark-mode {
      background: linear-gradient(135deg, #141e30 0%, #243b55 100%);
      color: #f1f1f1;
    }

    .login-container {
      display: flex;
      width: 100%;
      height: 100%;
    }

    .brand-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      transition: all 0.4s ease;
    }

    body.dark-mode .brand-section {
      background: rgba(0, 0, 0, 0.2);
    }

    .brand-content {
      max-width: 500px;
      text-align: center;
    }

    .brand-logo {
      max-width: 180px;
      margin-bottom: 2rem;
      filter: brightness(0) invert(1);
      transition: all 0.4s ease;
    }

    body.dark-mode .brand-logo {
      filter: brightness(0) invert(1);
    }

    .brand-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      transition: all 0.4s ease;
    }

    .brand-subtitle {
      font-size: 1.1rem;
      opacity: 0.9;
      margin-bottom: 2rem;
      transition: all 0.4s ease;
    }

    .feature-list {
      text-align: left;
      margin-top: 2rem;
    }

    .feature-item {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
      font-size: 1rem;
      transition: all 0.4s ease;
    }

    .feature-icon {
      background: rgba(255, 255, 255, 0.2);
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
      transition: all 0.4s ease;
    }

    body.dark-mode .feature-icon {
      background: rgba(255, 255, 255, 0.1);
    }

    .login-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      background: var(--bg-light);
      transition: all 0.4s ease;
    }

    body.dark-mode .login-section {
      background: var(--bg-dark);
    }

    .login-card {
      background: var(--card-bg-light);
      border-radius: 16px;
      padding: 2.5rem;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: all 0.4s ease;
    }

    body.dark-mode .login-card {
      background: var(--card-bg-dark);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 0.5rem;
      transition: all 0.4s ease;
    }

    body.dark-mode .login-title {
      color: #f1f1f1;
    }

    .login-subtitle {
      color: var(--text-light);
      font-size: 0.95rem;
      transition: all 0.4s ease;
    }

    body.dark-mode .login-subtitle {
      color: #cbd5e1;
    }

    .form-label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
      transition: all 0.4s ease;
    }

    body.dark-mode .form-label {
      color: #e2e8f0;
    }

    .form-control {
      border-radius: 10px;
      padding: 0.75rem 1rem;
      font-size: 1rem;
      border: 1px solid var(--border-light);
      background: var(--input-bg-light);
      transition: all 0.2s ease;
    }

    body.dark-mode .form-control {
      background: var(--input-bg-dark);
      border: 1px solid var(--border-dark);
      color: #e2e8f0;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    body.dark-mode .form-control:focus {
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    }

    .input-group {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--text-light);
      cursor: pointer;
      padding: 0;
      font-size: 1rem;
      z-index: 5;
      transition: all 0.4s ease;
    }

    body.dark-mode .password-toggle {
      color: #94a3b8;
    }

    .btn-login {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 0.75rem;
      font-size: 1rem;
      transition: all 0.3s ease;
      color: white;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, var(--primary-dark) 0%, #0d9665 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .form-check-input:checked {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .form-check-label {
      font-size: 0.9rem;
      color: var(--text-light);
      transition: all 0.4s ease;
    }

    body.dark-mode .form-check-label {
      color: #cbd5e1;
    }

    .login-footer {
      margin-top: 1.5rem;
      text-align: center;
      font-size: 0.85rem;
      color: var(--text-light);
      transition: all 0.4s ease;
    }

    body.dark-mode .login-footer {
      color: #94a3b8;
    }

    .developer-link {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 600;
      transition: all 0.4s ease;
    }

    .developer-link:hover {
      text-decoration: underline;
      color: var(--primary-dark);
    }

    body.dark-mode .developer-link {
      color: var(--primary-light);
    }

    body.dark-mode .developer-link:hover {
      color: var(--primary-color);
    }

    .error-feedback {
      font-size: 0.85rem;
      margin-top: 0.25rem;
      display: block;
    }

    /* Dark mode toggle button */
    .toggle-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      border: none;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 50%;
      width: 50px;
      height: 50px;
      font-size: 1.2rem;
      cursor: pointer;
      color: white;
      transition: all 0.3s ease;
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .toggle-btn:hover {
      transform: rotate(20deg);
      background: rgba(255, 255, 255, 0.3);
    }

    body.dark-mode .toggle-btn {
      background: rgba(0, 0, 0, 0.2);
      color: white;
    }

    body.dark-mode .toggle-btn:hover {
      background: rgba(0, 0, 0, 0.3);
    }

    /* Responsive design */
    @media (max-width: 992px) {
      .login-container {
        flex-direction: column;
      }
      
      .brand-section {
        padding: 1.5rem;
        display: none;
      }
      
      .login-section {
        padding: 1.5rem;
      }

      .toggle-btn {
        top: 10px;
        right: 10px;
        width: 40px;
        height: 40px;
        font-size: 1rem;
      }
    }

    @media (min-width: 993px) {
      .mobile-brand {
        display: none;
      }
    }

    .mobile-brand {
      text-align: center;
      margin-bottom: 2rem;
    }
    
    .mobile-logo {
      max-width: 80px;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body class="light-mode">

  <button class="toggle-btn" id="themeToggle">🌙</button>

  <div class="login-container">
    <!-- Brand Section -->
    <div class="brand-section">
      <div class="brand-content">
        <img src="{{ asset('assets/img/Task.png') }}" alt="Task Manager" class="brand-logo">
        <h1 class="brand-title">Task Manager</h1>
        <p class="brand-subtitle">Kelola tugas dan proyek Anda dengan lebih efisien</p>
        
        <div class="feature-list">
          <div class="feature-item">
            <div class="feature-icon">
              <i class="bi bi-list-task"></i>
            </div>
            <span>Kelola tugas dengan mudah</span>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <i class="bi bi-calendar-check"></i>
            </div>
            <span>Jadwalkan rutinitas harian</span>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <i class="bi bi-bell"></i>
            </div>
            <span>Pengingat waktu nyata</span>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <i class="bi bi-file-earmark"></i>
            </div>
            <span>Simpan dan kelola file</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Login Section -->
    <div class="login-section">
      <div class="login-card">



        
        <!-- Mobile Brand -->
        <div class="mobile-brand">
          <img src="{{ asset('assets/img/logo-circle.png') }}" alt="Task Manager" class="mobile-logo">
          <h2 class="brand-title" style="font-size: 1.8rem;">Task Manager</h2>
        </div>
        
        <div class="login-header">
          <h2 class="login-title">Masuk ke Akun Anda</h2>
          <p class="login-subtitle">Selamat datang kembali! Silakan masukkan detail login Anda</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="nama@contoh.com" required autofocus value="{{ old('email') }}">
            @error('email')
              <span class="text-danger error-feedback">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
              <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
              <button type="button" id="passwordToggle" class="password-toggle">
                <i class="bi bi-eye"></i>
              </button>
            </div>
            @error('password')
              <span class="text-danger error-feedback">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember" class="form-check-label">Ingat saya</label>
          </div>
          
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-login">Masuk</button>
          </div>
        </form>
        
        <div class="login-footer">
          <p>Belum punya akun? 
            <a href="{{ route('register') }}" class="developer-link">Daftar di sini</a>
          </p>
          <p>Dikembangkan oleh: 
            <a href="https://github.com/Suzuya4w" target="_blank" class="developer-link">Suzuya4w</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Dark mode toggle functionality
    const toggleBtn = document.getElementById("themeToggle");
    const body = document.body;

    // Check for saved theme preference or respect OS preference
    if (localStorage.getItem('theme') === 'dark' || 
        (window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('theme'))) {
      body.classList.add('dark-mode');
      body.classList.remove('light-mode');
      toggleBtn.textContent = "☀️";
    } else {
      body.classList.add('light-mode');
      body.classList.remove('dark-mode');
      toggleBtn.textContent = "🌙";
    }

    toggleBtn.addEventListener("click", () => {
      if (body.classList.contains("dark-mode")) {
        body.classList.remove("dark-mode");
        body.classList.add("light-mode");
        toggleBtn.textContent = "🌙";
        localStorage.setItem('theme', 'light');
      } else {
        body.classList.remove("light-mode");
        body.classList.add("dark-mode");
        toggleBtn.textContent = "☀️";
        localStorage.setItem('theme', 'dark');
      }
    }); 

    // Password toggle functionality
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordInput = document.getElementById('password');
    
    passwordToggle.addEventListener('click', function() {
      // Toggle the password visibility
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      // Toggle the eye icon
      const eyeIcon = this.querySelector('i');
      if (type === 'text') {
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
      } else {
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
      }
    });

    // Focus on email field when page loads
    window.onload = function() {
      document.getElementById('email').focus();
    };
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>