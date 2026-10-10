<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TM Elite | About</title>
<link rel="stylesheet" href="style.css?v=10">
<style>
  
/* Mobile adjustments */
@media (max-width: 768px) {
    nav {
        justify-content: center;
    }
}
    /* Additional styles specific for About page */
    .about-section {
        max-width: 1200px;
        margin: 30px auto;
        padding: 0 20px;
    }
    .about-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .facility-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .facility-card {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        text-align: center;
    }
    .facility-card img {
    width: 100%;      /* fill the card width */
    height: 150px;    /* same height for all */
    object-fit: cover; /* crop to fit nicely */
    border-radius: 8px;
}

    .facility-card h3 {
        margin-top: 10px;
        font-size: 18px;
        color: #1e3a8a;
    }
</style>
</head>
<body>

<div class="page-wrapper">
<!-- HEADER -->
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


<!-- BANNER -->
<div class="banner">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h1>About TM Elite</h1>
        <p>Learn more about our centre, facilities, and services</p>
    </div>
</div>

<!-- ABOUT CONTENT -->
<div class="about-section">

    <div class="about-card">
        <h2>Welcome to TM Elite Badminton Centre!</h2>
        <p>
            TM Elite Badminton Centre has been operating since 2007 and is recognised as the first and largest badminton hall in Muallim.
            The centre features 6 rubber badminton courts and 4 cement badminton courts, and has served more than 100,000 players.
            TM Elite is also an authorised Fleet badminton product reseller.
        </p>
        <p><strong>Operating Hours:</strong> 8:00 AM – 12:00 AM (Daily)</p>
        <p><em>One More Athlete, One Less Bad Child</em></p>
    </div>

   <!-- Facilities -->
<div class="about-card">
    <h2>Our Facilities</h2>
    <div class="facility-cards">
        <div class="facility-card">
            <img src="https://5.imimg.com/data5/HC/OA/MY-4972175/badminton-court-yonex-ac360-court-mat-500x500.jpg" alt="Rubber Court">
            <h3>6 Rubber Courts</h3>
        </div>
        <div class="facility-card">
            <img src="https://elitecourt.in/wp-content/uploads/2024/03/Elitecourt-Indoor-Badminton-Court.png" alt="Cement Court">
            <h3>4 Cement Courts</h3>
        </div>
        <div class="facility-card">
            <img src="https://images.unsplash.com/photo-1717659487323-7783a99bcf61?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mzh8fHRvdXJuYW1lbnQlMjBiYWRtaW50b258ZW58MHx8MHx8fDA%3D" alt="Tournament">
            <h3>Tournament</h3>
        </div>
        <div class="facility-card">
            <img src="https://images.unsplash.com/photo-1599474924187-334a4ae5bd3c?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MzB8fGNvYWNoJTIwYmFkbWludG9ufGVufDB8fDB8fHww" alt="Coaching">
            <h3>Coaching Programs</h3>
        </div>
        <div class="facility-card">
            <img src="https://images.unsplash.com/photo-1643525662824-1ff8e2875828?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MzZ8fHJhY2tldCUyMG1hbnl8ZW58MHx8MHx8fDA%3D" alt="Equipment Rental">
            <h3>Racket & Equipment Rental</h3>
        </div>
    </div>
</div>



    <!-- Why Choose Us -->
    <div class="about-card">
        <h2>Why Choose Us?</h2>
        <ul>
            <li>First and largest badminton hall in Muallim</li>
            <li>Professional courts with rubber and cement options</li>
            <li>Trusted by over 100,000 players</li>
            <li>Authorised Fleet badminton reseller</li>
        </ul>
    </div>

    <!-- Contact -->
    <div class="about-card">
        <h2>Contact Us</h2>
        <p>
            Address: Lot 8138, 153G Jalan Ketoyong, Muallim, Perak<br>
            Phone: +60 16-681 7099<br>
            Email: tm.elite0111@gmail.com<br>
           Follow us on social media:
<a href="https://www.facebook.com/profile.php?id=61551747436696" target="_blank">🔵 Facebook</a> |
<a href="https://www.instagram.com/tmelitebadminton/" target="_blank">🟣 Instagram</a>

        </p>

        <!-- Google Map -->
        <div style="margin-top:20px; border-radius:12px; overflow:hidden;">
            <iframe
                src="https://www.google.com/maps?q=LOT+8138+153G+JALAN+KETOYONG+TM+Elite+Badminton+Centre&output=embed"
                width="100%"
                height="300"
                style="border:0;"
                allowfullscreen
                loading="lazy">
            </iframe>
        </div>
    </div>

</div>

<!-- FOOTER -->
<footer>
    © 2025 TM Elite Badminton Centre
</footer>

</div>

</body>
</html>
