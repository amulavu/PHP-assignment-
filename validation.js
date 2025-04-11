function validateForm() {
    const fullName = document.getElementById('full_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const errorDiv = document.getElementById('error');
  
    errorDiv.innerText = '';
  
    if (!fullName.match(/^[A-Za-z ]+$/)) {
      errorDiv.innerText = "Name must contain letters only.";
      return false;
    }
  
    if (phone && !phone.match(/^\d{10,15}$/)) {
      errorDiv.innerText = "Phone must be 10-15 digits.";
      return false;
    }
  
    if (password.length < 6) {
      errorDiv.innerText = "Password must be at least 6 characters.";
      return false;
    }
  
    if (password !== confirmPassword) {
      errorDiv.innerText = "Passwords do not match.";
      return false;
    }
  
    return true;
  }
  