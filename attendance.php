
<?php

$connection = mysqli_connect("localhost", "root", "", "lol_sms");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// SELECT ONE ATTENDANCE FOR UPDATE

$attendance_id = "";
$student_id = "";
$date = "";
$attendance_status = "";

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $sql = "SELECT * FROM attendance WHERE attendance_id='$id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $attendance_id = $row['attendance_id'];
        $student_id = $row['student_id'];
        $date = $row['date'];
        $attendance_status = $row['attendance_status'];
    }
}

// INSERT

if (isset($_POST['submit'])) {

    $std = $_POST['student_id'];
    $typ = $_POST['date'];
    $status = $_POST['attendance_status'];

    $sql = "INSERT INTO attendance
            (student_id, date, attendance_status)
            VALUES ('$std', '$typ', '$status')";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Attendance inserted successfully');</script>";
    } else {
        echo "Data not inserted: " . mysqli_error($connection);
    }
}

// UPDATE

if (isset($_POST['update'])) {

    $id = $_POST['attendance_id'];
    $std = $_POST['student_id'];
    $typ = $_POST['date'];
    $status = $_POST['attendance_status'];

    $sql = "UPDATE attendance SET
            student_id='$std',
            date='$typ',
            attendance_status='$status'
            WHERE attendance_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Attendance updated successfully');</script>";
    } else {
        echo "Data not updated";
    }
}

// DELETE

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $sql = "DELETE FROM attendance WHERE attendance_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Attendance deleted successfully');</script>";
    } else {
        echo "Data not deleted";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Attendance Information</title>

    <link rel="stylesheet" href="style.css">

    <style>

        table {
            width: 85%;
            margin: 30px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background: darkblue;
            color: white;
        }

        .edit {
            background: green;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
        }

        .delete {
            background: red;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
        }

    </style>

</head>

<body>

<center>

    <fieldset>

        <form action="attendance.php" method="POST">

            <h1 style="color: darkblue; font-size: 18px;">
                <b><u>Attendance Information</u></b>
            </h1>

            <input type="hidden" name="attendance_id"
                   value="<?php echo $attendance_id; ?>">

            <label>Student_id</label>

            <input type="number" name="student_id"
                   value="<?php echo htmlspecialchars($student_id); ?>"
                   required>

            <br><br>

            <label>Date</label>

            <input type="date" name="date"
                   value="<?php echo htmlspecialchars($date); ?>"
                   required>

            <br><br>

            <label>Attendance_Status</label>

            <input type="text" name="attendance_status"
                   value="<?php echo htmlspecialchars($attendance_status); ?>"
                   required>

            <br><br>

            <?php if (isset($_GET['edit'])) { ?>

                <input type="submit" value="Update" name="update">

            <?php } else { ?>

                <input type="submit" value="Submit" name="submit">

            <?php } ?>

        </form>

    </fieldset>

</center>


<!-- SELECT ALL ATTENDANCE RECORDS -->

<h2 align="center">Attendance Records</h2>

<table>

    <tr>
        <th>Attendance ID</th>
        <th>Student ID</th>
        <th>Date</th>
        <th>Attendance Status</th>
        <th>Action</th>
    </tr>

    <?php

    $sql = "SELECT * FROM attendance";
    $result = mysqli_query($connection, $sql);
$b=1;
    while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <tr>
         <td><?php echo $b++; 1?></td><br>

        <td><?php echo $row['student_id']; ?></td>

        <td><?php echo $row['date']; ?></td>

        <td><?php echo htmlspecialchars($row['attendance_status']); ?></td>

        <td>

            <a class="edit"
               href="attendance.php?edit=<?php echo $row['attendance_id']; ?>">
                Update
            </a>

            <a class="delete"
               href="attendance.php?delete=<?php echo $row['attendance_id']; ?>"
               onclick="return confirm('Are you sure you want to delete this attendance?')">
                Delete
            </a>

        </td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
