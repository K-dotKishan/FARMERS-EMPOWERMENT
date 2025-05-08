<?php
// Enable error reporting for debugging (we can remove this later)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Database configuration
$host = "localhost";
$dbname = "farmempower";
$dbuser = "root";
$dbpass = "";

$email = $password = "";
$emailErr = $passwordErr = "";
$loginError = "";

// Connect to the database
try {
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    $loginError = "Unable to connect to the database. Please try again later.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$loginError) {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($emailErr) && empty($passwordErr)) {
        try {
            $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
            if (!$stmt) {
                throw new Exception("An error occurred");
            }
            
            $stmt->bind_param("s", $email);
            if (!$stmt->execute()) {
                throw new Exception("An error occurred");
            }
            
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION["user"] = [
                        "id" => $user['id'],
                        "email" => $email,
                        "name" => $user['full_name']
                    ];
                    
                    // Get the correct path to index.html
                    $projectRoot = dirname(dirname($_SERVER['PHP_SELF']));
                    $indexPath = $projectRoot . '/index.html';
                    
                    // Output the success message and redirect
                    header('Content-Type: text/html');
                    echo "<!DOCTYPE html>
                    <html>
                    <head>
                        <title>Login Successful</title>
                        <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet' />
                    </head>
                    <body>
                        <script>
                            localStorage.setItem('isLoggedIn', 'true');
                            localStorage.setItem('userEmail', '" . htmlspecialchars($email) . "');
                            localStorage.setItem('userName', '" . htmlspecialchars($user['full_name']) . "');
                            
                            const successDiv = document.createElement('div');
                            successDiv.style.cssText = `
                                position: fixed;
                                top: 20px;
                                right: 20px;
                                background: #4CAF50;
                                color: white;
                                padding: 15px 25px;
                                border-radius: 8px;
                                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                                font-family: Arial, sans-serif;
                                display: flex;
                                align-items: center;
                                gap: 10px;
                                z-index: 1000;
                                animation: slideIn 0.5s ease-out;
                            `;
                            
                            successDiv.innerHTML = `
                                <i class='fas fa-check-circle' style='font-size: 20px;'></i>
                                <span>Login successful! Redirecting...</span>
                            `;
                            
                            document.body.appendChild(successDiv);
                            
                            setTimeout(() => {
                                window.location.href = '" . $indexPath . "';
                            }, 1500);
                        </script>
                    </body>
                    </html>";
                    exit();
                } else {
                    $loginError = "Invalid email or password";
                }
            } else {
                $loginError = "Invalid email or password";
            }
        } catch (Exception $e) {
            $loginError = "An error occurred. Please try again later.";
        }
    }
}

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - Krishi Sakha</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        .login-success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
            animation: slideIn 0.5s ease-out;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="bg-green-50 min-h-screen">

<!-- Navbar -->
<nav class="w-full bg-white shadow-md px-6 py-4 flex items-center justify-between fixed top-0 left-0 z-50">
    
    <div class="flex items-center space-x-3">
        <!-- <img src="../marketimg/farmerempower.png" alt="FarmerEmpower Logo" class="w-12 h-12" /> -->
        <span class="text-2xl font-bold text-green-700">FarmEmpower</span>
    </div>
    
    <div class="hidden md:flex space-x-8 items-center">
        <a href="../index.html" class="text-gray-700 hover:text-green-700 transition">Home</a>
        <a href="#" class="text-gray-700 hover:text-green-700 transition">Services</a>
        <a href="#" class="text-gray-700 hover:text-green-700 transition">About</a>
        <a href="#" class="text-gray-700 hover:text-green-700 transition">Contact</a>
        <a href="login.php" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition">Login</a>
    </div>
</nav>

<!-- Spacer to push content below fixed navbar -->
<div class="h-24"></div>

<!-- Main Content -->
<div class="bg-white max-w-5xl w-full mx-auto shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row">
    <!-- Left Side -->
    <div class="md:w-1/2 bg-green-700 text-white p-10 flex flex-col justify-center items-center">
        <img src="../marketimg/login.jpg" alt="Dashboard Image" class="rounded-xl mb-6 shadow-lg" />
        <h2 class="text-2xl font-semibold mb-2">Welcome Back</h2>
        <p class="mb-6 text-center">Access your personalized farming dashboard</p>
        <div class="flex space-x-6 text-center">
            <div>
                <i class="fas fa-seedling text-3xl"></i>
                <p class="mt-1 text-sm">Crops</p>
            </div>
            <div>
                <i class="fas fa-chart-line text-3xl"></i>
                <p class="mt-1 text-sm">Market</p>
            </div>
            <div>
                <i class="fas fa-book text-3xl"></i>
                <p class="mt-1 text-sm">Resources</p>
            </div>
        </div>
    </div>

    <!-- Right Side -->
    <div class="md:w-1/2 p-10">
        <h2 class="text-3xl font-bold text-green-700 text-center mb-6">Account Login</h2>
        <p class="text-center text-gray-600 mb-6">Enter your details to continue</p>

        <?php if (!empty($loginError)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo $loginError; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-5">
            <div>
                <label for="email" class="block text-gray-700 mb-1 font-medium">Email Address</label>
                <input type="email" name="email" id="email" value="<?php echo $email; ?>"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-green-500 <?php echo $emailErr ? 'border-red-500' : 'border-gray-300'; ?>" required>
                <?php if (!empty($emailErr)): ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo $emailErr; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="password" class="block text-gray-700 mb-1 font-medium">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-green-500 <?php echo $passwordErr ? 'border-red-500' : 'border-gray-300'; ?>" required>
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                <?php if (!empty($passwordErr)): ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo $passwordErr; ?></p>
                <?php endif; ?>
            </div>

            <div class="flex justify-between items-center text-sm">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox h-4 w-4 text-green-600" name="remember">
                    <span class="text-gray-700">Remember me</span>
                </label>
                <a href="#" class="text-green-600 hover:underline">Forgot password?</a>
            </div>

            <button type="submit"
                    class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 transition duration-300">
                Sign In
            </button>
        </form>

        <div class="mt-6 text-center text-gray-600">Or continue with</div>
        <div class="flex justify-center gap-4 mt-4">
            <button class="flex items-center border px-4 py-2 rounded-lg hover:bg-gray-100">
                <i class="fab fa-google text-red-500 mr-2"></i> Google
            </button>
            <button class="flex items-center border px-4 py-2 rounded-lg hover:bg-gray-100">
                <i class="fab fa-facebook text-blue-600 mr-2"></i> Facebook
            </button>
        </div>

        <p class="mt-6 text-center text-sm text-gray-600">
            Don't have an account?
            <a href="signup.php" class="text-green-600 hover:underline font-semibold">Sign up</a>
        </p>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const icon = document.getElementById("toggleIcon");
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
</body>
</html>
