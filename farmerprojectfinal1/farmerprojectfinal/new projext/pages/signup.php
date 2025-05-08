<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = "localhost";
$dbname = "farmempower";
$dbuser = "root";
$dbpass = "";


$mysqli = @new mysqli($host, $dbuser, $dbpass);
if ($mysqli->connect_error) {
    die("MySQL server is not running. Please start your MySQL server and try again.");
}
$mysqli->close();

// Connect to the database
try {
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = test_input($_POST['fullname']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $confirm_password = test_input($_POST['confirm_password']);

    // Validate input
    $errors = [];
    
    if (empty($fullname)) {
        $errors['fullname'] = "Full name is required";
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
        $errors['fullname'] = "Only letters and white space allowed in name";
    }
    
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long";
    }elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $password)) {
        $errors['password'] = "Password must contain at least one letter and one number";
    }
    
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    if (empty($errors)) {
        try {
            // Check if email already exists
            $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $check_email->bind_param("s", $email);
            $check_email->execute();
            $result = $check_email->get_result();
            
            if ($result->num_rows > 0) {
                $errors['email'] = "Email already exists. Please use a different email.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $fullname, $email, $hashed_password);

                if ($stmt->execute()) {
                    // Start session and store user data
                    session_start();
                    $_SESSION["user"] = [
                        "email" => $email,
                        "name" => $fullname
                    ];
                    
                    // Store user data in localStorage and redirect
                    echo "<script>
                        localStorage.setItem('isLoggedIn', 'true');
                        localStorage.setItem('userEmail', '" . htmlspecialchars($email) . "');
                        localStorage.setItem('userName', '" . htmlspecialchars($fullname) . "');
                        window.location.href = '../index.html';
                    </script>";
                    exit();
                } else {
                    throw new Exception($conn->error);
                }
            }
        } catch (Exception $e) {
            $errors['database'] = "Error: " . $e->getMessage();
        }
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sign Up - FarmEmpower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        /* Base Styles */
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
            background: linear-gradient(-45deg, 
                #f0fdf4 0%, 
                #dcfce7 25%, 
                #bbf7d0 50%, 
                #86efac 75%, 
                #4ade80 100%
            );
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated Background Elements */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.1;
            background-image: 
                radial-gradient(circle at 25px 25px, #4ade80 2%, transparent 0%),
                radial-gradient(circle at 75px 75px, #4ade80 2%, transparent 0%);
            background-size: 100px 100px;
            animation: patternMove 20s linear infinite;
        }

        @keyframes patternMove {
            0% { background-position: 0 0; }
            100% { background-position: 100px 100px; }
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            animation: float 6s ease-in-out infinite;
            z-index: -1;
        }

        .floating-element:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            background: linear-gradient(45deg, rgba(74, 222, 128, 0.2), rgba(34, 197, 94, 0.2));
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            background: linear-gradient(45deg, rgba(22, 163, 74, 0.2), rgba(21, 128, 61, 0.2));
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 50%;
            background: linear-gradient(45deg, rgba(22, 101, 52, 0.2), rgba(20, 83, 45, 0.2));
            animation-delay: 4s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(20px, 20px) rotate(180deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        /* Card Background */
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        /* Left Side Gradient */
        .left-side-gradient {
            background: linear-gradient(135deg, 
                rgba(34, 197, 94, 0.95) 0%, 
                rgba(22, 163, 74, 0.95) 100%
            );
            position: relative;
            overflow: hidden;
        }

        .left-side-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%
            );
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        .error-message {
            color: #ff4444;
            font-size: 0.9rem;
            margin-top: 5px;
            animation: shake 0.5s ease-in-out;
        }
        
        .floating-img {
            animation: floating 3s ease-in-out infinite;
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        /* Floating animation for the image */
        .floating-img:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        /* Form element animations */
        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 1rem;
        }
        
        .form-input:focus {
            transform: scale(1.02);
            box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.2);
            border-color: #4ade80;
        }
        
        /* Button hover effect */
        .btn-hover {
            transition: all 0.3s ease;
            transform: translateY(0);
            position: relative;
            overflow: hidden;
        }
        
        .btn-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Page load animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        /* Background animation */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(74, 222, 128, 0.1) 0%, rgba(34, 197, 94, 0.1) 100%);
            animation: bgPulse 8s ease-in-out infinite;
        }
        
        @keyframes bgPulse {
            0% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 0.5; }
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
            border-radius: 20px;
            overflow: hidden;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Feature icon animations */
        .feature-icon {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            padding: 15px;
            border-radius: 15px;
            color: white;
        }
        
        .feature-icon:hover {
            transform: rotate(10deg) scale(1.1);
        }
        
        /* Shake animation for errors */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        /* Success message animation */
        .success-message {
            animation: slideIn 0.5s ease-out forwards;
        }
        
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="bg-pattern"></div>
    
    <!-- Floating Elements -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>

    <div class="card-bg max-w-6xl w-full shadow-xl rounded-3xl overflow-hidden flex flex-col md:flex-row animate-fade-in card-hover">
        <!-- Left Side -->
        <div class="left-side-gradient md:w-1/2 text-white p-12 flex flex-col justify-center items-center relative overflow-hidden">
            <!-- Animated background elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-10 left-10 w-24 h-24 rounded-full bg-white animate-pulse" style="animation-delay: 0.2s;"></div>
                <div class="absolute bottom-20 right-20 w-20 h-20 rounded-full bg-white animate-pulse" style="animation-delay: 0.4s;"></div>
                <div class="absolute top-1/3 right-1/4 w-16 h-16 rounded-full bg-white animate-pulse" style="animation-delay: 0.6s;"></div>
            </div>
            
            <div class="relative z-10 text-center">
                <img src="../marketimg/login.jpg" alt="Signup" class="rounded-2xl mb-8 shadow-2xl floating-img" />
                <h2 class="text-3xl font-bold mb-4 animate-delay-1">Join FarmEmpower</h2>
                <p class="mb-8 text-center text-lg animate-delay-2">Empowering Farmers with Knowledge</p>
                <div class="flex space-x-8 text-center animate-delay-3">
                    <div class="feature-icon">
                        <i class="fas fa-tractor text-3xl"></i>
                        <p class="mt-2 text-sm font-medium">Farming</p>
                    </div>
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar text-3xl"></i>
                        <p class="mt-2 text-sm font-medium">Analytics</p>
                    </div>
                    <div class="feature-icon">
                        <i class="fas fa-leaf text-3xl"></i>
                        <p class="mt-2 text-sm font-medium">Green</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="md:w-1/2 p-12 animate-fade-in animate-delay-1">
            <h2 class="text-4xl font-bold text-green-700 text-center mb-8">Create Account</h2>
            <?php if (!empty($errors['database'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $errors['database']; ?></span>
                </div>
            <?php endif; ?>
            <form method="POST" class="space-y-6" onsubmit="return handleSignup(event)">
                <div class="animate-delay-2">
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Full Name</label>
                    <input type="text" name="fullname" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required class="w-full form-input <?php echo isset($errors['fullname']) ? 'border-red-500' : ''; ?>">
                    <?php if (isset($errors['fullname'])): ?>
                        <div class="error-message"><?php echo $errors['fullname']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="animate-delay-3">
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Email</label>
                    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required class="w-full form-input <?php echo isset($errors['email']) ? 'border-red-500' : ''; ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="error-message"><?php echo $errors['email']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="animate-delay-4">
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Password</label>
                    <input type="password" name="password" required class="w-full form-input <?php echo isset($errors['password']) ? 'border-red-500' : ''; ?>">
                    <?php if (isset($errors['password'])): ?>
                        <div class="error-message"><?php echo $errors['password']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="animate-delay-5">
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Confirm Password</label>
                    <input type="password" name="confirm_password" required class="w-full form-input <?php echo isset($errors['confirm_password']) ? 'border-red-500' : ''; ?>">
                    <?php if (isset($errors['confirm_password'])): ?>
                        <div class="error-message"><?php echo $errors['confirm_password']; ?></div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 transition duration-300 btn-hover animate-delay-6 text-lg font-semibold">
                    Sign Up
                </button>
            </form>

            <div class="mt-8 text-center space-y-4 animate-delay-7">
                <p class="text-gray-600 text-lg">
                    Already have an account?
                </p>
                <a href="login.php" class="inline-block w-full bg-white text-green-600 py-3 rounded-xl border-2 border-green-600 hover:bg-green-50 transition duration-300 btn-hover text-lg font-semibold">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login to Your Account
                </a>
            </div>
        </div>
    </div>

    <script>
        function handleSignup(event) {
            // Form validation will be handled by the browser's native validation
            // and our PHP backend validation
            return true;
        }
        
        // Add ripple effect to buttons
        document.querySelectorAll('button, a').forEach(button => {
            button.addEventListener('click', function(e) {
                let x = e.clientX - e.target.getBoundingClientRect().left;
                let y = e.clientY - e.target.getBoundingClientRect().top;
                
                let ripple = document.createElement('span');
                ripple.className = 'ripple-effect';
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        });
    </script>
    
    <style>
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</body>
</html>