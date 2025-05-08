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
    <title>Agricultural Training Programs - FarmEmpower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .program-card {
            transition: transform 0.3s ease;
        }
        .program-card:hover {
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
                <a href="online-marketplace.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-store mr-2"></i>
                    <span id="nav-market">Market Access</span>
                </a>
                <a href="training-programs.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    <span id="nav-training">Training</span>
                </a>
                <a href="cart.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span id="cart">Cart (<?php echo $cart_count; ?>)</span>
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
                <a href="online-marketplace.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-store mr-2"></i>
                    <span id="mobile-nav-market">Market Access</span>
                </a>
                <a href="training-programs.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    <span id="mobile-nav-training">Training</span>
                </a>
                <a href="cart.php" class="hover:text-green-200 transition duration-300 flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span id="mobile-cart">Cart (<?php echo $cart_count; ?>)</span>
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
            <h1 class="text-4xl md:text-6xl font-bold mb-6" id="hero-title">Agricultural Training Programs</h1>
            <p class="text-xl mb-8" id="hero-subtitle">Enhance your farming knowledge with expert-led training sessions</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <!-- Introduction -->
            <div class="max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold mb-6" id="intro-title">Empowering Farmers Through Education</h2>
                <p class="text-gray-600 mb-4" id="intro-text">Our comprehensive training programs are designed to equip farmers with the latest agricultural techniques, sustainable farming practices, and business management skills. Whether you're a beginner or an experienced farmer, our expert-led sessions will help you improve your farming operations and increase productivity.</p>
            </div>

            <!-- Category Tabs -->
            <div class="flex flex-wrap justify-center mb-12 border-b">
                <button class="category-tab active px-6 py-3 text-lg font-medium" data-category="all">
                    <i class="fas fa-th-large mr-2"></i>All Programs
                </button>
                <button class="category-tab px-6 py-3 text-lg font-medium" data-category="basic">
                    <i class="fas fa-seedling mr-2"></i>Basic Farming
                </button>
                <button class="category-tab px-6 py-3 text-lg font-medium" data-category="advanced">
                    <i class="fas fa-leaf mr-2"></i>Advanced Techniques
                </button>
                <button class="category-tab px-6 py-3 text-lg font-medium" data-category="business">
                    <i class="fas fa-chart-line mr-2"></i>Business Management
                </button>
                <button class="category-tab px-6 py-3 text-lg font-medium" data-category="sustainable">
                    <i class="fas fa-recycle mr-2"></i>Sustainable Farming
                </button>
            </div>

            <!-- Training Programs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <!-- Basic Farming Programs -->
                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="basic">
                    <img src="image/trainimg/Basic Crop Management.jpg" alt="Basic Crop Management" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Basic Crop Management</h3>
                        <p class="text-gray-600 mb-4">Learn fundamental techniques for growing healthy crops, including soil preparation, planting, and basic pest management.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹2,500</span>
                                <span class="text-gray-500 text-sm ml-2">/ 4 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Basic Crop Management', 2500)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="basic">
                    <img src="image/trainimg/Irrigation Basics.jpg" alt="Irrigation Basics" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Irrigation Basics</h3>
                        <p class="text-gray-600 mb-4">Master the fundamentals of water management for crops, including different irrigation methods and scheduling techniques.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹3,000</span>
                                <span class="text-gray-500 text-sm ml-2">/ 3 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Irrigation Basics', 3000)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="basic">
                    <img src="image/trainimg/ferti.jpg" alt="Fertilizer Management" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Fertilizer Management</h3>
                        <p class="text-gray-600 mb-4">Learn about different types of fertilizers, their applications, and how to optimize nutrient management for better yields.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹2,800</span>
                                <span class="text-gray-500 text-sm ml-2">/ 3 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Fertilizer Management', 2800)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Advanced Techniques Programs -->
                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="advanced">
                    <img src="image/trainimg/Advanced Irrigation Systems.jpg" alt="Advanced Irrigation Systems" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Advanced Irrigation Systems</h3>
                        <p class="text-gray-600 mb-4">Master sophisticated irrigation techniques including drip, sprinkler, and automated systems for optimal water efficiency.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹4,500</span>
                                <span class="text-gray-500 text-sm ml-2">/ 4 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Advanced Irrigation Systems', 4500)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="advanced">
                    <img src="image/trainimg/High-Yield Crop Production.webp" alt="High-Yield Crop Production" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">High-Yield Crop Production</h3>
                        <p class="text-gray-600 mb-4">Learn advanced techniques to maximize crop yields through proper variety selection, planting density, and management practices.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹5,000</span>
                                <span class="text-gray-500 text-sm ml-2">/ 5 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('High-Yield Crop Production', 5000)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="advanced">
                    <img src="image/trainimg/Advanced Pest Management.jpg" alt="Advanced Pest Management" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Advanced Pest Management</h3>
                        <p class="text-gray-600 mb-4">Master integrated pest management strategies, including biological controls, chemical applications, and monitoring techniques.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹4,200</span>
                                <span class="text-gray-500 text-sm ml-2">/ 4 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Advanced Pest Management', 4200)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Business Management Programs -->
                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="business">
                    <img src="image/trainimg/Farm Business Planning.jpg" alt="Farm Business Planning" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Farm Business Planning</h3>
                        <p class="text-gray-600 mb-4">Learn how to develop a comprehensive business plan for your farm, including financial projections and marketing strategies.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹3,800</span>
                                <span class="text-gray-500 text-sm ml-2">/ 4 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Farm Business Planning', 3800)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="business">
                    <img src="image/trainimg/Financial Management for Farmers.jpg" alt="Financial Management for Farmers" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Financial Management for Farmers</h3>
                        <p class="text-gray-600 mb-4">Master budgeting, record-keeping, and financial analysis techniques to improve the profitability of your farming operations.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹4,000</span>
                                <span class="text-gray-500 text-sm ml-2">/ 4 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Financial Management for Farmers', 4000)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="business">
                    <img src="image/trainimg/Marketing and Sales Strategies.jpg" alt="Marketing and Sales Strategies" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Marketing and Sales Strategies</h3>
                        <p class="text-gray-600 mb-4">Learn effective marketing techniques to promote your farm products and develop sales channels for better profitability.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹3,500</span>
                                <span class="text-gray-500 text-sm ml-2">/ 3 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Marketing and Sales Strategies', 3500)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sustainable Farming Programs -->
                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="sustainable">
                    <img src="image/trainimg/Organic Farming Practices.jpg" alt="Organic Farming Practices" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Organic Farming Practices</h3>
                        <p class="text-gray-600 mb-4">Learn sustainable farming methods without synthetic inputs, focusing on soil health, biodiversity, and natural pest control.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹4,800</span>
                                <span class="text-gray-500 text-sm ml-2">/ 5 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Organic Farming Practices', 4800)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="sustainable">
                    <img src="image/trainimg/Soil Health Management.jpg" alt="Soil Health Management" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Soil Health Management</h3>
                        <p class="text-gray-600 mb-4">Master techniques for improving soil fertility, structure, and biological activity for sustainable crop production.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹3,600</span>
                                <span class="text-gray-500 text-sm ml-2">/ 4 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Soil Health Management', 3600)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="program-card bg-white rounded-xl shadow-lg overflow-hidden" data-category="sustainable">
                    <img src="image/trainimg/Climate-Smart Agriculture.png" alt="Climate-Smart Agriculture" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Climate-Smart Agriculture</h3>
                        <p class="text-gray-600 mb-4">Learn farming practices that help adapt to and mitigate climate change while ensuring food security and sustainability.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-600 font-bold">₹4,200</span>
                                <span class="text-gray-500 text-sm ml-2">/ 4 weeks</span>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition duration-300" onclick="openEnrollmentModal('Climate-Smart Agriculture', 4200)">
                                <i class="fas fa-user-plus mr-2"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-6" id="cta-title">Need Help Choosing a Program?</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto" id="cta-desc">Our agricultural experts are here to help you select the right training program for your needs. Contact us for personalized recommendations.</p>
                <a href="../index.html#contact" class="bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition duration-300 inline-block">
                    <span id="cta-button">Contact Our Experts</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Enrollment Modal -->
    <div id="enrollment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold" id="modal-title">Enroll in Training Program</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="enrollment-form" action="process-enrollment.php" method="POST">
                <input type="hidden" id="program-name" name="program_name" value="">
                <input type="hidden" id="program-price" name="program_price" value="">
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
                    <input type="text" id="location" name="location" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                
                <div class="mb-6">
                    <label for="experience" class="block text-gray-700 font-medium mb-2">Farming Experience</label>
                    <select id="experience" name="experience" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <option value="">Select your experience level</option>
                        <option value="beginner">Beginner (0-2 years)</option>
                        <option value="intermediate">Intermediate (3-5 years)</option>
                        <option value="advanced">Advanced (5+ years)</option>
                    </select>
                </div>
                
                <div class="flex justify-end">
                    <button type="button" id="cancel-enrollment" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-full mr-3 hover:bg-gray-400 transition duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition duration-300">
                        Submit Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 FarmEmpower. <span id="footer-rights">All rights reserved.</span></p>
        </div>
    </footer>

    <script>
        // Category filtering
        document.addEventListener('DOMContentLoaded', function() {
            const categoryTabs = document.querySelectorAll('.category-tab');
            const programs = document.querySelectorAll('.program-card');
            
            categoryTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    const category = this.getAttribute('data-category');
                    
                    programs.forEach(program => {
                        if (category === 'all' || program.getAttribute('data-category') === category) {
                            program.style.display = 'block';
                        } else {
                            program.style.display = 'none';
                        }
                    });
                });
            });

            // Mobile menu toggle
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            menuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Language selector
            const langSelector = document.getElementById('lang-selector');
            const langDropdown = document.getElementById('lang-dropdown');
            
            langSelector.addEventListener('click', function() {
                langDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!langSelector.contains(event.target) && !langDropdown.contains(event.target)) {
                    langDropdown.classList.add('hidden');
                }
            });

            // Enrollment modal
            const enrollmentModal = document.getElementById('enrollment-modal');
            const closeModal = document.getElementById('close-modal');
            const cancelEnrollment = document.getElementById('cancel-enrollment');
            const programNameInput = document.getElementById('program-name');
            const programPriceInput = document.getElementById('program-price');
            const modalTitle = document.getElementById('modal-title');
            
            window.openEnrollmentModal = function(programName, programPrice) {
                programNameInput.value = programName;
                programPriceInput.value = programPrice;
                modalTitle.textContent = `Enroll in ${programName}`;
                enrollmentModal.classList.remove('hidden');
            };
            
            closeModal.addEventListener('click', function() {
                enrollmentModal.classList.add('hidden');
            });
            
            cancelEnrollment.addEventListener('click', function() {
                enrollmentModal.classList.add('hidden');
            });
            
            // Close modal when clicking outside
            enrollmentModal.addEventListener('click', function(event) {
                if (event.target === enrollmentModal) {
                    enrollmentModal.classList.add('hidden');
                }
            });
        });
    </script>

    <script src="script.js"></script>
</body>
</html> 