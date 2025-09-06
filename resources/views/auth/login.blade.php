<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Manager | Login</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/logo-circle.png') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      transition: background 0.4s, color 0.4s;
    }

    /* Light mode */
    body.light {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      color: #212529;
    }

    /* Dark mode */
    body.dark {
      background: linear-gradient(135deg, #141e30, #243b55);
      color: #f1f1f1;
    }

    .split {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem;
    }

    .brand {
      text-align: center;
      color: inherit;
    }

    .brand img {
      max-width: 250px;
      margin-bottom: 1.5rem;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 2.5rem;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      transition: background 0.4s;
    }

    body.dark .login-card {
      background: rgba(0, 0, 0, 0.65);
    }

    .login-card h2 {
      font-weight: 600;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .form-label {
      font-weight: 500;
      font-size: 0.9rem;
    }

    .form-control {
      border-radius: 12px;
      padding: 0.75rem;
      font-size: 0.95rem;
      border: 1px solid #ced4da;
    }

    body.dark .form-control {
      background: #1e293b;
      border: 1px solid #475569;
      color: #f1f1f1;
    }

    .btn-primary {
      background: linear-gradient(135deg, #4e73df, #1cc88a);
      border: none;
      border-radius: 12px;
      font-weight: 600;
      transition: 0.3s;
      padding: 0.75rem;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #375ac0, #17a673);
      transform: translateY(-2px);
    }

    .form-check-label {
      font-size: 0.9rem;
    }

    .card-footer {
      margin-top: 1.5rem;
      text-align: center;
      font-size: 0.85rem;
    }

    .card-footer a {
      font-weight: 600;
      color: #4e73df;
      text-decoration: none;
    }

    .card-footer a:hover {
      text-decoration: underline;
    }

    /* Dark mode toggle button */
    .toggle-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      border: none;
      background: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: inherit;
      transition: transform 0.3s;
    }

    .toggle-btn:hover {
      transform: rotate(20deg);
    }

    /* Password toggle styles */
    .password-input-container {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #6c757d;
      cursor: pointer;
      padding: 0;
      font-size: 1rem;
    }

    body.dark .password-toggle {
      color: #a0aec0;
    }
  </style>
</head>
<body class="light">

  <button class="toggle-btn" id="themeToggle">🌙</button>

  <div class="split">
    <div class="brand">
      <img src="{{ asset('assets/img/logo-login.png') }}" alt="Task Manager">
      <h1>Welcome Back 👋</h1>
      <p>Log in to manage your tasks smarter & faster.</p>
    </div>
  </div>

  <div class="split">
    <div class="login-card">
      <h2>Login</h2>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="admin@example.com" required autofocus>
          @error('email')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="password-input-container">
            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            <button type="button" id="passwordToggle" class="password-toggle">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          @error('password')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" name="remember" id="remember" class="form-check-input">
          <label for="remember" class="form-check-label">Remember Me</label>
        </div>
        <div class="d-grid mb-1">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
      <div class="card-footer">
        <p>Developed by: 
          <a href="https://github.com/Suzuya4w" target="_blank">Suzuya4w</a>
        </p>
      </div>
    </div>
  </div>

<script>
  const toggleBtn = document.getElementById("themeToggle");
  const body = document.body;

  toggleBtn.addEventListener("click", () => {
    body.classList.toggle("dark");
    body.classList.toggle("light");
    toggleBtn.textContent = body.classList.contains("dark") ? "☀️" : "🌙";
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
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
    } else {
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>