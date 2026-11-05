<?php
// Database connection for the existing lol_sms database.
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect("localhost", "root", "", "lol_sms");
if (!$conn) {
    die("Database connection failed. Check that MySQL is running and the lol_sms database exists.");
}
mysqli_set_charset($conn, "utf8mb4");
?>
