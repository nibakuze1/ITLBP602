
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Management</title>
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
            background-color: darkblue;
            color: white;
        }

        .edit {
            background: green;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
        }

        .delete {
            background: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
        }
    </style>
</head>

<body>

<center>
    <fieldset>

        <form action="subjects.php" method="POST">

            <h1 style="color: darkblue; font-size: 18px;">
                <u><b>Subject Information</b></u>
            </h1>

            <?php
            $connection = mysqli_connect("localhost", "root", "", "lol_sms");

            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // SELECT ONE SUBJECT FOR UPDATE
            $subject_name = "";
            $subject_code = "";
            $subject_id = "";

            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];

                $sql = "SELECT * FROM subjects WHERE subject_id='$id'";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    $subject_id = $row['subject_id'];
                    $subject_name = $row['subject_name'];
                    $subject_code = $row['subject_code'];
                }
            }
            ?>

            <input type="hidden" name="subject_id"
                   value="<?php echo $subject_id; ?>">

            <label>Subject_Name</label>

            <input type="text" name="subject_name"
                   value="<?php echo htmlspecialchars($subject_name); ?>"
                   required>

            <br><br>

            <label>Subject_code</label>

            <input type="text" name="subject_code"
                   value="<?php echo htmlspecialchars($subject_code); ?>"
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


<?php

// INSERT
if (isset($_POST['submit'])) {

    $subject = $_POST['subject_name'];
    $code = $_POST['subject_code'];

    $sql = "INSERT INTO subjects (subject_name, subject_code)
            VALUES ('$subject', '$code')";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "Data has been inserted successfully";
    } else {
        echo "Data not inserted";
    }
}


// UPDATE
if (isset($_POST['update'])) {

    $id = $_POST['subject_id'];
    $subject = $_POST['subject_name'];
    $code = $_POST['subject_code'];

    $sql = "UPDATE subjects SET
            subject_name='$subject',
            subject_code='$code'
            WHERE subject_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "Data updated successfully";
    } else {
        echo "Data not updated";
    }
}


// DELETE
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $sql = "DELETE FROM subjects WHERE subject_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "Data deleted successfully";
    } else {
        echo "Data not deleted";
    }
}

?>

<!-- SELECT ALL SUBJECTS -->

<h2 align="center">Subject Records</h2>

<table>

    <tr>
        <th>Subject ID</th>
        <th>Subject Name</th>
        <th>Subject Code</th>
        <th>Action</th>
    </tr>

    <?php

    $sql = "SELECT * FROM subjects";
    $result = mysqli_query($connection, $sql);
$a=1;
    while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <tr>

         <td><?php echo $a++; 1?></td><br>
        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>

        <td><?php echo htmlspecialchars($row['subject_code']); ?></td>

        <td>

            <a class="edit"
               href="subjects.php?edit=<?php echo $row['subject_id']; ?>">
                Update
            </a>

            <a class="delete"
               href="subjects.php?delete=<?php echo $row['subject_id']; ?>"
               onclick="return confirm('Are you sure you want to delete?')">
                Delete
            </a>

        </td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
