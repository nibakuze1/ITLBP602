
<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | LOL School</title>
    <link rel="stylesheet" href="style.css" class="css">
<style>

/* ==============================
   LOL SCHOOL - MODERN DASHBOARD
================================ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f4f7fb;
    color: #263445;
    min-height: 100vh;
}

/* NAVIGATION */

.top-nav {
    background: linear-gradient(120deg, #102b4e, #1765a8);
    padding: 18px 5%;
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.nav-links {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 8px;
}

.nav-links a {
    color: #eaf2fc;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    padding: 11px 15px;
    border-radius: 7px;
    transition: all 0.3s ease;
}

.nav-links a:hover {
    background: rgba(255,255,255,0.18);
    color: white;
    transform: translateY(-2px);
}

.nav-links a.active {
    background: white;
    color: #1765a8;
}

.nav-links a.logout {
    background: #e74c3c;
    color: white;
    margin-left: 10px;
}

.nav-links a.logout:hover {
    background: #c0392b;
}

/* MAIN CONTAINER */

.container {
    width: 90%;
    max-width: 1250px;
    margin: 40px auto;
}

/* PAGE HEADER */

.page-header {
    background: linear-gradient(120deg, #12365d, #2474c8);
    color: white;
    padding: 38px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    box-shadow: 0 8px 25px rgba(26, 86, 150, 0.18);
    position: relative;
    overflow: hidden;
}

.page-header::after {
    content: "";
    position: absolute;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    right: 100px;
    top: -120px;
}

.page-header h1 {
    font-size: 30px;
    margin-bottom: 12px;
    font-weight: 700;
}

.page-header p {
    color: #dceaff;
    font-size: 15px;
    line-height: 1.7;
}

.admin-badge {
    background: white;
    color: #1765a8;
    padding: 12px 22px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: bold;
    text-transform: uppercase;
    box-shadow: 0 3px 10px rgba(0,0,0,0.12);
    white-space: nowrap;
    z-index: 1;
}

/* DASHBOARD SECTION */

.dashboard-section {
    margin-top: 42px;
}

.dashboard-section h2 {
    color: #142d4e;
    font-size: 25px;
    margin-bottom: 10px;
    font-weight: 700;
}

.dashboard-description {
    color: #788797;
    margin-bottom: 28px;
    font-size: 15px;
}

/* DASHBOARD GRID */

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

/* DASHBOARD CARDS */

.dashboard-card {
    background: white;
    padding: 30px 27px;
    border-radius: 15px;
    text-decoration: none;
    color: #263445;
    border: 1px solid #e9eef5;
    box-shadow: 0 5px 18px rgba(25, 55, 90, 0.05);
    transition: all 0.35s ease;
    position: relative;
    overflow: hidden;
}

.dashboard-card::before {
    content: "";
    position: absolute;
    height: 4px;
    width: 0;
    left: 0;
    top: 0;
    background: #2474d2;
    transition: width 0.35s ease;
}

.dashboard-card:hover::before {
    width: 100%;
}

.dashboard-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 14px 30px rgba(25, 75, 130, 0.13);
    border-color: #c9ddf5;
}

/* CARD ICONS */

.dashboard-icon {
    width: 65px;
    height: 65px;
    background: #edf5ff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    font-size: 35px;
    margin-bottom: 22px;
    transition: all 0.35s ease;
}

.dashboard-card:hover .dashboard-icon {
    transform: scale(1.1) rotate(-5deg);
    background: #dcecff;
}

/* CARD CONTENT */

.dashboard-card h3 {
    color: #142d4e;
    font-size: 20px;
    margin-bottom: 12px;
    font-weight: 700;
}

.dashboard-card p {
    color: #788797;
    font-size: 14px;
    line-height: 1.8;
    margin-bottom: 23px;
}

.dashboard-card span {
    color: #2474d2;
    font-weight: 700;
    font-size: 14px;
    transition: 0.3s;
}

.dashboard-card:hover span {
    letter-spacing: 0.5px;
    color: #104b8d;
}

/* FOOTER */

footer {
    text-align: center;
    padding: 25px 15px;
    margin-top: 60px;
    background: #102b4e;
    color: #dceaff;
    font-size: 13px;
}

/* RESPONSIVE TABLETS */

@media (max-width: 1000px) {
    .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .nav-links {
        gap: 5px;
    }

    .nav-links a {
        padding: 10px;
        font-size: 13px;
    }
}

/* RESPONSIVE MOBILE */

@media (max-width: 600px) {

    .top-nav {
        padding: 12px;
    }

    .nav-links {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .nav-links a {
        text-align: center;
        font-size: 12px;
        padding: 12px 5px;
    }

    .nav-links a.logout {
        margin-left: 0;
    }

    .container {
        width: 92%;
        margin: 25px auto;
    }

    .page-header {
        padding: 25px 20px;
        flex-direction: column;
        align-items: flex-start;
    }

    .page-header h1 {
        font-size: 24px;
    }

    .page-header p {
        font-size: 13px;
    }

    .dashboard-section h2 {
        font-size: 22px;
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .dashboard-card {
        padding: 25px;
    }

    footer {
        font-size: 12px;
    }
}

/* SMOOTH SCROLL */

html {
    scroll-behavior: smooth;
}

/* KEYBOARD ACCESSIBILITY */

a:focus-visible {
    outline: 3px solid #69aaff;
    outline-offset: 4px;
}


</style>
</head>

<body>

<nav class="top-nav">

    

    <div class="nav-links">
        <a class="active" href="view.php">Home</a>


        <a class="logout" href="logout.php">Logout</a>
    </div>

</nav>

<main class="container">

    <header class="page-header">
        <div>
            <h1>Welcome to LOL School</h1>

            <p>
                Hello,
                <?= htmlspecialchars($_SESSION['username']) ?>!
                Welcome to your school management dashboard.
            </p>
        </div>

        <div class="admin-badge">
            <?= htmlspecialchars($_SESSION['role'] ?? 'User') ?>
        </div>
    </header>

    <section class="dashboard-section">


        <div class="dashboard-grid">

            <a href="students.php" class="dashboard-card">
                <h3>Students</h3>
                <p>Manage and view student records.</p>
                <span>View Students </span>
            </a>

            <a href="classes.php" class="dashboard-card">
                <h3>Classes</h3>
                <p>Manage school classes and information.</p>
                <span>View Classes </span>
            </a>

            <a href="subjects.php" class="dashboard-card">
                <h3>Subjects</h3>
                <p>Manage subjects offered at school.</p>
                <span>View Subjects →</span>
            </a>

            <a href="grades.php" class="dashboard-card">
                <h3>Grades</h3>
                <p>View and manage student grades.</p>
                <span>View Grades →</span>
            </a>

            <a href="attendance.php" class="dashboard-card">
               
                <h3>Attendance</h3>
                <p>Manage student attendance records.</p>
                <span>View Attendance →</span>
            </a>

            <a href="announcements.php" class="dashboard-card">
                <h3>Announcements</h3>
                <p>Create and view school announcements.</p>
                <span>View Announcements →</span>
            </a>

        </div>

    </section>

</main>

<footer>
    <p>© <?= date('Y') ?> LOL School Management System. All Rights Reserved.</p>
</footer>

</body>
</html>
