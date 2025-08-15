{{-- resources/views/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | LifeStream Blood Donation</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    :root {
      --primary-red: #dc2626;
      --dark-red: #b91c1c;
      --light-red: #fee2e2;
      --text-dark: #1f2937;
      --text-light: #6b7280;
    }

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background:
        linear-gradient(rgba(220, 38, 38, 0.1), rgba(220, 38, 38, 0.05)),
        url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3') center/cover no-repeat fixed;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
      color: var(--text-dark);
    }

    .login-container {
      width: 100%;
      max-width: 480px;
      animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .login-card {
      background:
        linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(255,245,245,0.98) 100%),
        url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><path fill="%23dc2626" fill-opacity="0.03" d="M30,10 Q50,5 70,10 Q95,15 90,40 Q85,65 50,90 Q15,65 10,40 Q5,15 30,10 Z"/></svg>');
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 12px 40px rgba(220,38,38,0.15);
      backdrop-filter: blur(4px);
      border: 1px solid rgba(220,38,38,0.08);
      position: relative;
      overflow: hidden;
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 4px;
      background: linear-gradient(90deg, #dc2626, #ef4444);
    }

    .logo {
      text-align: center;
      margin-bottom: 32px;
    }
    .logo-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 60px; height: 60px;
      background-color: var(--light-red);
      border-radius: 50%;
      margin-bottom: 16px;
      box-shadow: 0 4px 12px rgba(220,38,38,0.1);
    }
    .logo-icon i { font-size: 28px; color: var(--primary-red); }
    .logo h1 {
      margin: 0 0 8px;
      font-size: 28px; font-weight: 700;
      color: var(--primary-red); letter-spacing: -0.5px;
    }
    .logo p {
      margin: 0; font-size: 15px;
      color: var(--text-light); font-weight: 500;
    }

    .alert-success {
      background-color: #dcfce7;
      border: 1px solid #22c55e;
      color: #166534;
      padding: 12px 16px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-weight: 500;
      text-align: center;
      opacity: 1;
      transition: opacity 0.5s ease;
    }

    .form-group {
      margin-bottom: 24px;
      position: relative;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      font-size: 15px;
      color: var(--text-dark);
    }
    .input-field {
      position: relative;
    }
    .input-field input {
      width: 100%;
      padding: 14px 16px;
      font-size: 15px;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      background-color: #f9fafb;
      transition: all 0.3s ease;
    }
    .input-field input:focus {
      outline: none;
      border-color: var(--primary-red);
      box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
      background-color: #fff;
    }
    .toggle-visibility {
      position: absolute;
      top: 50%;
      right: 16px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #9ca3af;
      font-size: 16px;
      transition: color 0.2s ease;
    }
    .toggle-visibility:hover {
      color: var(--primary-red);
    }

    .error-message {
      color: #dc2626;
      font-size: 14px;
      margin-top: 8px;
    }

    .login-btn {
      width: 100%;
      padding: 16px;
      background-color: var(--primary-red);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 6px rgba(220,38,38,0.1);
      position: relative;
    }
    .login-btn:hover {
      background-color: var(--dark-red);
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(220,38,38,0.15);
    }
    .btn-loading .btn-text { visibility: hidden; opacity: 0; }
    .btn-loading::after {
      content: "";
      position: absolute;
      width: 20px; height: 20px;
      border: 3px solid transparent;
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .divider {
      display: flex; 
      align-items: center; 
      margin: 28px 0; 
      color: var(--text-light); 
      font-size: 14px; 
      font-weight: 500;
    }
    .divider::before, .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #e5e7eb;
    }
    .divider::before { margin-right: 16px; }
    .divider::after { margin-left: 16px; }

    .register-link {
      text-align: center;
      margin-top: 24px;
      font-size: 15px;
      color: var(--text-light);
    }
    .register-link a {
      color: var(--primary-red);
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    .register-link a:hover {
      text-decoration: underline;
      color: var(--dark-red);
    }

    /* New Forgot Password button */
    .forgot-password-btn {
      width: 100%;
      margin-top: 12px;
      padding: 14px;
      font-size: 15px;
      font-weight: 600;
      border: 2px solid var(--primary-red);
      background: transparent;
      color: var(--primary-red);
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .forgot-password-btn:hover {
      background-color: var(--primary-red);
      color: #fff;
    }

    /* Modal styles */
    #forgotPasswordModal {
      display: none;
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      
    }
    #forgotPasswordModal .modal-box {
      background: #fff;
      padding: 30px 24px;
      border-radius: 12px;
      max-width: 420px;
      width: 100%;
      box-shadow: 0 12px 32px rgba(0,0,0,0.2);
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: stretch;
      font-family: inherit;
    }
    #forgotPasswordModal h2 {
      margin-bottom: 20px;
      font-size: 22px;
      color: var(--primary-red);
      text-align: center;
      font-weight: 700;
      letter-spacing: 0.02em;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    #forgotPasswordModal h2 i {
      font-size: 28px;
    }
    #forgotPasswordModal form label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--text-dark);
      font-size: 14px;
    }
    #forgotPasswordModal form input[type="email"] {
      width: 100%;
      padding: 14px 14px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 24px;
      transition: border-color 0.3s ease;
       box-sizing: border-box;
    }
    #forgotPasswordModal form input[type="email"]:focus {
      outline: none;
      border-color: var(--primary-red);
      box-shadow: 0 0 0 3px rgba(220,38,38,0.15);
    }
    #forgotPasswordModal button[type="submit"] {
      width: 100%;
      background-color: var(--primary-red);
      color: #fff;
      padding: 14px;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 4px 8px rgba(220,38,38,0.2);
    }
    #forgotPasswordModal button[type="submit"]:hover {
      background-color: var(--dark-red);
    }
    #closeModal {
      position: absolute;
      top: 12px;
      right: 14px;
      background: none;
      border: none;
      font-size: 24px;
      color: #999;
      cursor: pointer;
      transition: color 0.3s ease;
    }
    #closeModal:hover {
      color: var(--primary-red);
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">

      {{-- Flash message --}}
      @if(session('success'))
        <div id="flashMessage" class="alert-success">{{ session('success') }}</div>
      @endif

      <div class="logo">
        <div class="logo-icon"><i class="fas fa-tint"></i></div>
        <h1>LifeStream</h1>
        <p>Login to your donor account</p>
      </div>

      <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
          <label for="email">Email Address</label>
          <div class="input-field">
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" />
          </div>
          @error('email')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-field">
            <input type="password" id="password" name="password" required placeholder="••••••••" />
            <i class="fas fa-eye toggle-visibility" id="togglePassword"></i>
          </div>
          @error('password')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="login-btn" id="loginBtn">
          <span class="btn-text">Sign In</span>
          <i class="fas fa-right-to-bracket"></i>
        </button>

        <button type="button" class="forgot-password-btn" id="forgotPasswordBtn">
          <i class="fas fa-key"></i> Forgot password?
        </button>
      </form>

      

      
    </div>
  </div>

  {{-- Forgot Password Modal --}}
  <div id="forgotPasswordModal" role="dialog" aria-modal="true" aria-labelledby="forgotPasswordTitle">
    <div class="modal-box">
      <button id="closeModal" aria-label="Close modal"><i class="fas fa-times"></i></button>
      <h2 id="forgotPasswordTitle"><i class="fas fa-envelope-open-text"></i> Reset Password</h2>
      <form method="POST" action="#" id="forgotPasswordForm">
        @csrf
        <label for="forgotEmail">Enter your email address</label>
        <input type="email" id="forgotEmail" name="email" placeholder="you@example.com" required />
        <button type="submit"><i class="fas fa-paper-plane"></i> Send Email</button>
      </form>
    </div>
  </div>

  <script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    togglePassword.addEventListener('click', () => {
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
      togglePassword.classList.toggle('fa-eye-slash');
    });

    // Show flash message fade out after 3.5 seconds
    const flashMsg = document.getElementById('flashMessage');
    if (flashMsg) {
      setTimeout(() => {
        flashMsg.style.opacity = '0';
      }, 3500);
      setTimeout(() => {
        flashMsg.remove();
      }, 4000);
    }

    // Forgot Password Modal
    const forgotPasswordBtn = document.getElementById('forgotPasswordBtn');
    const forgotPasswordModal = document.getElementById('forgotPasswordModal');
    const closeModalBtn = document.getElementById('closeModal');

    forgotPasswordBtn.addEventListener('click', () => {
      forgotPasswordModal.style.display = 'flex';
      document.getElementById('forgotEmail').focus();
    });

    closeModalBtn.addEventListener('click', () => {
      forgotPasswordModal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
      if (e.target === forgotPasswordModal) {
        forgotPasswordModal.style.display = 'none';
      }
    });
  </script>
  <script>
document.getElementById('forgotPasswordBtn').addEventListener('click', function() {
    const modal = document.getElementById('forgotPasswordModal');
    modal.style.display = 'flex';
    document.getElementById('forgotEmail').focus();
    
    // Add centering styles dynamically
    const modalBox = modal.querySelector('.modal-box');
    modalBox.style.position = 'fixed';
    modalBox.style.top = '50%';
    modalBox.style.left = '50%';
    modalBox.style.transform = 'translate(-50%, -50%)';
});
</script>
</body>
</html>