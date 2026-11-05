
<?php
$connection = mysqli_connect("localhost", "root", "", "lol_sms");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// SELECT ONE CLASS FOR UPDATE
$class_name = "";
$academic_year = "";
$class_id = "";

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $sql = "SELECT * FROM classes WHERE class_id='$id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $class_id = $row['class_id'];
        $class_name = $row['class_name'];
        $academic_year = $row['academic_year'];
    }
}

// INSERT
if (isset($_POST['addclass'])) {

    $class = $_POST['class_name'];
    $academic = $_POST['academic_year'];

    $sql = "INSERT INTO classes (class_name, academic_year)
            VALUES ('$class', '$academic')";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Class registered successfully');</script>";
    } else {
        echo "Data not inserted";
    }
}

// UPDATE
if (isset($_POST['update'])) {

    $id = $_POST['class_id'];
    $class = $_POST['class_name'];
    $academic = $_POST['academic_year'];

    $sql = "UPDATE classes SET
            class_name='$class',
            academic_year='$academic'
            WHERE class_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Class updated successfully');</script>";
    } else {
        echo "Data not updated";
    }
}

// DELETE
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $sql = "DELETE FROM classes WHERE class_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Class deleted successfully');</script>";
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

    <title>Classes Information</title>

    <link rel="stylesheet" href="style.css">

    <style>
        table {
            width: 80%;
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

        <form action="classes.php" method="POST">

            <h1 style="color: darkblue; font-size: 18px;">
                <u><b>Classes Information</b></u>
            </h1>

            <input type="hidden" name="class_id"
                   value="<?php echo $class_id; ?>">

            <label>Class_Name</label>

            <input type="text" name="class_name"
                   value="<?php echo htmlspecialchars($class_name); ?>"
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

                <input type="submit" value="Register" name="addclass">

            <?php } ?>

        </form>

    </fieldset>

</center>


<!-- SELECT ALL CLASSES -->

<h2 align="center">Registered Classes</h2>

<table>

    <tr>
        <th>Class ID</th>
        <th>Class Name</th>
        <th>Academic Year</th>
        <th>Action</th>
    </tr>

    <?php

    $sql = "SELECT * FROM classes";
    $result = mysqli_query($connection, $sql);
$b=1;
    while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <tr>
 <td><?php echo $b++; 1?></td><br>

        <td><?php echo htmlspecialchars($row['class_name']); ?></td>

        <td><?php echo htmlspecialchars($row['academic_year']); ?></td>

        <td>

            <a class="edit"
               href="classes.php?edit=<?php echo $row['class_id']; ?>">
                Update
            </a>

            <a class="delete"
               href="classes.php?delete=<?php echo $row['class_id']; ?>"
               onclick="return confirm('Are you sure you want to delete this class?')">
                Delete
            </a>

        </td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
