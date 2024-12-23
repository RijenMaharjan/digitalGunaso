document.getElementById("admin-username").textContent = "AdminUser123";

const navLinks = document.querySelectorAll(".sidebar nav ul li a");
const dashboardLink = document.getElementById("dashboard-link");
const reportsLink = document.getElementById("reports-link");
const dashboardSection = document.getElementById("dashboard-section");
const reportsSection = document.getElementById("reports-section");
const departmentDropdown = document.getElementById("department-dropdown");
const complaintList = document.getElementById("complaint-list");

navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    // Remove 'active' class from all links
    navLinks.forEach((nav) => nav.classList.remove("active"));

    // Add 'active' class to the clicked link
    link.classList.add("active");
  });
});

// Show the Reports section
reportsLink.addEventListener("click", () => {
  dashboardSection.style.display = "none";
  reportsSection.style.display = "block";
  loadComplaints(departmentDropdown.value);
});

// Show the Dashboard section
dashboardLink.addEventListener("click", () => {
  dashboardSection.style.display = "block";
  reportsSection.style.display = "none";
});

// Load complaints based on selected department
departmentDropdown.addEventListener("change", (e) => {
  loadComplaints(e.target.value);
});

// Function to load complaints for a specific department
function loadComplaints(department) {
  let complaints = [];
  if (department === "electricity") {
    complaints = [
      "Electricity outage in sector 4",
      "Voltage fluctuation in Kaldhara",
      "Voltage fluctuation in satghumti",
      "Voltage fluctuation in Balaju",
    ];
  } else if (department === "water") {
    complaints = [
      "Water leakage near Park Street",
      "Low water pressure in Khusibu",
      "Low water pressure in Falful Chok",
      "Low water pressure in Geetajali",
    ];
  } else if (department === "garbage") {
    complaints = [
      "Garbage piling up in Shorkhutte",
      "Garbage truck missed Khusibu",
      "Garbage truck missed Oaknajol",
    ];
  }

  complaintList.innerHTML = "";
  complaints.forEach((complaint) => {
    const p = document.createElement("p");
    p.textContent = complaint;
    complaintList.appendChild(p);
  });
}
document.addEventListener("DOMContentLoaded", () => {
  const complaintDepartment = document.getElementById("complaint-department");
  const complaintCategory = document.getElementById("complaint-category");

  // Function to update categories based on department selection
  function updateCategoryOptions() {
    const selectedDepartment = complaintDepartment.value;

    // Clear the existing options
    complaintCategory.innerHTML = "";

    let categories = [];

    // Determine categories based on selected department
    if (selectedDepartment === "electricity") {
      categories = [
        "Transmitter Burst",
        "Cut Off Wires",
        "Pole Fall",
        "Half-cut Electricity",
      ];
    } else if (selectedDepartment === "water") {
      categories = ["Dirty Water", "No Scheduled Time Water", "Pipe Burst"];
    } else if (selectedDepartment === "garbage") {
      categories = ["No Scheduled Time", "Overload of Garbage"];
    }

    // Create new options for the category dropdown
    categories.forEach((category) => {
      const option = document.createElement("option");
      option.value = category.toLowerCase().replace(" ", "-");
      option.textContent = category;
      complaintCategory.appendChild(option);
    });
  }

  // Update category options when the department is changed
  complaintDepartment.addEventListener("change", updateCategoryOptions);

  // Initialize category options based on the initial department selection
  updateCategoryOptions();
});

// Handle navigation clicks to toggle sections
document.getElementById("dashboard-link").addEventListener("click", () => {
  document.getElementById("dashboard-section").style.display = "block";
  document.getElementById("reports-section").style.display = "none";
  document.getElementById("user-complaints-section").style.display = "none";
  document.getElementById("dashboard-link").classList.add("active");
  document.getElementById("reports-link").classList.remove("active");
  document.getElementById("complaints-link").classList.remove("active");
});

document.getElementById("reports-link").addEventListener("click", () => {
  document.getElementById("dashboard-section").style.display = "none";
  document.getElementById("reports-section").style.display = "block";
  document.getElementById("user-complaints-section").style.display = "none";
  document.getElementById("reports-link").classList.add("active");
  document.getElementById("dashboard-link").classList.remove("active");
  document.getElementById("complaints-link").classList.remove("active");
});

document.getElementById("complaints-link").addEventListener("click", () => {
  document.getElementById("dashboard-section").style.display = "none";
  document.getElementById("reports-section").style.display = "none";
  document.getElementById("user-complaints-section").style.display = "block";
  document.getElementById("complaints-link").classList.add("active");
  document.getElementById("dashboard-link").classList.remove("active");
  document.getElementById("reports-link").classList.remove("active");
});

document.addEventListener("DOMContentLoaded", () => {
  const statusButtons = document.querySelectorAll(".status-button");

  // Add event listeners for status buttons
  statusButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      // Remove active class from all buttons
      statusButtons.forEach((btn) => btn.classList.remove("active"));

      // Add active class to the clicked button
      e.target.classList.add("active");

      // Get the status value
      const status = e.target.dataset.status;
      console.log(`Status changed to: ${status}`);
      // You can add more functionality here (e.g., save the status, display an alert, etc.)
    });
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const categoryNavLink = document.getElementById("category-link");
  const categoryContentSection = document.getElementById("category-section");
  const dashboardContentSection = document.getElementById("dashboard-section");
  const reportsContentSection = document.getElementById("reports-section");
  const complaintsContentSection = document.getElementById(
    "user-complaints-section"
  );
  const departmentListContainer = document.getElementById("departments");
  const newDepartmentInputField = document.getElementById("new-department");
  const addDepartmentButtonElement = document.getElementById("add-department");

  const departmentArray = ["Electricity", "Water", "Garbage"];

  // Populate the initial list of departments
  function populateDepartmentList() {
    departmentListContainer.innerHTML = "";
    departmentArray.forEach((department, index) => {
      const listItem = document.createElement("li");
      listItem.innerHTML = `
        ${department} 
        <button class="edit-department-btn" data-index="${index}">Edit</button>
        <button class="delete-department-btn" data-index="${index}">Delete</button>`;
      departmentListContainer.appendChild(listItem);
    });
  }

  // Event listener to add a new department
  addDepartmentButtonElement.addEventListener("click", () => {
    const newDepartmentName = newDepartmentInputField.value.trim();
    if (newDepartmentName) {
      departmentArray.push(newDepartmentName);
      newDepartmentInputField.value = "";
      populateDepartmentList();
    }
  });

  // Event listener for edit and delete actions
  departmentListContainer.addEventListener("click", (event) => {
    const index = event.target.dataset.index;

    if (event.target.classList.contains("delete-department-btn")) {
      departmentArray.splice(index, 1);
      populateDepartmentList();
    } else if (event.target.classList.contains("edit-department-btn")) {
      const updatedName = prompt(
        "Enter the new department name:",
        departmentArray[index]
      );
      if (updatedName) {
        departmentArray[index] = updatedName.trim();
        populateDepartmentList();
      }
    }
  });

  // Event listener for navigation to the Category section
  categoryNavLink.addEventListener("click", () => {
    dashboardContentSection.style.display = "none";
    reportsContentSection.style.display = "none";
    complaintsContentSection.style.display = "none";
    categoryContentSection.style.display = "block";
  });

  // Initial rendering of the department list
  populateDepartmentList();
});

document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll(".sidebar nav ul li a");
  const dashboardSection = document.getElementById("dashboard-section");
  const reportsSection = document.getElementById("reports-section");
  const userComplaintsSection = document.getElementById(
    "user-complaints-section"
  );
  const categorySection = document.getElementById("category-section");

  // Helper function to hide all sections
  function hideAllSections() {
    dashboardSection.style.display = "none";
    reportsSection.style.display = "none";
    userComplaintsSection.style.display = "none";
    categorySection.style.display = "none";
  }

  // Add event listeners for navigation links
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      // Remove 'active' class from all links
      navLinks.forEach((nav) => nav.classList.remove("active"));

      // Add 'active' class to the clicked link
      link.classList.add("active");

      // Show the relevant section based on the link clicked
      hideAllSections(); // Ensure all sections are hidden initially
      if (link.id === "dashboard-link") {
        dashboardSection.style.display = "block";
      } else if (link.id === "reports-link") {
        reportsSection.style.display = "block";
      } else if (link.id === "complaints-link") {
        userComplaintsSection.style.display = "block";
      } else if (link.id === "category-link") {
        categorySection.style.display = "block";
      }
    });
  });

  // Initialize: Show the dashboard section by default
  hideAllSections();
  dashboardSection.style.display = "block";
  document.getElementById("dashboard-link").classList.add("active");
});
