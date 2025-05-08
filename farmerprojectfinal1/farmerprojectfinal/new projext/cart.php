<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding items to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    
    // Add item to cart
    $_SESSION['cart'][] = array(
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'image' => $product_image
    );
    
    // Redirect back to marketplace
    header('Location: online-marketplace.php');
    exit();
}

// Handle removing items from cart
if (isset($_GET['remove']) && isset($_GET['index'])) {
    $index = $_GET['index'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
    }
    header('Location: cart.php');
    exit();
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'];
}

// Get cart count
$cart_count = count($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - FarmEmpower</title>
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

    <!-- Cart Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
            
            <?php if (empty($_SESSION['cart'])): ?>
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-shopping-cart text-6xl text-gray-400 mb-4"></i>
                    <h2 class="text-2xl font-bold mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-6">Browse our products and add items to your cart</p>
                    <a href="online-marketplace.php" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition duration-300 inline-block">
                        Continue Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="space-y-6">
                                    <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                                        <div class="flex items-center space-x-4">
                                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-24 h-24 object-cover rounded">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold"><?php echo $item['name']; ?></h3>
                                                <p class="text-green-600 font-bold">₹<?php echo number_format($item['price']); ?></p>
                                            </div>
                                            <a href="cart.php?remove=1&index=<?php echo $index; ?>" class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                        <?php if ($index < count($_SESSION['cart']) - 1): ?>
                                            <hr class="border-gray-200">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-bold">₹<?php echo number_format($total); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-bold">Free</span>
                                </div>
                                <hr class="border-gray-200">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold">Total</span>
                                    <span class="text-lg font-bold text-green-600">₹<?php echo number_format($total); ?></span>
                                </div>
                                <a href="checkout.php" class="block w-full bg-green-600 text-white text-center px-6 py-3 rounded-full hover:bg-green-700 transition duration-300">
                                    Proceed to Checkout
                                </a>
                                <a href="online-marketplace.php" class="block text-center text-green-600 hover:text-green-700">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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