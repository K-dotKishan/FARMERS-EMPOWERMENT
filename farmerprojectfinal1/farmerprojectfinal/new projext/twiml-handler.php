<?php
header('Content-Type: text/xml');
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Customer';
echo '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Say voice="alice">Hello ' . $name . '. Your order has been received successfully. Thank you for shopping with Farm Empower.</Say>
</Response>';
?>