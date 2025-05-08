<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Get cart count
$cart_count = count($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agricultural Marketplace - FarmEmpower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .product-card {
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .category-tab.active {
            border-bottom: 3px solid #059669;
            color: #059669;
        }
    </style>
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
                <a href="../index.html#services" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    <span id="nav-services">Services</span>
                </a>
                <a href="../index.html#about" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span id="nav-about">About</span>
                </a>
                <a href="../index.html#contact" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-envelope mr-2"></i>
                    <span id="nav-contact">Contact</span>
                </a>
                <a href="online-marketplace.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-store mr-2"></i>
                    <span id="nav-market">Market Access</span>
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
                <a href="../index.html" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    <span id="mobile-nav-home">Home</span>
                </a>
                <a href="../index.html#services" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    <span id="mobile-nav-services">Services</span>
                </a>
                <a href="../index.html#about" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span id="mobile-nav-about">About</span>
                </a>
                <a href="../index.html#contact" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-envelope mr-2"></i>
                    <span id="mobile-nav-contact">Contact</span>
                </a>
                <a href="online-marketplace.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-store mr-2"></i>
                    <span id="mobile-nav-market">Market Access</span>
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

    <!-- Hero Section -->
    <section class="relative bg-green-700 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6" id="hero-title">Agricultural Marketplace</h1>
            <p class="text-xl mb-8" id="hero-subtitle">Quality agricultural tools, seeds, fertilizers, and equipment for modern farming</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <!-- Introduction -->
            <div class="max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold mb-6" id="intro-title">Your One-Stop Shop for Farming Needs</h2>
                <p class="text-gray-600 mb-4" id="intro-text">Browse our extensive collection of agricultural products and equipment. From high-quality seeds to advanced farming machinery, we provide everything you need for successful farming operations.</p>
            </div>

            <!-- Category Tabs -->
            <div class="flex flex-wrap justify-center mb-12 border-b">
                <button class="category-tab active px-6 py-3 text-lg font-medium" data-category="all">
                    <i class="fas fa-th-large mr-2"></i>All Products
                </button>
                <button class="category-tab px-6 py-3 text-lg font-medium" data-category="tools">
                    <i class="fas fa-tools mr-2"></i>Tools & Equipment
                </button>
                <button class="category-tab px-6 py-3 text-lg font-medium" data-category="seeds">
                    <i class="fas fa-seedling mr-2"></i>Seeds
                </button>
                <button class="category-tab px-6 py-3 text-lg font-medium" data-category="fertilizers">
                    <i class="fas fa-flask mr-2"></i>Fertilizers
                </button>
                <button class="category-tab px-6 py-3 text-lg font-medium" data-category="irrigation">
                    <i class="fas fa-tint mr-2"></i>Irrigation
                </button>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-16">
                <!-- Tools & Equipment -->
                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/mini-tractor.html">
                    <img src="marketimg/Mini Tractor.png" alt="Mini Tractor" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/mini-tractor.html" class="hover:text-green-600">
                        <h3 class="text-xl font-bold mb-2">Mini Tractor</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Compact and powerful mini tractor for small to medium farms</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹2,50,000</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="tractor1">
                                <input type="hidden" name="product_name" value="Mini Tractor">
                                <input type="hidden" name="product_price" value="250000">
                                <input type="hidden" name="product_image" value="marketimg/Mini Tractor.png">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Hand Cultivator -->
                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/hand-cultivator.html">
                        <img src="marketimg/Hand Cultivator.jpg" alt="Hand Cultivator" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/hand-cultivator.html" class="hover:text-green-600">
                            <h3 class="text-xl font-bold mb-2">Hand Cultivator</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Essential gardening tool for breaking up soil and removing weeds</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹850</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="cultivator1">
                                <input type="hidden" name="product_name" value="Hand Cultivator">
                                <input type="hidden" name="product_price" value="850">
                                <input type="hidden" name="product_image" value="marketimg/Hand Cultivator.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/garden-fork.html">
                        <img src="marketimg/Garden Fork.jpg" alt="Garden Fork" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/garden-fork.html" class="hover:text-green-600">
                            <h3 class="text-xl font-bold mb-2">Garden Fork</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Sturdy fork for breaking up compacted soil</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹1,200</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="gardenfork1">
                                <input type="hidden" name="product_name" value="Garden Fork">
                                <input type="hidden" name="product_price" value="1200">
                                <input type="hidden" name="product_image" value="marketimg/Garden Fork.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/pruning-shears.html">
                        <img src="marketimg/Pruning Shears.jpg" alt="Pruning Shears" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/pruning-shears.html" class="hover:text-green-600">
                            <h3 class="text-xl font-bold mb-2">Pruning Shears</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Sharp shears for precise plant trimming</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹750</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="pruningshears1">
                                <input type="hidden" name="product_name" value="Pruning Shears">
                                <input type="hidden" name="product_price" value="750">
                                <input type="hidden" name="product_image" value="marketimg/Pruning Shears.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/wheelbarrow.html">
                        <img src="marketimg/Wheelbarrow.jpg" alt="Wheelbarrow" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/wheelbarrow.html" class="hover:text-green-600">
                            <h3 class="text-xl font-bold mb-2">Wheelbarrow</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Heavy-duty wheelbarrow for transporting materials</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹3,500</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="wheelbarrow1">
                                <input type="hidden" name="product_name" value="Wheelbarrow">
                                <input type="hidden" name="product_price" value="3500">
                                <input type="hidden" name="product_image" value="marketimg/Wheelbarrow.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/spade.html">
                        <img src="marketimg/Spade.jpg" alt="Spade" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/spade.html" class="hover:text-green-600">
                            <h3 class="text-xl font-bold mb-2">Spade</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Durable spade for digging and soil turning</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹950</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="spade1">
                                <input type="hidden" name="product_name" value="Spade">
                                <input type="hidden" name="product_price" value="950">
                                <input type="hidden" name="product_image" value="marketimg/Spade.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/hoe.html">
                        <img src="marketimg/Hoe –.jpg" alt="Hoe" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/hoe.html" class="hover:text-green-600">
                            <h3 class="text-xl font-bold mb-2">Hoe</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Versatile hoe for weeding and soil cultivation</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹800</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="hoe1">
                                <input type="hidden" name="product_name" value="Hoe">
                                <input type="hidden" name="product_price" value="800">
                                <input type="hidden" name="product_image" value="marketimg/Hoe –.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/rake.html">
                        <img src="marketimg/Rake.jpg" alt="Rake" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/rake.html" class="hover:text-green-600">
                            <h3 class="text-xl font-bold mb-2">Rake</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Sturdy rake for leveling soil and gathering debris</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹750</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="rake1">
                                <input type="hidden" name="product_name" value="Rake">
                                <input type="hidden" name="product_price" value="750">
                                <input type="hidden" name="product_image" value="marketimg/Rake.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="tools">
                    <a href="productpages/watering-can.html">
                        <img src="marketimg/Watering Can.jpg" alt="Watering Can" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="productpages/watering-can.html" class="hover:text-green-600">
                            <h3 class="text-xl font-bold mb-2">Watering Can</h3>
                        </a>
                        <p class="text-gray-600 mb-4">Large capacity watering can with adjustable nozzle</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹600</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="wateringcan1">
                                <input type="hidden" name="product_name" value="Watering Can">
                                <input type="hidden" name="product_price" value="600">
                                <input type="hidden" name="product_image" value="marketimg/Watering Can.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Seeds -->
                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="seeds">
                    <img src="marketimg/Tomato Seeds.jpg" alt="Tomato Seeds" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Tomato Seeds</h3>
                        <p class="text-gray-600 mb-4">High-yield hybrid tomato seeds for optimal growth</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹250</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="tomatoseeds1">
                                <input type="hidden" name="product_name" value="Tomato Seeds">
                                <input type="hidden" name="product_price" value="250">
                                <input type="hidden" name="product_image" value="marketimg/Tomato Seeds.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="seeds">
                    <img src="marketimg/Wheat Seeds.jpg" alt="Wheat Seeds" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Wheat Seeds</h3>
                        <p class="text-gray-600 mb-4">Disease-resistant wheat seeds for high yields</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹450</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="wheatseeds1">
                                <input type="hidden" name="product_name" value="Wheat Seeds">
                                <input type="hidden" name="product_price" value="450">
                                <input type="hidden" name="product_image" value="marketimg/Wheat Seeds.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="seeds">
                    <img src="marketimg/Rice Seeds.jpg" alt="Rice Seeds" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Rice Seeds</h3>
                        <p class="text-gray-600 mb-4">Premium quality rice seeds for paddy cultivation</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹550</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="riceseeds1">
                                <input type="hidden" name="product_name" value="Rice Seeds">
                                <input type="hidden" name="product_price" value="550">
                                <input type="hidden" name="product_image" value="marketimg/Rice Seeds.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="seeds">
                    <img src="marketimg/Corn Seeds.jpg" alt="Corn Seeds" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Corn Seeds</h3>
                        <p class="text-gray-600 mb-4">Sweet corn seeds for high-quality produce</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹350</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="cornseeds1">
                                <input type="hidden" name="product_name" value="Corn Seeds">
                                <input type="hidden" name="product_price" value="350">
                                <input type="hidden" name="product_image" value="marketimg/Corn Seeds.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="seeds">
                    <img src="marketimg/Potato Seeds.jpg" alt="Potato Seeds" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Potato Seeds</h3>
                        <p class="text-gray-600 mb-4">Certified potato seeds for optimal tuber growth</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹750</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="potatoseeds1">
                                <input type="hidden" name="product_name" value="Potato Seeds">
                                <input type="hidden" name="product_price" value="750">
                                <input type="hidden" name="product_image" value="marketimg/Potato Seeds.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="seeds">
                    <img src="marketimg/Soybean-seeds.jpg" alt="Soybean Seeds" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Soybean Seeds</h3>
                        <p class="text-gray-600 mb-4">High-protein soybean seeds for commercial farming</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹650</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="soybeanseeds1">
                                <input type="hidden" name="product_name" value="Soybean Seeds">
                                <input type="hidden" name="product_price" value="650">
                                <input type="hidden" name="product_image" value="marketimg/Soybean-seeds.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="seeds">
                    <img src="marketimg/Cotton Seeds.jpg" alt="Cotton Seeds" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Cotton Seeds</h3>
                        <p class="text-gray-600 mb-4">BT cotton seeds for high-quality fiber production</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹850</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="cottonseeds1">
                                <input type="hidden" name="product_name" value="Cotton Seeds">
                                <input type="hidden" name="product_price" value="850">
                                <input type="hidden" name="product_image" value="marketimg/Cotton Seeds.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="seeds">
                    <img src="marketimg/Sugarcane Seeds.webp" alt="Sugarcane Seeds" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Sugarcane Seeds</h3>
                        <p class="text-gray-600 mb-4">High-sugar content sugarcane seeds for optimal yield</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹950</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="sugarcaneseeds1">
                                <input type="hidden" name="product_name" value="Sugarcane Seeds">
                                <input type="hidden" name="product_price" value="950">
                                <input type="hidden" name="product_image" value="marketimg/Sugarcane Seeds.webp">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Fertilizers -->
                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="fertilizers">
                    <img src="marketimg/NPK Fertilizer.png" alt="NPK Fertilizer" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">NPK Fertilizer</h3>
                        <p class="text-gray-600 mb-4">Balanced NPK fertilizer for overall plant growth</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹1,200</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="npkfertilizer1">
                                <input type="hidden" name="product_name" value="NPK Fertilizer">
                                <input type="hidden" name="product_price" value="1200">
                                <input type="hidden" name="product_image" value="marketimg/NPK Fertilizer.png">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="fertilizers">
                    <img src="marketimg/Organic Compost.jpg" alt="Organic Compost" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Organic Compost</h3>
                        <p class="text-gray-600 mb-4">Natural organic compost for soil enrichment</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹800</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="organiccompost1">
                                <input type="hidden" name="product_name" value="Organic Compost">
                                <input type="hidden" name="product_price" value="800">
                                <input type="hidden" name="product_image" value="marketimg/Organic Compost.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="fertilizers">
                    <img src="marketimg/Urea.jpg" alt="Urea" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Urea</h3>
                        <p class="text-gray-600 mb-4">High-nitrogen fertilizer for leafy growth</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹950</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="urea1">
                                <input type="hidden" name="product_name" value="Urea">
                                <input type="hidden" name="product_price" value="950">
                                <input type="hidden" name="product_image" value="marketimg/Urea.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="fertilizers">
                    <img src="marketimg/DAP (Diammonium Phosphate).jpg" alt="DAP" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">DAP</h3>
                        <p class="text-gray-600 mb-4">Diammonium phosphate for root development</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹1,100</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="dap1">
                                <input type="hidden" name="product_name" value="DAP">
                                <input type="hidden" name="product_price" value="1100">
                                <input type="hidden" name="product_image" value="marketimg/DAP (Diammonium Phosphate).jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="fertilizers">
                    <img src="marketimg/Potash.jpg" alt="Potash" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Potash</h3>
                        <p class="text-gray-600 mb-4">Potassium-rich fertilizer for fruit development</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹900</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="potash1">
                                <input type="hidden" name="product_name" value="Potash">
                                <input type="hidden" name="product_price" value="900">
                                <input type="hidden" name="product_image" value="marketimg/Potash.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="fertilizers">
                    <img src="marketimg/Vermicompost.jpg" alt="Vermicompost" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Vermicompost</h3>
                        <p class="text-gray-600 mb-4">Earthworm-processed organic fertilizer</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹750</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="vermicompost1">
                                <input type="hidden" name="product_name" value="Vermicompost">
                                <input type="hidden" name="product_price" value="750">
                                <input type="hidden" name="product_image" value="marketimg/Vermicompost.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="fertilizers">
                    <img src="marketimg/Bio Fertilizer.jpg" alt="Bio Fertilizer" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Bio Fertilizer</h3>
                        <p class="text-gray-600 mb-4">Microbial-based fertilizer for soil health</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹1,500</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="biofertilizer1">
                                <input type="hidden" name="product_name" value="Bio Fertilizer">
                                <input type="hidden" name="product_price" value="1500">
                                <input type="hidden" name="product_image" value="marketimg/Bio Fertilizer.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Irrigation -->
                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="irrigation">
                    <img src="marketimg/Drip Irrigation Kit.jpg" alt="Drip Irrigation Kit" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Drip Irrigation Kit</h3>
                        <p class="text-gray-600 mb-4">Complete drip irrigation system for efficient watering</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹5,500</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="dripkit1">
                                <input type="hidden" name="product_name" value="Drip Irrigation Kit">
                                <input type="hidden" name="product_price" value="5500">
                                <input type="hidden" name="product_image" value="marketimg/Drip Irrigation Kit.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="irrigation">
                    <img src="marketimg/Sprinkler System.jpg" alt="Sprinkler System" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Sprinkler System</h3>
                        <p class="text-gray-600 mb-4">Automated sprinkler system for large areas</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹8,500</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="sprinkler1">
                                <input type="hidden" name="product_name" value="Sprinkler System">
                                <input type="hidden" name="product_price" value="8500">
                                <input type="hidden" name="product_image" value="marketimg/Sprinkler System.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="irrigation">
                    <img src="marketimg/Water Pump.jpg" alt="Water Pump" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Water Pump</h3>
                        <p class="text-gray-600 mb-4">High-pressure water pump for irrigation systems</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹12,000</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="waterpump1">
                                <input type="hidden" name="product_name" value="Water Pump">
                                <input type="hidden" name="product_price" value="12000">
                                <input type="hidden" name="product_image" value="marketimg/Water Pump.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="irrigation">
                    <img src="marketimg/Irrigation Timer.webp" alt="Irrigation Timer" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Irrigation Timer</h3>
                        <p class="text-gray-600 mb-4">Programmable timer for automated irrigation</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹2,500</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="irrigationtimer1">
                                <input type="hidden" name="product_name" value="Irrigation Timer">
                                <input type="hidden" name="product_price" value="2500">
                                <input type="hidden" name="product_image" value="marketimg/Irrigation Timer.webp">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="irrigation">
                    <img src="marketimg/PVC Pipes.webp" alt="PVC Pipes" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">PVC Pipes</h3>
                        <p class="text-gray-600 mb-4">Durable PVC pipes for irrigation systems</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹1,800</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="pvcpipes1">
                                <input type="hidden" name="product_name" value="PVC Pipes">
                                <input type="hidden" name="product_price" value="1800">
                                <input type="hidden" name="product_image" value="marketimg/PVC Pipes.webp">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="irrigation">
                    <img src="marketimg/Nozzles.webp" alt="Nozzles" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Nozzles</h3>
                        <p class="text-gray-600 mb-4">Adjustable nozzles for precise water distribution</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹450</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="nozzles1">
                                <input type="hidden" name="product_name" value="Nozzles">
                                <input type="hidden" name="product_price" value="450">
                                <input type="hidden" name="product_image" value="marketimg/Nozzles.webp">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="irrigation">
                    <img src="marketimg/Water Tank.jpg" alt="Water Tank" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Water Tank</h3>
                        <p class="text-gray-600 mb-4">Large capacity water storage tank for irrigation</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">₹15,000</span>
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="watertank1">
                                <input type="hidden" name="product_name" value="Water Tank">
                                <input type="hidden" name="product_price" value="15000">
                                <input type="hidden" name="product_image" value="marketimg/Water Tank.jpg">
                                <button type="submit" name="add_to_cart" class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Call to Action -->
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-6" id="cta-title">Need Help Choosing?</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto" id="cta-desc">Our agricultural experts are here to help you select the right products for your farming needs. Contact us for personalized recommendations.</p>
                <a href="../index.html#contact" class="bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition duration-300 inline-block">
                    <span id="cta-button">Contact Our Experts</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
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
    <script>
        // Category filtering
        document.addEventListener('DOMContentLoaded', function() {
            const categoryTabs = document.querySelectorAll('.category-tab');
            const products = document.querySelectorAll('.product-card');
            
            categoryTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    const category = this.getAttribute('data-category');
                    
                    products.forEach(product => {
                        if (category === 'all' || product.getAttribute('data-category') === category) {
                            product.style.display = 'block';
                        } else {
                            product.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html> 