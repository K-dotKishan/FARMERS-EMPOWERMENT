<?php
session_start();

// Get cart count (should be 0 after successful order)
$cart_count = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - FarmEmpower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <a href="index.html" class="flex items-center space-x-3">
                    <div class="bg-white w-12 h-12 rounded-full flex items-center justify-center relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-green-600 rounded-full opacity-20"></div>
                        <i class="fas fa-leaf text-2xl text-green-600 transform -rotate-12"></i>
                        <i class="fas fa-seedling text-xl text-green-500 absolute -bottom-1 -right-1"></i>
                    </div>
                    <div class="flex flex-col">
                        <div class="text-2xl font-bold tracking-wide">FarmEmpower</div>
                        <div class="text-xs text-green-200">Growing Together</div>
                    </div>
                </a>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="index.html" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    <span id="nav-home">Home</span>
                </a>
                <a href="index.html#services" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    <span id="nav-services">Services</span>
                </a>
                <a href="index.html#about" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span id="nav-about">About</span>
                </a>
                <a href="index.html#contact" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-envelope mr-2"></i>
                    <span id="nav-contact">Contact</span>
                </a>
                <a href="cart.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span>Cart (<?php echo $cart_count; ?>)</span>
                </a>
                <div class="relative">
                    <button id="lang-selector" class="hover:text-green-200 transition duration-300 flex items-center">
                        <i class="fas fa-globe mr-2"></i>
                        <span id="current-lang">English</span>
                    </button>
                    <div id="lang-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-green-100" data-lang="en">English</a>
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-green-100" data-lang="hi">हिंदी</a>
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-green-100" data-lang="pa">ਪੰਜਾਬੀ</a>
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-green-100" data-lang="ta">தமிழ்</a>
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-green-100" data-lang="te">తెలుగు</a>
                    </div>
                </div>
            </div>
            <button class="md:hidden" id="menu-btn">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="bg-green-600 text-white py-4 hidden md:hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col space-y-4">
                <a href="index.html" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    <span id="mobile-nav-home">Home</span>
                </a>
                <a href="index.html#services" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    <span id="mobile-nav-services">Services</span>
                </a>
                <a href="index.html#about" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span id="mobile-nav-about">About</span>
                </a>
                <a href="index.html#contact" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-envelope mr-2"></i>
                    <span id="mobile-nav-contact">Contact</span>
                </a>
                <a href="cart.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span>Cart (<?php echo $cart_count; ?>)</span>
                </a>
                <div class="pt-2 border-t border-green-500">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-globe mr-2"></i>
                        <span>Language</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button class="lang-option bg-green-700 py-2 px-3 rounded hover:bg-green-800 transition duration-300" data-lang="en">English</button>
                        <button class="lang-option bg-green-700 py-2 px-3 rounded hover:bg-green-800 transition duration-300" data-lang="hi">हिंदी</button>
                        <button class="lang-option bg-green-700 py-2 px-3 rounded hover:bg-green-800 transition duration-300" data-lang="pa">ਪੰਜਾਬੀ</button>
                        <button class="lang-option bg-green-700 py-2 px-3 rounded hover:bg-green-800 transition duration-300" data-lang="ta">தமிழ்</button>
                        <button class="lang-option bg-green-700 py-2 px-3 rounded hover:bg-green-800 transition duration-300" data-lang="te">తెలుగు</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-check text-4xl text-green-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold mb-4">Order Placed Successfully!</h1>
                    <p class="text-gray-600 mb-8">Thank you for your purchase. Your order has been received and is being processed.</p>
                    <div class="space-y-4">
                        <a href="online-marketplace.php" class="inline-block bg-green-600 text-white py-3 px-6 rounded-lg font-bold hover:bg-green-700 transition duration-300">
                            Continue Shopping
                        </a>
                        <div class="text-sm text-gray-500">
                            <p>A confirmation email has been sent to your registered email address.</p>
                            <p>Order tracking details will be available once your order is shipped.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 FarmEmpower. <span id="footer-rights">All rights reserved.</span></p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html> 