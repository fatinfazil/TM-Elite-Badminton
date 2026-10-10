<?php 
include 'db_connect.php';

// Get booking IDs from URL
$booking_ids = $_GET['booking_ids'] ?? '';

if (!$booking_ids) {
    die("Invalid payment information");
}

// Convert to array of integers to prevent SQL injection
$ids_array = array_map('intval', explode(',', $booking_ids));
$placeholders = implode(',', array_fill(0, count($ids_array), '?'));

// Prepare SQL dynamically based on number of IDs
$types = str_repeat('i', count($ids_array));
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id IN ($placeholders)");
$stmt->bind_param($types, ...$ids_array);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
$slots = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
    $slots[] = $row['time_slot'];
}

if (empty($bookings)) {
    die("No bookings found");
}

// Check if all already paid
$alreadyPaid = true;
foreach ($bookings as $b) {
    if ($b['payment_status'] !== 'paid') {
        $alreadyPaid = false;
        break;
    }
}

// Handle payment submission
if (isset($_POST['pay']) && !$alreadyPaid) {

    $customer_name = trim($_POST['customer_name'] ?? '');
    $customer_phone = trim($_POST['customer_phone'] ?? '');
    $customer_email = trim($_POST['customer_email'] ?? '');

    if (!$customer_name || !$customer_phone || !$customer_email) {
        echo "<script>alert('Please fill in all customer details');</script>";
    } elseif (!isset($_FILES['payment_screenshot']) || $_FILES['payment_screenshot']['error'] != 0) {
        echo "<script>alert('Please upload your payment screenshot');</script>";
    } else {
        // Save uploaded file
        $targetDir = 'uploads/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
        $fileExt = pathinfo($_FILES['payment_screenshot']['name'], PATHINFO_EXTENSION);
        $fileName = 'payment_' . time() . '.' . $fileExt;
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $targetFile)) {
            // Update bookings with payment evidence AND customer details
            $stmt_update = $conn->prepare(
                "UPDATE bookings SET customer_name=?, customer_phone=?, customer_email=?, payment_status='pending', payment_reference=?, payment_time=NOW(), payment_screenshot=? WHERE id IN ($placeholders)"
            );

            $paymentRef = trim($_POST['payment_ref'] ?? '');
            if (!$paymentRef) $paymentRef = 'Manual Transfer';

            $bind_types = str_repeat('s', 5) . str_repeat('i', count($ids_array));
            $bind_values = array_merge([$customer_name, $customer_phone, $customer_email, $paymentRef, $fileName], $ids_array);
            $stmt_update->bind_param($bind_types, ...$bind_values);
            $stmt_update->execute();
            $stmt_update->close();

            echo "<script>alert('Payment evidence and customer details uploaded successfully! Waiting for admin confirmation.'); window.location='home.php';</script>";
            exit;
        } else {
            echo "<script>alert('Failed to upload screenshot.');</script>";
        }
    }
}

// Common info for display
$date = $bookings[0]['booking_date'];
$courtType = $bookings[0]['court_type'];
$courtNo = $bookings[0]['court_no'];
$pricePerSlot = 10;
$total = count($bookings) * $pricePerSlot;

// Prepare slots for back button
$slots_param = '';
foreach ($slots as $s) {
    $slots_param .= '&slots[]=' . urlencode($s);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Confirm Payment</title>
<link rel="stylesheet" href="style.css?v=10">
<style>
body { font-family: 'Segoe UI', sans-serif; background: #f4f6f8; margin: 0; min-height: 100vh; display: flex; flex-direction: column; }
.container { flex: 1; display: flex; flex-direction: column; align-items: center; padding: 20px; gap: 20px; }

.card { background: white; padding: 25px 30px; border-radius: 16px; max-width: 550px; width: 100%; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
.card h1, .card h2 { text-align: center; color: #1e3a8a; margin-bottom: 15px; }
.card h3 { color: #2563eb; margin-bottom: 10px; }
.card p, .card li, .card label { font-size: 16px; }
.card ul { padding-left: 20px; }

input[type=text], input[type=email], input[type=file] {
    width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px;
    border-radius: 5px; border: 1px solid #ccc; font-size: 16px;
}

.button-group { display: flex; justify-content: center; gap: 15px; margin-top: 20px; flex-wrap: wrap; }
.button, .button.back {
    display: inline-block; box-sizing: border-box; padding: 10px 25px; height: 42px; line-height: 22px;
    border-radius: 8px; font-weight: 600; font-size: 16px; border: none; cursor: pointer;
    text-align: center; text-decoration: none; color: white;
}
.button { background-color: #2563eb; }
.button.back { background-color: #9ca3af; }

.qr-section { text-align: center; margin: 20px 0; }
.qr-section img { width: 180px; height: 180px; object-fit: contain; display: block; margin: 15px auto; }

.rules { background: #f0f4f8; border-left: 4px solid #2563eb; padding: 10px 15px; margin-bottom: 15px; font-size: 14px; color: #333; }
footer { background: #e5e7eb; text-align: center; padding: 15px; margin-top: auto; font-size: 14px; }
</style>
</head>
<body>

<header>
<div class="header-inner">
    <h1>TM Elite Badminton Centre</h1>

</div>
</header>

<div class="container">

<!-- Customer Details Card -->
<div class="card">
<h1>Customer Details</h1>
<div class="rules">
<h3>Rules / Instructions:</h3>
<ul>
    <li>All fields are required.</li>
    <li>Enter your real name and contact info.</li>
    <li>Use a valid email for confirmation.</li>
</ul>
</div>

<form method="POST" enctype="multipart/form-data">
    <label for="customer_name">Full Name:</label>
    <input type="text" id="customer_name" name="customer_name" value="<?= htmlspecialchars($bookings[0]['customer_name']) ?>" placeholder="Enter your full name" required>

    <label for="customer_phone">Phone:</label>
    <input type="text" id="customer_phone" name="customer_phone" value="<?= htmlspecialchars($bookings[0]['customer_phone']) ?>" placeholder="Enter your phone number" required>

    <label for="customer_email">Email:</label>
    <input type="email" id="customer_email" name="customer_email" value="<?= htmlspecialchars($bookings[0]['customer_email']) ?>" placeholder="Enter your email" required>
</div>

<!-- Booking & Payment Card -->
<div class="card">
<h1>Booking & Payment</h1>

<p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
<p><strong>Court:</strong> <?= ucfirst($courtType) ?> Court <?= $courtNo ?></p>

<p><strong>Time Slots:</strong></p>
<ul>
<?php foreach ($bookings as $b): ?>
    <li><?= htmlspecialchars($b['time_slot']) ?></li>
<?php endforeach; ?>
</ul>

<p><strong>Total Slots:</strong> <?= count($bookings) ?></p>
<p><strong>Total Amount:</strong> RM<?= $total ?></p>
<p><strong>Status:</strong> <?= $alreadyPaid ? 'Paid' : 'Pending' ?></p>

<?php if (!$alreadyPaid): ?>
<div class="qr-section">
<p>Please make the payment via QR or Bank Transfer:</p>
<img src="/tm_elite_booking/badminton_qr.jpg" alt="TM Elite QR">
<p>Bank: Maybank<br>Account No: 1234567890<br>Account Name: TM Elite Badminton</p>
</div>

<label for="payment_screenshot">Upload Payment Screenshot:</label>
<input type="file" id="payment_screenshot" name="payment_screenshot" accept="image/*" required>

<div class="button-group">
<a href="confirm_booking.php?date=<?= urlencode($date) ?>&court_type=<?= urlencode($courtType) ?>&court_no=<?= urlencode($courtNo) ?><?= $slots_param ?>" class="button back">← Back</a>
<button type="submit" name="pay" class="button">Submit</button>
</div>
<?php else: ?>
<div class="button-group">
<a href="home.php" class="button back">← Back to Home</a>
</div>
<?php endif; ?>

</form>
</div>

</div>

<footer>© 2025 TM Elite Badminton</footer>
</body>
</html>
