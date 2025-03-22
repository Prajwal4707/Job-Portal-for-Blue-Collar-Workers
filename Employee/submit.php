<?php
include 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $email = htmlspecialchars(trim($_POST['email']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $country = htmlspecialchars(trim($_POST['country']));
    $state = htmlspecialchars(trim($_POST['state']));
    $district = htmlspecialchars(trim($_POST['district']));
    $experience = htmlspecialchars(trim($_POST['experience']));
    $job_role = htmlspecialchars(trim($_POST['job-role']));  // Corrected variable name
    $job_type = htmlspecialchars(trim($_POST['job-type']));

    // 🔹 Fetch job_id from jobs table based on job role
    $job_id = null;
    $job_query = "SELECT id FROM jobs WHERE title = ? LIMIT 1";  // Adjust column name if needed
    $stmt = $conn->prepare($job_query);
    $stmt->bind_param("s", $job_role);
    $stmt->execute();
    $stmt->bind_result($job_id);
    $stmt->fetch();
    $stmt->close();

    if (!$job_id) {
        die("No matching job found for the selected role. $job_role");
    }

    // File Upload Handling
    $upload_dir = "../Employer/uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    function uploadFile($file, $upload_dir, $allowed_types, $max_size)
    {
        $filename = basename($file['name']);
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $new_filename = time() . '_' . $filename;
        $target_path = $upload_dir . $new_filename;

        if (!in_array($file_ext, $allowed_types) || $file['size'] > $max_size) {
            return false;
        }
        return move_uploaded_file($file['tmp_name'], $target_path) ? $new_filename : false;
    }

    $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];
    $max_file_size = 2 * 1024 * 1024; // 2MB

    $photo = uploadFile($_FILES['photo'], $upload_dir, $allowed_types, $max_file_size);
    $id_proof = uploadFile($_FILES['id-proof'], $upload_dir, $allowed_types, $max_file_size);
    $resume = uploadFile($_FILES['resume'], $upload_dir, ['pdf', 'doc', 'docx'], $max_file_size);

    if (!$photo) {
        die("Invalid file type or photo size too large.");
    } elseif (!$id_proof) {
        die("Invalid file type or id_proof size too large.");
    } elseif (!$resume) {
        die("Invalid file type or resume size too large.");
    }

    // ✅ Insert Data Using Prepared Statement
    $sql = "INSERT INTO applications (name, gender, dob, email, contact, country, state, district, experience, job_role, job_type, photo, id_proof, resume, job_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssi", $name, $gender, $dob, $email, $contact, $country, $state, $district, $experience, $job_role, $job_type, $photo, $id_proof, $resume, $job_id);

    if ($stmt->execute()) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
