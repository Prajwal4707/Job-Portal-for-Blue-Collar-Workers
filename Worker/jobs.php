<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blue Collar Job Portal</title>
  <link rel="stylesheet" href="jobs.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="main.css" />
  <link rel="stylesheet" href="backtotop.css" />
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-sm">
      <div class="container-fluid">
        <a class="navbar-brand fs-3 font-sans-serif" href="main.html"><img src="./images/HomeCare_logo.JPG" alt="HomeCare_Experts" /></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="nav-content"></ul>
        <a class="nav-link fs-5 fst-italic" href="main.html">Home</a>
        <a class="nav-link fs-5 fst-italic" href="jobs.html">Jobs</a>
        <a class="nav-link fs-5 fst-italic" id="scrollButton">About</a>
        <a class="nav-link fs-5 fst-italic" id="scrollButton1">Contact</a>
        <a class="nav-link fs-5 fst-italic" href="emp_login.html"><i class="bx bxs-user">Login/Signup</i></a>
      </div>
    </nav>
  </header>
  <div class="container" id="job-list">
    <?php
    $sql = "SELECT jobs.id, jobs.title, jobs.location, jobs.salary, employers.company 
        FROM jobs 
        JOIN employers ON jobs.employer_id = employers.id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='job-card'>
                <h3>{$row['title']}</h3>
                <p>Company: {$row['company']}</p>
                <p>Location: {$row['location']}</p>
                <p>Salary: {$row['salary']}</p>
                <a href='../Employee/job_seeker.html?job_id={$row['id']}' class='apply-button'>Apply Now</a>
            </div>";
      }
    } else {
      echo "<p>No jobs found.</p>";
    }

    $conn->close();
    ?>
  </div>

  <section id="aboutSection" class="p-4">
    <h2>About Us</h2>
    <p>
      HomeCare Experts is a dedicated platform connecting skilled blue-collar
      workers with job opportunities in various fields, including plumbing,
      electrical work, painting, carpentry, and more. We aim to bridge the gap
      between skilled workers and employers looking for reliable
      professionals.
    </p>
    <p>
      Our platform ensures seamless job postings, easy applications, and
      direct communication between employers and job seekers.
    </p>
  </section>

  <footer class="p-4 bg-dark text-white">
    <div id="contactSection">
      <h4>Contact Us</h4>
      <h5>Aradhya Engineerings</h5>
      <p>
        Plot no.4, Scheme no.17, Buda colony, Angol, Belagavi. <br />
        Phone: +91-9880908143 <br />
        Email: support@homecareexperts.com
      </p>
    </div>
    <button id="back-to-top" onclick="topFunction()">&#10548;</button>
    <p class="text-center">
      &copy; 2025 HomeCare Experts. All rights reserved.
    </p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="main.js"></script>
  <script src="backtotop.js"></script>
</body>

</html>