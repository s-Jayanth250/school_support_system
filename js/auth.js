// js/auth.js
document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const showRegister = document.getElementById('showRegister');
  const showLogin = document.getElementById('showLogin');
  const showLoginP = document.getElementById('showLoginP');

  showRegister.addEventListener('click', (e)=>{ e.preventDefault(); loginForm.style.display='none'; registerForm.style.display='block'; document.getElementById('authTitle').textContent='Register'; showLoginP.style.display='block'; });
  showLogin?.addEventListener('click', (e)=>{ e.preventDefault(); loginForm.style.display='block'; registerForm.style.display='none'; document.getElementById('authTitle').textContent='Login'; showLoginP.style.display='none'; });

  const radios = document.querySelectorAll('input[name="user_type"]');
  const loginHidden = document.getElementById('login_user_type');
  const regHidden = document.getElementById('reg_user_type');
  radios.forEach(r => r.addEventListener('change', ()=>{
    loginHidden.value = r.value;
    regHidden.value = r.value;
  }));

  // simple client-side registration validation
  registerForm.addEventListener('submit', (e)=>{
    const pwd = registerForm.querySelector('input[name="password"]').value;
    if (pwd.length < 6) { e.preventDefault(); alert('Password must be at least 6 characters'); }
  });
});
