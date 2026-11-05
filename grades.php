
<?php
$connection = mysqli_connect("localhost", "root", "", "lol_sms");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// SELECT ONE GRADE FOR UPDATE
$student_id = "";
$subject_id = "";
$assessment_type = "";
$marks = "";
$academic_year = "";
$grade_id = "";

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $sql = "SELECT * FROM grades WHERE grade_id='$id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $grade_id = $row['grade_id'];
        $student_id = $row['student_id'];
        $subject_id = $row['subject_id'];
        $assessment_type = $row['assessment_type'];
        $marks = $row['marks'];
        $academic_year = $row['academic_year'];
    }
}

// INSERT
if (isset($_POST['submit'])) {

    $std = $_POST['student_id'];
    $subj = $_POST['subject_id'];
    $type = $_POST['assessment_type'];
    $ma = $_POST['marks'];
    $year = $_POST['academic_year'];

    $sql = "INSERT INTO grades
            (student_id, subject_id, assessment_type, marks, academic_year)
            VALUES ('$std', '$subj', '$type', '$ma', '$year')";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Grade inserted successfully');</script>";
    } else {
        echo "Data not inserted: " . mysqli_error($connection);
    }
}

// UPDATE
if (isset($_POST['update'])) {

    $id = $_POST['grade_id'];
    $std = $_POST['student_id'];
    $subj = $_POST['subject_id'];
    $type = $_POST['assessment_type'];
    $ma = $_POST['marks'];
    $year = $_POST['academic_year'];

    $sql = "UPDATE grades SET
            student_id='$std',
            subject_id='$subj',
            assessment_type='$type',
            marks='$ma',
            academic_year='$year'
            WHERE grade_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Grade updated successfully');</script>";
    } else {
        echo "Data not updated";
    }
}

// DELETE
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $sql = "DELETE FROM grades WHERE grade_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Grade deleted successfully');</script>";
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

    <title>Grades Information</title>

    <link rel="stylesheet" href="style.css">

    <style>
        table {
            width: 95%;
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
            padding: 6px 10px;
            text-decoration: none;
        }

        .delete {
            background: red;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
        }
    </style>

</head>

<body>

<center>

    <fieldset>

        <form action="grades.php" method="POST">

            <h1 style="color: darkblue; font-size: 18px;">
                <b><u>Grades Information</u></b>
            </h1>

            <input type="hidden" name="grade_id"
                   value="<?php echo $grade_id; ?>">

            <label>Student_id</label>

            <input type="number" name="student_id"
                   value="<?php echo htmlspecialchars($student_id); ?>"
                   required>

            <br><br>

            <label>Subject_id</label>

            <input type="number" name="subject_id"
                   value="<?php echo htmlspecialchars($subject_id); ?>"
                   required>

            <br><br>

            <label>Assessment_type</label>

            <input type="text" name="assessment_type"
                   value="<?php echo htmlspecialchars($assessment_type); ?>">

            <br><br>

            <label>Marks</label>

            <input type="number" name="marks" step="0.01"
                   value="<?php echo htmlspecialchars($marks); ?>"
                   required>

            <br><br>

            <label>Academic_year</label>

            <input type="text" name="academic_year"
                   value="<?php echo htmlspecialchars($academic_year); ?>"
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


<!-- SELECT ALL GRADES -->

<h2 align="center">Students Grades Records</h2>

<table>

    <tr>
        <th>Grade ID</th>
        <th>Student ID</th>
        <th>Subject ID</th>
        <th>Assessment Type</th>
        <th>Marks</th>
        <th>Academic Year</th>
        <th>Action</th>
    </tr>

    <?php

    $sql = "SELECT * FROM grades";
    $result = mysqli_query($connection, $sql);
$b=1;
    while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <tr>

       <td><?php echo $b++; 1?></td><br>

        <td><?php echo $row['student_id']; ?></td>

        <td><?php echo $row['subject_id']; ?></td>

        <td><?php echo htmlspecialchars($row['assessment_type']); ?></td>

        <td><?php echo $row['marks']; ?></td>

        <td><?php echo htmlspecialchars($row['academic_year']); ?></td>

        <td>

            <a class="edit"
               href="grades.php?edit=<?php echo $row['grade_id']; ?>">
                Update
            </a>

            <a class="delete"
               href="grades.php?delete=<?php echo $row['grade_id']; ?>"
               onclick="return confirm('Are you sure you want to delete this grade?')">
                Delete
            </a>

        </td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
