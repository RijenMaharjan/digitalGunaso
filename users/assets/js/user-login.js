const loginForm = document.getElementById("loginForm");
const forgotPasswordLink = document.getElementById("forgotPassword");

// Handle form submission
loginForm.addEventListener("submit", (event) => {
  event.preventDefault();
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  if (username && password) {
    alert(`Welcome, ${username}!`);
    // Here, you would typically send this data to the server
    loginForm.reset();
  } else {
    alert("Please fill in all fields.");
  }
});

// Handle forgot password click
forgotPasswordLink.addEventListener("click", (event) => {
  event.preventDefault();
  alert(
    "Forgot Password functionality will redirect to the reset password page."
  );
});
