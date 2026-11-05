
<?php
require_once 'auth.php';

$connection = mysqli_connect("localhost", "root", "", "lol_sms");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$message = "";

// DELETE STUDENT
if (isset($_POST['delete'])) {
    $id = $_POST['student_id'];

    $stmt = mysqli_prepare($connection,
        "DELETE FROM students WHERE student_id = ?");

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Student deleted successfully!";
    } else {
        $message = "Student not deleted!";
    }
}

// UPDATE STUDENT
if (isset($_POST['update'])) {

    $id = $_POST['student_id'];
    $admin = $_POST['adminission_number'];
    $stname = $_POST['names'];
    $gen = $_POST['gender'];
    $dat = $_POST['date_of_birth'];
    $phone = $_POST['phone_number'];
    $addr = $_POST['adress'];
    $clas = $_POST['class_id'];

    $stmt = mysqli_prepare($connection,
        "UPDATE students SET adminission_number=?,
        names=?, gender=?, date_of_birth=?,
        phone_number=?, adress=?, class_id=?
        WHERE student_id=?");

    mysqli_stmt_bind_param($stmt, "ssssssii",
        $admin, $stname, $gen, $dat,
        $phone, $addr, $clas, $id);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Student updated successfully!";
    } else {
        $message = "Update failed!";
    }
}

// ADD STUDENT
if (isset($_POST['submit'])) {

    $admin = $_POST['adminission_number'];
    $stname = $_POST['names'];
    $gen = $_POST['gender'];
    $dat = $_POST['date_of_birth'];
    $phone = $_POST['phone_number'];
    $addr = $_POST['adress'];
    $clas = $_POST['class_id'];

    $stmt = mysqli_prepare($connection,
        "INSERT INTO students
        (adminission_number, names, gender, date_of_birth,
        phone_number, adress, class_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, "ssssssi",
        $admin, $stname, $gen, $dat,
        $phone, $addr, $clas);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Student added successfully!";
    } else {
        $message = "Student not added!";
    }
}

// GET STUDENT FOR EDITING
$editStudent = null;

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $stmt = mysqli_prepare($connection,
        "SELECT * FROM students WHERE student_id=?");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $resultEdit = mysqli_stmt_get_result($stmt);
    $editStudent = mysqli_fetch_assoc($resultEdit);
}

// DISPLAY ALL STUDENTS
$result = mysqli_query($connection,
    "SELECT * FROM students ORDER BY student_id ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Students Management</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        .top-nav {
            background: darkblue;
            padding: 15px;
            text-align: center;
        }

        .top-nav a {
            color: white;
            text-decoration: none;
            margin: 15px;
        }

        fieldset {
            background: white;
            width: 450px;
            margin: 25px auto;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 20px;
        }

        input {
            padding: 9px;
            margin: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
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
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 5px;
        }

        .delete {
            background: red;
            color: white;
            padding: 7px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .message {
            text-align: center;
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>

<nav class="top-nav">
    <a href="students.php">Students</a>
    <a href="classes.php">Classes</a>
    <a href="subjects.php">Subjects</a>
    <a href="logout.php">Logout</a>
</nav>

<h2 align="center">LOL SCHOOL - STUDENTS MANAGEMENT</h2>

<?php if ($message != "") { ?>
    <p class="message">
        <?php echo htmlspecialchars($message); ?>
    </p>
<?php } ?>

<!-- ADD OR UPDATE FORM -->

<fieldset>

    <h3 align="center">
        <?php echo $editStudent ? "Update Student Information" : "Add Student Information"; ?>
    </h3>

    <form action="students.php" method="POST">

    <label>Admission Number</label><br>
    <input type="text" name="adminission_number" required><br><br>

    <label>Names</label><br>
    <input type="text" name="names" required><br><br>

    <label>Gender</label><br>
    <input type="radio" name="gender" value="Male" required> Male

    <input type="radio" name="gender" value="Female"> Female
    <br><br>

    <label>Date Of Birth</label><br>
    <input type="date" name="date_of_birth" required><br><br>

    <label>Phone Number</label><br>
    <input type="text" name="phone_number" required><br><br>

    <label>Address</label><br>
    <input type="text" name="adress" required><br><br>

    <label>Class ID</label><br>
    <input type="number" name="class_id" required><br><br>

    <button type="submit" name="submit">Save Student</button>

</form>

        <?php if ($editStudent) { ?>

            <input type="submit" name="update" value="UPDATE">

            <a href="students.php">Cancel</a>

        <?php } else { ?>

            <input type="submit" name="submit" value="SEND">

        <?php } ?>

    </form>

</fieldset>


<!-- STUDENTS RECORDS TABLE -->

<h2 align="center">STUDENTS RECORDS</h2>

<table>

    <tr>
        <th>ID</th>
        <th>Admission No</th>
        <th>Names</th>
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Class ID</th>
        <th>Actions</th>
    </tr>
    <?php
    
$b=1; 
    while ($row = mysqli_fetch_assoc($result)) { ?>

    <tr>
        <td><?php echo $b++;?></td>

        <td><?php echo htmlspecialchars($row['adminission_number']); ?></td>

        <td><?php echo htmlspecialchars($row['names']); ?></td>

        <td><?php echo htmlspecialchars($row['gender']); ?></td>

        <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>

        <td><?php echo htmlspecialchars($row['phone_number']); ?></td>

        <td><?php echo htmlspecialchars($row['adress']); ?></td>

        <td><?php echo htmlspecialchars($row['class_id']); ?></td>

        <td>
            <a class="edit"
            href="students.php?edit=<?php echo $row['student_id']; ?>">
                Update
            </a>

            <form method="POST" action="students.php"
            style="display:inline;"
            onsubmit="return confirm('Are you sure you want to delete this student?');">

                <input type="hidden" name="student_id"
                value="<?php echo $row['student_id']; ?>">

                <button type="submit" name="delete" class="delete">
                    Delete
                </button>

            </form>
        </td>
    </tr>

    <?php } ?>

</table>

</body>
</html>
