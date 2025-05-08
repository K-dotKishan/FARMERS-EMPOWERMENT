<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/Product.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION['user'];
$product = new Product();
$userProducts = $product->getProductsByUser($user['id'])->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FarmEmpower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.html" class="flex items-center space-x-3">
                <i class="fas fa-leaf text-2xl"></i>
                <span class="text-xl font-bold">FarmEmpower</span>
            </a>
            <div class="flex items-center space-x-4">
                <span>Welcome, <?php echo htmlspecialchars($user['full_name']); ?></span>
                <button onclick="logout()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Logout
                </button>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- User Profile Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">Your Profile</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Username: <span class="font-medium"><?php echo htmlspecialchars($user['username']); ?></span></p>
                    <p class="text-gray-600">Email: <span class="font-medium"><?php echo htmlspecialchars($user['email']); ?></span></p>
                </div>
                <div>
                    <p class="text-gray-600">Phone: <span class="font-medium"><?php echo htmlspecialchars($user['phone'] ?? 'Not provided'); ?></span></p>
                    <p class="text-gray-600">Address: <span class="font-medium"><?php echo htmlspecialchars($user['address'] ?? 'Not provided'); ?></span></p>
                </div>
            </div>
        </div>

        <!-- Your Products Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Your Products</h2>
                <a href="sell-products.html" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Add New Product
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($userProducts as $product): ?>
                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="text-gray-600 mb-2">Category: <?php echo htmlspecialchars($product['category']); ?></p>
                    <p class="text-gray-600 mb-2">Price: ₹<?php echo number_format($product['price'], 2); ?></p>
                    <p class="text-gray-600 mb-2">Quantity: <?php echo htmlspecialchars($product['quantity']); ?></p>
                    <p class="text-gray-600 mb-2">Status: 
                        <span class="px-2 py-1 rounded-full text-sm 
                            <?php echo $product['status'] === 'approved' ? 'bg-green-100 text-green-800' : 
                                ($product['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo ucfirst($product['status']); ?>
                        </span>
                    </p>
                    <div class="mt-4">
                        <a href="edit-product.php?id=<?php echo $product['id']; ?>" 
                           class="text-blue-600 hover:text-blue-800 mr-4">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button onclick="deleteProduct(<?php echo $product['id']; ?>)" 
                                class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Your Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Order ID</th>
                            <th class="py-2 px-4 border-b">Product</th>
                            <th class="py-2 px-4 border-b">Quantity</th>
                            <th class="py-2 px-4 border-b">Total Price</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Date</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTable">
                        <!-- Orders will be loaded here via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="js/auth.js"></script>
    <script>
        // Load orders
        async function loadOrders() {
            try {
                const response = await fetch('api/get_orders.php');
                const data = await response.json();
                
                const ordersTable = document.getElementById('ordersTable');
                ordersTable.innerHTML = '';
                
                data.forEach(order => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-2 px-4 border-b">${order.id}</td>
                        <td class="py-2 px-4 border-b">${order.product_name}</td>
                        <td class="py-2 px-4 border-b">${order.quantity}</td>
                        <td class="py-2 px-4 border-b">₹${order.total_price}</td>
                        <td class="py-2 px-4 border-b">
                            <span class="px-2 py-1 rounded-full text-sm 
                                ${order.status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                  order.status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                                  'bg-blue-100 text-blue-800'}">
                                ${order.status}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b">${new Date(order.created_at).toLocaleDateString()}</td>
                    `;
                    ordersTable.appendChild(row);
                });
            } catch (error) {
                console.error('Error loading orders:', error);
            }
        }

        // Delete product
        async function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                try {
                    const response = await fetch(`api/delete_product.php?id=${productId}`, {
                        method: 'DELETE'
                    });
                    
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error deleting product');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error deleting product');
                }
            }
        }

        // Load orders when page loads
        document.addEventListener('DOMContentLoaded', loadOrders);
    </script>
</body>
</html> 