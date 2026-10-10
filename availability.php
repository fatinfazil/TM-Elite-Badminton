<?php
include 'db_connect.php';

/* ===== GET VALUES ===== */
$date = $_GET['date'] ?? date('Y-m-d');
$courtType = $_GET['court_type'] ?? 'rubber';

/* ===== COURT DATA ===== */
$courts = [
    'rubber' => 6,
    'cement' => 4
];

/* ===== TIME SLOTS ===== */
$slots = [
    "8AM - 9AM",
    "9AM - 10AM",
    "10AM - 11AM",
    "11AM - 12PM",
    "12PM - 1PM",
    "1PM - 2PM",
    "2PM - 3PM",
    "3PM - 4PM",
    "4PM - 5PM",
    "5PM - 6PM",
    "6PM - 7PM",
    "7PM - 8PM",
    "8PM - 9PM",
    "9PM - 10PM",
    "10PM - 11PM",
    "11PM - 12AM"
];


/* ===== GET BOOKED SLOTS ===== */
$sql = "SELECT time_slot, court_no FROM bookings 
        WHERE booking_date='$date' AND court_type='$courtType'";
$result = mysqli_query($conn, $sql);

$booked = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booked[$row['court_no']][] = $row['time_slot'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>TM Elite | Book Court</title>
<link rel="stylesheet" href="style.css?v=10">
<style>
/* Keep all your previous CSS as-is */
body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f4f6f8; margin: 0; min-height: 100vh; display: flex; flex-direction: column; }
header { background: #1e3a8a; color: white; padding: 15px 20px; }
.header-inner { display: flex; justify-content: space-between; align-items: center; }
nav a { color: white; margin-left: 15px; text-decoration: none; font-weight: 600; }
nav a.active { color: #ffffffff; }
.filter-form { max-width: 900px; margin: 30px auto; background: white; padding: 20px; border-radius: 12px; display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
.filter-form label { font-weight: 600; color: #1e3a8a; font-size: 14px; }
.filter-form input, .filter-form select { padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d5db; }
.check-btn { background: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; }
.container { max-width: 1000px; margin: 20px auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; flex-grow: 1; }
.card { background: white; padding: 20px; border-radius: 16px; border: 1px solid #e5e7eb; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
.card-title { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
.card-title h3 { margin: 0; font-size: 18px; }
.badge { font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 999px; }
.badge.available { background: #22c55e; color: white; }
.button { appearance: none; -webkit-appearance: none; background: #2563eb; color: white; padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
.button.disabled { background: #9ca3af; cursor: not-allowed; pointer-events: none; }
.toggle-slots { width: 100%; margin-bottom: 10px; }
.slot { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f0f0f0; }
footer { background: #e5e7eb; text-align: center; padding: 15px; }
</style>
</head>
<body>

<header>
<div class="header-inner">
    <h1>TM Elite Badminton Centre</h1>
   <nav>
    <a href="home.php" class="<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>">Home</a>
    <a href="availability.php" class="<?= basename($_SERVER['PHP_SELF']) == 'availability.php' ? 'active' : '' ?>">Book Court</a>
    <a href="about.php" class="<?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>">About</a>
    <a href="admin.php" class="admin-button">Admin</a>
</nav>

</div>
</header>

<form method="GET" class="filter-form">
<div>
    <label>Date</label><br>
    <input type="date" name="date" value="<?= $date ?>">
</div>
<div>
    <label>Court Type</label><br>
    <select name="court_type">
        <option value="rubber" <?= $courtType=='rubber'?'selected':'' ?>>Rubber</option>
        <option value="cement" <?= $courtType=='cement'?'selected':'' ?>>Cement</option>
    </select>
</div>
<button class="check-btn">Check Availability</button>
</form>

<div class="container">
<?php for($i=1; $i<=$courts[$courtType]; $i++): ?>
<div class="card" data-court="<?= $i ?>">
    <div class="card-title">
        <h3><?= ucfirst($courtType) ?> Court <?= $i ?></h3>
        <span class="badge available"><?= ucfirst($courtType) ?></span>
    </div>

    <form method="POST" action="confirm_booking.php?date=<?= $date ?>&court_type=<?= $courtType ?>&court_no=<?= $i ?>">
        <button type="button" class="button toggle-slots">Show Slots</button>
        <div class="slots" style="display:none;"></div>
        <div class="confirm-wrap" style="display:none; text-align:center; margin-top:15px;">
    <button type="submit" name="confirm" class="button">
        Confirm Booking
    </button>
</div>

    </form>
</div>
<?php endfor; ?>
</div>

<footer>© 2025 TM Elite Badminton Centre</footer>

<script>
const slots = <?= json_encode($slots) ?>;
const booked = <?= json_encode($booked) ?>;
const courtType = "<?= $courtType ?>";
const dateVal = "<?= $date ?>";

document.querySelectorAll('.toggle-slots').forEach(btn => {
    btn.addEventListener('click', () => {
       const card = btn.closest('.card');
const slotsDiv = card.querySelector('.slots');   // ✅ ADD THIS LINE
const confirmWrap = card.querySelector('.confirm-wrap');
const courtNo = card.dataset.court;


       if (slotsDiv.style.display === 'block') {
    slotsDiv.style.display = 'none';
    slotsDiv.innerHTML = '';
    confirmWrap.style.display = 'none';
    btn.textContent = 'Show Slots';
    return;
}

        slotsDiv.innerHTML = '';
        slots.forEach(slot => {
            const isBooked = booked[courtNo] && booked[courtNo].includes(slot);

            const div = document.createElement('div');
            div.className = 'slot';
            div.innerHTML = `
                <span>${slot}</span>
                ${isBooked
                    ? '<button class="button disabled">Booked</button>'
                    : `<input type="checkbox" name="slots[]" value="${slot}" />`
                }
            `;
            slotsDiv.appendChild(div);
        });

       slotsDiv.style.display = 'block';
confirmWrap.style.display = 'block';
btn.textContent = 'Hide Slots';

    });
});
</script>
<script>
document.querySelectorAll('form[action^="confirm_booking.php"]').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const checkedSlots = form.querySelectorAll('input[name="slots[]"]:checked');

        if (checkedSlots.length === 0) {
            alert('Please select at least one time slot.');
            return;
        }

        const url = new URL(form.action);

        checkedSlots.forEach(cb => {
            url.searchParams.append('slots[]', cb.value);
        });

        window.location.href = url.toString();
    });
});
</script>


</body>
</html>
