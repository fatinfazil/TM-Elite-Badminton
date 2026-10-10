<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
include 'db_connect.php';

/* UPDATE PAYMENT STATUS */
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $payment_status = $_POST['payment_status'];

    $stmt = $conn->prepare("UPDATE bookings SET payment_status=? WHERE id=?");
    $stmt->bind_param("si", $payment_status, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit;
}

/* DELETE BOOKING */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin.php");
    exit;
}

/* READ BOOKINGS */
$result = $conn->query("SELECT * FROM bookings ORDER BY booking_date DESC, time_slot ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>TM Elite | Admin</title>
<link rel="stylesheet" href="style.css?v=10">

<style>
body {
    background: #f4f6f8;
}

.admin-container {
    max-width: 1600px;
    margin: 40px auto;
    padding: 0 20px;
     flex: 1;
}
/* FOOTER */
footer {
    margin-top: 70px;
    background-color: #e5e7eb;
    padding: 15px;
    text-align: center;
    color: #374151;
}


.table-wrapper {
    overflow-x: auto;
    background: white;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1300px;
}

th, td {
    padding: 12px 10px;
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}

th {
    background: #1e3a8a;
    color: white;
    position: sticky;
    top: 0;
    z-index: 2;
}

tr:hover {
    background: #f1f5f9;
}

.customer-box {
    text-align: left;
    line-height: 1.4;
}

.customer-box strong {
    display: block;
    font-size: 14px;
}

.customer-box span {
    font-size: 13px;
    color: #374151;
    word-break: break-word;
}

select {
    padding: 6px;
    border-radius: 6px;
}

.btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    font-size: 13px;
}

.btn-update {
    background: #2563eb;
    color: white;
}

.btn-delete {
    background: #dc2626;
    color: white;
    text-decoration: none;
}

.action-box {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.screenshot {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
}
/* Hover effect */
nav a:hover {
    color: #ffcc00;
}

/* Active page */
nav a.active {
    background-color: #ff6600; /* only active page is orange */
    border-radius: 5px;
    padding: 6px 10px;
}
</style>
</head>

<body>

<header>
<div class="header-inner">
    <h1>TM Elite Badminton Centre</h1>
    <nav>
        <a href="home.php">Home</a>
        <a href="availability.php">Book Court</a>
        <a href="about.php">About</a>
        <a href="admin.php" class="admin-button active">Admin</a>
        <a href="admin_logout.php" class="admin-button">Logout</a>
    </nav>
</div>
</header>

<div class="admin-container">

<h2 style="text-align:center; margin-bottom:20px;">
Admin – Booking & Payment Management
</h2>

<div class="table-wrapper">
<table>
<tr>
    <th>#</th>
    <th>Date</th>
    <th>Customer</th>
    <th>Court</th>
    <th>Type</th>
    <th>Time Slot</th>
    <th>Payment</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php if ($result->num_rows > 0): $no=1; ?>
<?php while ($row = $result->fetch_assoc()): ?>

<tr>
<td><?= $no++ ?></td>
<td><?= htmlspecialchars($row['booking_date']) ?></td>

<td>
    <div class="customer-box">
        <strong><?= htmlspecialchars($row['customer_name']) ?></strong>
        <span><?= htmlspecialchars($row['customer_phone']) ?></span><br>
        <span><?= htmlspecialchars($row['customer_email']) ?></span>
    </div>
</td>

<td>Court <?= $row['court_no'] ?></td>
<td><?= htmlspecialchars($row['court_type']) ?></td>
<td><?= htmlspecialchars($row['time_slot']) ?></td>

<td>
<?php if ($row['payment_screenshot']): ?>
<a href="uploads/<?= $row['payment_screenshot'] ?>" target="_blank">
<img src="uploads/<?= $row['payment_screenshot'] ?>" class="screenshot">
</a>
<?php else: ?>
No Upload
<?php endif; ?>
</td>

<td>
<form method="POST" class="action-box">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<select name="payment_status">
<option value="pending" <?= $row['payment_status']=='pending'?'selected':'' ?>>Pending</option>
<option value="paid" <?= $row['payment_status']=='paid'?'selected':'' ?>>Paid</option>
</select>
</td>

<td>
<button type="submit" name="update" class="btn btn-update">Update</button>
<a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete booking?')" class="btn btn-delete">Delete</a>
</form>
</td>
</tr>

<?php endwhile; else: ?>
<tr><td colspan="9">No bookings found</td></tr>
<?php endif; ?>
</table>
</div>

</div>

<footer>© 2025 TM Elite Badminton Centre</footer>

</body>
</html>
