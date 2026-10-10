<?php
include 'db_connect.php';

// Get parameters
$date = $_GET['date'] ?? '';
$slots = $_GET['slots'] ?? [];
$courtType = $_GET['court_type'] ?? '';
$courtNo = $_GET['court_no'] ?? '';

if (!$date || empty($slots) || !$courtType || !$courtNo) {
    die("Missing booking information.");
}

if (isset($_POST['confirm'])) {

    $booking_ids_array = []; // To collect inserted booking IDs

    foreach ($slots as $slot) {

        // Check if the slot is already booked
        $check = $conn->prepare(
            "SELECT id FROM bookings 
             WHERE booking_date=? AND court_type=? AND court_no=? AND time_slot=?"
        );
        $check->bind_param("ssis", $date, $courtType, $courtNo, $slot);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            die("Slot already booked: " . htmlspecialchars($slot));
        }
        $check->close();

        // Insert the booking
        $insert = $conn->prepare(
            "INSERT INTO bookings 
             (booking_date, court_type, court_no, time_slot, payment_status) 
             VALUES (?, ?, ?, ?, 'pending')"
        );
        $insert->bind_param("ssis", $date, $courtType, $courtNo, $slot);
        $insert->execute();

        // Save inserted ID
        $booking_ids_array[] = $insert->insert_id;

        $insert->close();
    }

    // Redirect to payment page with all booking IDs
    $booking_ids = implode(',', $booking_ids_array);
    echo "<script>
          alert('Booking Successful! Proceed to payment.');
          window.location='payment.php?booking_ids=$booking_ids';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TM Elite | Booking Details</title>
    <link rel="stylesheet" href="style.css?v=10">
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f4f6f8; margin: 0; min-height: 100vh; display: flex; flex-direction: column; }
        header { background: #1e3a8a; color: white; padding: 15px 30px; }
        .header-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        nav a { color: white; margin-left: 15px; text-decoration: none; font-weight: 600; }
        nav a.admin-button { padding: 5px 10px; border-radius: 5px; color: #1e3a8a; }
        .container { width: 100%; max-width: 1200px; margin: 30px auto; padding: 0 20px; display: flex; justify-content: center; }
        .card { background: white; padding: 40px; border-radius: 16px; border: 1px solid #e5e7eb; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 700px; }
        .card h2 { margin-top: 0; font-size: 28px; color: #1e3a8a; text-align: center; margin-bottom: 25px; }
        .card p { font-size: 18px; margin: 12px 0; }
        .button { display: inline-block; padding: 10px 25px; background: #2563eb; color: white; border-radius: 8px; font-weight: 600; font-size: 16px; border: none; cursor: pointer; text-decoration: none; transition: background 0.3s; }
        .button:hover { background: #1d4ed8; }
        .button.back { background: #9ca3af; }
        .button-group {
             min-width: 140px; 
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 25px;
}

        footer { background: #e5e7eb; text-align: center; padding: 20px; margin-top: auto; font-size: 14px; }
    </style>
</head>
<body>

<header>
    <div class="header-inner">
        <h1>TM Elite Badminton Centre</h1>

    </div>
</header>

<div class="container">
    <div class="card">
        <h2>Booking Details</h2>
        <p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
        <p><strong>Time Slot(s):</strong></p>
<ul>
<?php foreach ($slots as $s): ?>
    <li><?= htmlspecialchars($s) ?></li>
<?php endforeach; ?>
</ul>
        <p><strong>Court Type:</strong> <?= htmlspecialchars(ucfirst($courtType)) ?></p>
        <p><strong>Court Number:</strong> <?= htmlspecialchars($courtNo) ?></p>

        <form method="POST" class="button-group">
            <a href="availability.php?date=<?= $date ?>&court_type=<?= $courtType ?>" class="button back">← Back</a>
            <button type="submit" name="confirm" class="button">Confirm</button>
        </form>
    </div>
</div>

<footer>
    © 2025 TM Elite Badminton Centre
</footer>

</body>
</html>
