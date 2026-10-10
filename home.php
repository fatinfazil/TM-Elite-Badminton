<!DOCTYPE html>
<html>
<head>
    <title>TM Elite | Home</title>
    <link rel="stylesheet" href="style.css?v=10">
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
        <h1>Ready to Play? Book Your Court</h1>
        <p>Indoor Badminton & Pickleball at TM Elite</p>
        <a href="availability.php" class="banner-button">Book Now</a>
    </div>
</div>


<!-- WELCOME SECTION -->
<div class="container">
    <div class="card welcome-card">
        <div class="card-content">
            <h2>Welcome to TM Elite Badminton Centre!</h2>
            <p>
                TM Elite provides indoor badminton and pickleball courts for players of all levels.
                Users can easily check court availability and book courts online.
            </p>
            <p><strong>Operating Hours:</strong> 8:00 AM – 12:00 AM (Daily)</p>
        </div>
    </div>
</div>

<!-- SPORTS CARDS -->
<div class="container">

    <!-- BADMINTON -->
    <div class="card">
        <img src="/tm_elite_booking/badminton.jpg" alt="Badminton Court">
        <div class="card-content">

            <div class="card-title">
                <h3>🏸 Badminton</h3>
                <span class="badge available">Available</span>
            </div>

            <p>Indoor Badminton Court</p>
            <a class="button" href="availability.php?sport=badminton">Book Now</a>
        </div>
    </div>

    <!-- PICKLEBALL -->
    <div class="card">
        <img src="pickleball.jpg" alt="Pickleball Court">
        <div class="card-content">

            <div class="card-title">
                <h3>🎾 Pickleball</h3>
                <span class="badge available">Available</span>
            </div>

            <p>Modern Pickleball Court</p>
            <a class="button" href="availability.php?sport=pickleball">Book Now</a>
        </div>
    </div>
</div>
<!-- LIVE TOURNAMENTS -->
<div class="live-section">
    <h2>Upcoming Tournaments</h2>
    <div class="live-cards">

        <!-- Card 1 -->
        <div class="live-card">
            <div class="card-title-bar">Match 1</div>
            <div class="card-header">
                <h3>PLAYER A <span>VS</span> PLAYER B</h3>
            </div>
            <span class="badge singles">Singles</span>
            <hr>
            <p><i class="fa fa-clock-o"></i> 04 Jan 2026, Sunday 9:30AM - 11:00AM</p>
            <p><i class="fa fa-money"></i> RM50 per player</p>
        </div>

        <!-- Card 2 -->
        <div class="live-card">
            <div class="card-title-bar">Match 2</div>
            <div class="card-header">
                <h3>TEAM X <span>VS</span> TEAM Y</h3>
            </div>
            <span class="badge doubles">Doubles</span>
            <hr>
            <p><i class="fa fa-clock-o"></i> 10 Jan 2026, Saturday 2:00PM - 4:00PM</p>
            <p><i class="fa fa-money"></i> RM100 per team</p>
        </div>

        <!-- Card 3 -->
        <div class="live-card">
            <div class="card-title-bar">Match 3</div>
            <div class="card-header">
                <h3>Kak Zah <span>VS</span> ?</h3>
            </div>
            <span class="badge singles">Singles</span>
            <hr>
            <p><i class="fa fa-clock-o"></i> 11 Jan 2026, Sunday 10:00AM - 11:30AM</p>
            <p><i class="fa fa-money"></i> RM50 per player</p>
        </div>

        <!-- Card 4 -->
        <div class="live-card">
            <div class="card-title-bar">Match 4</div>
            <div class="card-header">
                <h3>Shuttle Warriors <span>VS</span> ?</h3>
            </div>
            <span class="badge doubles">Doubles</span>
            <hr>
            <p><i class="fa fa-clock-o"></i> 17 Jan 2026, Saturday 3:00PM - 5:00PM</p>
            <p><i class="fa fa-money"></i> RM100 per team</p>
        </div>

    </div>
</div>

<style>
.live-section h2 {
    text-align: center;
    color: #1e3a8a;
    margin-bottom: 30px;
    font-size: 28px;
}

.live-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.live-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    width: 280px;
    padding: 0;
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.live-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 28px rgba(0,0,0,0.12);
}

.card-title-bar {
    background-color: #1e3a8a;  /* this is the background */
    color: white;
    font-weight: 700;
    padding: 8px 0;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    font-size: 16px;
}

.card-header {
    padding: 12px 0;
}

.card-header h3 {
    font-size: 18px;
    color: #1e3a8a;
    margin: 0;
}

.card-header h3 span {
    color: #d90101ff;
    margin: 0 6px;
}

/* Badge Styling - smaller, centered under VS */
.badge {
    display: inline-block;
    text-align: center;
    margin: 6px auto 10px auto;
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 10px;
    font-weight: 600;
    color: white;
}

.badge.singles { background-color: #6083cdff; } /* blue */
.badge.doubles { background-color: #6083cdff; } /* blue */

.live-card hr {
    border: none;
    border-top: 1px solid #e5e7eb;
    margin: 10px 0;
}

.live-card p {
    font-size: 14px;
    margin: 6px 0;
    color: #374151;
    line-height: 1.4;
}
/* Sport card badges (Available) - stay inline with title */
.card-title .badge.available {
    display: inline-block;
    font-size: 12px;      /* normal size */
    padding: 3px 10px;    /* normal padding */
    border-radius: 12px;  /* pill shape */
    .badge.available 
    background-color: #dcfce7;
    color: #166534;
    margin-left: 240px;     /* spacing from title */
    vertical-align: middle; /* aligns with text */
}

/* Tournament badges (Singles/Doubles) - small, centered under VS */
.live-card .badge {
    display: inline-block;
    text-align: center;
    margin: 6px auto 10px auto;
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 10px;
    font-weight: 600;
    color: white;
}

.badge.singles { background-color: #2563eb; } /* blue */
.badge.doubles { background-color: #16a34a; } /* green */


/* Responsive */
@media (max-width: 768px) {
    .live-cards {
        flex-direction: column;
        align-items: center;
    }
    .live-card {
        width: 90%;
    }
}
</style>



<!-- FOOTER -->
<footer>
    © 2025 TM Elite Badminton Centre
</footer>

</body>
</html>
