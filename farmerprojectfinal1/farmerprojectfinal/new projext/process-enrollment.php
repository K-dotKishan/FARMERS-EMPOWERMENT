<?php
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $program_name = $_POST['program_name'] ?? '';
    $program_price = $_POST['program_price'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $location = $_POST['location'] ?? '';
    $experience = $_POST['experience'] ?? '';
    
    // Validate required fields
    $errors = [];
    
    if (empty($program_name)) {
        $errors[] = "Program name is required";
    }
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    
    if (empty($location)) {
        $errors[] = "Location is required";
    }
    
    if (empty($experience)) {
        $errors[] = "Experience level is required";
    }
    
    // If there are no errors, process the enrollment
    if (empty($errors)) {
        // In a real application, you would:
        // 1. Save the enrollment to a database
        // 2. Send confirmation emails
        // 3. Process payment
        
        // For this example, we'll just store the enrollment in the session
        if (!isset($_SESSION['enrollments'])) {
            $_SESSION['enrollments'] = [];
        }
        
        $_SESSION['enrollments'][] = [
            'program_name' => $program_name,
            'program_price' => $program_price,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'location' => $location,
            'experience' => $experience,
            'date' => date('Y-m-d H:i:s')
        ];
        
        // Redirect to a success page
        header("Location: enrollment-success.php?program=" . urlencode($program_name));
        exit;
    }
}

// If we get here, there were errors or the form wasn't submitted
// Redirect back to the training programs page with errors
if (!empty($errors)) {
    $_SESSION['enrollment_errors'] = $errors;
    $_SESSION['enrollment_form_data'] = $_POST;
}

header("Location: training-programs.php");
exit;
?> 