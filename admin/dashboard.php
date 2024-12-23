<?php
session_start();
include('include/config.php');

// Fetch complaint counts for each department
$electricityCount = mysqli_fetch_array(mysqli_query($bd, "SELECT COUNT(*) AS total FROM tblcomplaints WHERE category = '3'"))['total'];
$waterCount = mysqli_fetch_array(mysqli_query($bd, "SELECT COUNT(*) AS total FROM tblcomplaints WHERE category = '4'"))['total'];
$garbageCount = mysqli_fetch_array(mysqli_query($bd, "SELECT COUNT(*) AS total FROM tblcomplaints WHERE category = '5'"))['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
  <link type="text/css" href="css/theme.css" rel="stylesheet">
  <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
  <link rel="stylesheet" href="assets/css/admin-dashboard.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Add Chart.js CDN -->
</head>

<body>

  <?php include("include/sidebar.php"); ?>
  <div class="container">
    <!-- <aside> -->
    <!-- <div class="user-info">
        <p>Admin: <span id="admin-username">example</span></p>
      </div>
      <nav>
        <ul>
          <li>
            <a href="#" class="active" id="dashboard-link">Dashboard</a>
          </li>
          <li><a href="#" id="reports-link">Reports</a></li>
          <li><a href="#" id="complaints-link">User Complaints</a></li>
          <li><a href="#" id="category-link">Category</a></li>
        </ul>
      </nav> -->
    <!-- </aside> -->

    <main id="main-content">
      <?php include("include/header.php"); ?>
      <!-- Dashboard Section -->
      <section class="dashboard" id="dashboard-section">
        <div class="dashboard-box">
          <h3>Electricity</h3>
          <p>Total Complaints: <?php echo $electricityCount; ?></p>
        </div>
        <div class="dashboard-box">
          <h3>Water</h3>
          <p>Total Complaints: <?php echo $waterCount; ?></p>
        </div>
        <div class="dashboard-box">
          <h3>Garbage</h3>
          <p>Total Complaints: <?php echo $garbageCount; ?></p>
        </div>
      </section>

      <!-- Charts Section -->
      <section class="charts" style="margin-top: 30px;">
        <!-- <h2>Complaint Distribution</h2> -->
        <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
          <!-- Pie Chart -->
          <div style="flex: 1; max-width: 35%; text-align: center;">
            <canvas id="pieChart" style="max-width: 100%; width: 300px; height: 300px;"></canvas>
          </div>
          <!-- Bar Chart -->
          <div style="flex: 1; max-width: 50%; text-align: center;">
            <canvas id="barChart"></canvas>
          </div>
        </div>
      </section>
      <!-- Reports Section -->
      <!-- <section class="reports" id="reports-section" style="display: none">
        <h2>Reports by Department</h2>
        <label for="department-dropdown">Choose Department: </label>
        <select id="department-dropdown">
          <option value="electricity">Electricity</option>
          <option value="water">Water</option>
          <option value="garbage">Garbage</option>
        </select>

        <div id="complaint-list" class="complaint-list">
        </div>
      </section> -->

      <!-- User Complaints Section -->
      <!-- <section
        class="user-complaints"
        id="user-complaints-section"
        style="display: none">
        <h2>User Complaints</h2>
        <div id="complaints-detail">
          <label for="complaint-department">Department:</label>
          <select id="complaint-department">
            <option value="electricity">Electricity</option>
            <option value="water">Water</option>
            <option value="garbage">Garbage</option>
          </select>

          <label for="complaint-category">Category:</label>
          <select id="complaint-category">
          </select>

          <label for="complaint-details">Complaint Details:</label>
          <textarea
            id="complaint-details"
            placeholder="Enter complaint details"></textarea>

          <label for="complaint-status">Status:</label>
          <div id="complaint-status">
            <button
              class="status-button"
              id="not-done"
              data-status="not-done">
              Not Done
            </button>
            <button
              class="status-button"
              id="in-progress"
              data-status="in-progress">
              In Progress
            </button>
            <button
              class="status-button"
              id="completed"
              data-status="completed">
              Completed
            </button>
          </div>
        </div>
      </section> -->

      <!-- <section class="category" id="category-section" style="display: none">
        <h2>Manage Departments</h2>
        <div class="department-management">
          <ul id="departments">
          </ul>
          <div class="add-department">
            <input
              type="text"
              id="new-department"
              placeholder="New Department" />
            <button id="add-department">Add</button>
          </div>
        </div>
      </section> -->
    </main>
  </div>

  <script>
    // Pass PHP data to JavaScript
    const complaintData = {
      electricity: <?php echo $electricityCount; ?>,
      water: <?php echo $waterCount; ?>,
      garbage: <?php echo $garbageCount; ?>
    };

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: ['Electricity', 'Water', 'Garbage'],
        datasets: [{
          label: 'Complaints',
          data: [complaintData.electricity, complaintData.water, complaintData.garbage],
          backgroundColor: ['#FFCE56', '#36A2EB', '#2e7d32'],
          hoverOffset: 4
        }]
      }
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Electricity', 'Water', 'Garbage'],
        datasets: [{
          label: 'Complaints',
          data: [complaintData.electricity, complaintData.water, complaintData.garbage],
          backgroundColor: ['#FFCE56', '#36A2EB', '#2e7d32']
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
  <script src="assets/js/admin-dashboard.js"></script>
  <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
  <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
  <script src="scripts/datatables/jquery.dataTables.js"></script>
  <script>
    $(document).ready(function() {
      $('.datatable-1').dataTable();
      $('.dataTables_paginate').addClass("btn-group datatable-pagination");
      $('.dataTables_paginate > a').wrapInner('<span />');
      $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
      $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
    });
  </script>
</body>

</html>