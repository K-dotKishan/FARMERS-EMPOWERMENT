<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require_once __DIR__ . '/vendor/autoload.php'; // Twilio SDK
use Twilio\Rest\Client;

// Sample cart (for demo)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        ['name' => 'Organic Apples', 'price' => 99],
        ['name' => 'Fresh Carrots', 'price' => 50],
    ];
}

if (empty($_SESSION['cart'])) {
    header('Location: online-marketplace.php');
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'];
}

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_NAME']
);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone']; // New
    $payment_method = $_POST['payment_method'];
    $card_number = $_POST['card_number'] ?? null;
    $card_expiry = $_POST['card_expiry'] ?? null;
    $card_cvv = $_POST['card_cvv'] ?? null;

    $stmt = $conn->prepare("INSERT INTO payments (name, email, phone, amount, payment_method, card_number, card_expiry, card_cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdsdss", $name, $email, $phone, $total, $payment_method, $card_number, $card_expiry, $card_cvv);
    $stmt->execute();
    $stmt->close();

    // ✅ Send confirmation email
    $to = $email;
    $subject = "Order Confirmation - FarmEmpower";
    $message = "Hi $name,\n\nThank you for your order. Here's what you bought:\n";

    foreach ($_SESSION['cart'] as $item) {
        $message .= "- " . $item['name'] . " for ₹" . $item['price'] . "\n";
    }
    $message .= "\nTotal: ₹$total\n\nWe'll get in touch soon!\nFarmEmpower";

    $headers = "From: " . $_ENV['EMAIL_FROM'] . "\r\n";
    $headers .= "Reply-To: " . $_ENV['EMAIL_REPLY_TO'] . "\r\n";

    mail($to, $subject, $message, $headers);

    // Twilio Call
    $sid = $_ENV['TWILIO_ACCOUNT_SID'];
    $token = $_ENV['TWILIO_AUTH_TOKEN'];
    $twilio_number = $_ENV['TWILIO_PHONE_NUMBER'];
    $user_number = '+91' . ltrim($phone, '0');

    $client = new Client($sid, $token);

    // Use the newer Twilio\TwiML\VoiceResponse class
$response = new Twilio\TwiML\VoiceResponse();
$response->say("Hello $name. Your order has been received successfully. Thank you for shopping with Farm Empower.", 
              ['voice' => 'alice']);

$client->calls->create(
    $user_number,
    $twilio_number,
    ["twiml" => (string)$response]
);

    $_SESSION['cart'] = [];
    header('Location: order-success.php');
    exit();
}

$upi_id = $_ENV['UPI_ID'];
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - FarmEmpower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7fafc;
        }
        .checkout-container {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
        .checkout-container:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .input-field {
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        .input-field:focus {
            border-color: #48bb78;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.2);
        }
        .payment-method label {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .payment-method input:checked + span {
            color: #48bb78;
            font-weight: 600;
        }
        .btn-pay {
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .qr-container {
            transition: all 0.5s ease;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="checkout-container w-full max-w-md bg-white rounded-lg overflow-hidden">
        <div class="bg-green-600 py-4 px-6">
            <h1 class="text-2xl font-bold text-white">Checkout</h1>
            <p class="text-green-100">Complete your purchase</p>
        </div>

        <div class="p-6">
            <!-- Order Summary -->
            <div class="mb-6 border-b pb-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Order Summary</h2>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600"><?php echo htmlspecialchars($item['name']); ?></span>
                        <span class="font-medium">₹<?php echo number_format($item['price'], 2); ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="flex justify-between pt-2 mt-2 border-t border-gray-200">
                    <span class="font-semibold text-gray-800">Total</span>
                    <span class="font-bold text-green-600">₹<?php echo number_format($total, 2); ?></span>
                </div>
            </div>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                    <input type="text" name="name" placeholder="John Doe" required 
                           class="input-field w-full px-4 py-2 rounded-lg focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" placeholder="john@example.com" required 
                           class="input-field w-full px-4 py-2 rounded-lg focus:outline-none">
                </div>
                <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
    <input type="tel" name="phone" placeholder="+91xxxxxxxxxx" required 
           class="input-field w-full px-4 py-2 rounded-lg focus:outline-none">
</div>

                <div class="payment-method">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <div class="flex space-x-6">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="card" checked 
                                   class="h-4 w-4 text-green-600 focus:ring-green-500" 
                                   onclick="toggleCardFields(true)">
                            <span class="ml-2 text-gray-700">Credit Card</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="qr" 
                                   class="h-4 w-4 text-green-600 focus:ring-green-500" 
                                   onclick="toggleCardFields(false)">
                            <span class="ml-2 text-gray-700">UPI QR</span>
                        </label>
                    </div>
                </div>

                <div id="card-fields" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                        <input type="text" name="card_number" placeholder="4242 4242 4242 4242" 
                               class="input-field w-full px-4 py-2 rounded-lg focus:outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                            <input type="text" name="card_expiry" placeholder="MM/YY" 
                                   class="input-field w-full px-4 py-2 rounded-lg focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                            <input type="text" name="card_cvv" placeholder="123" 
                                   class="input-field w-full px-4 py-2 rounded-lg focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- QR Code block -->
                <div id="qr-placeholder" class="qr-container hidden rounded-lg p-5 text-center">
                    <p class="text-sm font-medium text-gray-700 mb-3">Scan to pay via UPI</p>
                    <img 
                        src="https://api.qrserver.com/v1/create-qr-code/?data=upi://pay?pa=maitreya16pathak@okhdfcbank&amp;pn=Maitreya%20Pathak&amp;am=<?php echo $total; ?>&amp;cu=INR" 
                        alt="QR Code" 
                        class="mx-auto w-48 h-48 border-4 border-white shadow-md"
                    >
                    <div class="mt-4 bg-white rounded p-3">
                        <p class="text-lg font-semibold text-green-600">₹<?php echo number_format($total, 2); ?></p>
                        <p class="text-xs text-gray-500 mt-1">UPI ID: maitreya16pathak@okhdfcbank</p>
                    </div>
                </div>

                <button type="submit" 
                        class="btn-pay w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Pay ₹<?php echo number_format($total, 2); ?>
                </button>

                <p class="text-xs text-gray-500 text-center mt-4">
                    Your payment is secure and encrypted. By completing this purchase, you agree to our terms of service.
                </p>
            </form>
        </div>
    </div>

    <script>
    function toggleCardFields(showCard) {
        document.getElementById('card-fields').style.display = showCard ? 'block' : 'none';
        document.getElementById('qr-placeholder').classList.toggle('hidden', showCard);
        
        // Add animation classes
        if (showCard) {
            document.getElementById('card-fields').classList.add('animate-fadeIn');
            document.getElementById('qr-placeholder').classList.remove('animate-fadeIn');
        } else {
            document.getElementById('qr-placeholder').classList.add('animate-fadeIn');
            document.getElementById('card-fields').classList.remove('animate-fadeIn');
        }
    }
    
    // Initialize with card fields visible
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('card-fields').style.display = 'block';
        document.getElementById('qr-placeholder').classList.add('hidden');
    });
    </script>
</body>
</html>