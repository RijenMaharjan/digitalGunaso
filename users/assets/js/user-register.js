document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = {
      firstName: document.getElementById("firstName").value,
      middleName: document.getElementById("middleName").value,
      lastName: document.getElementById("lastName").value,
      dob: document.getElementById("dob").value,
      gender: document.getElementById("gender").value,
      address: document.getElementById("address").value,
      contact: document.getElementById("contact").value,
    };

    console.log("Form Submitted:", formData);
    alert("Registration successful!");
  });
