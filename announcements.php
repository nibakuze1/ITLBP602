
<?php

$connection = mysqli_connect("localhost", "root", "", "lol_sms");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// SELECT ONE ANNOUNCEMENT FOR UPDATE

$announcement_id = "";
$tittle = "";
$message = "";
$publication_date = "";
$postedby = "";

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $sql = "SELECT * FROM announcements
            WHERE announcement_id='$id'";

    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $announcement_id = $row['announcement_id'];
        $tittle = $row['tittle'];
        $message = $row['message'];
        $publication_date = $row['publication_date'];
        $postedby = $row['postedby'];
    }
}

// INSERT

if (isset($_POST['submit'])) {

    $std = $_POST['tittle'];
    $subj = $_POST['message'];
    $type = $_POST['publication_date'];
    $ma = $_POST['postedby'];
    
    $sql =mysqli_query($connection,"INSERT INTO announcements VALUES
     ('','$std', '$subj', '$type', '$ma')");

    if ($sql) {
        echo "<script>alert('Announcement inserted successfully');</script>";
    } else {
        echo "Data not inserted: " . mysqli_error($connection);
    }
}

// UPDATE

if (isset($_POST['update'])) {

    $id = $_POST['announcement_id'];
    $std = $_POST['tittle'];
    $subj = $_POST['message'];
    $type = $_POST['publication_date'];
    $ma = $_POST['postedby'];

    $sql = "UPDATE announcements SET
            tittle='$std',
            message='$subj',
            publication_date='$type',
            postedby='$ma'
            WHERE announcement_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert('Announcement updated successfully');</script>";
    } else {
        echo "Data not updated";
    }
}

// DELETE

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $sql = "DELETE FROM announcements
            WHERE announcement_id='$id'";

    $statement = mysqli_query($connection, $sql);

    if ($statement) {
        echo "<script>alert(' deleted successfully');</script>";
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

    <title>Announcements Information</title>

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

        <form action="announcements.php" method="POST">

            <h1 style="color: darkblue; font-size: 18px;">
                <b><u>Announcements Information</u></b>
            </h1>

            <input type="hidden" name="announcement_id"
                   value="<?php echo $announcement_id; ?>">

            <label>Title</label>

            <input type="text" name="tittle"
                   value="<?php echo htmlspecialchars($tittle); ?>"
                   required>

            <br><br>

            <label>Message</label>

            <input type="text" name="message"
                   value="<?php echo htmlspecialchars($message); ?>"
                   required>

            <br><br>

            <label>Publication_date</label>

            <input type="date" name="publication_date"
                   value="<?php echo htmlspecialchars($publication_date); ?>"
                   required>

            <br><br>

            <label>Postedby</label>

            <input type="text" name="postedby"
                   value="<?php echo htmlspecialchars($postedby); ?>"
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


<!-- SELECT ALL ANNOUNCEMENTS -->

<h2 align="center">Announcements Records</h2>

<table>

    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Message</th>
        <th>Publication Date</th>
        <th>Posted By</th>
        <th>Action</th>
    </tr>

    <?php

    $sql = "SELECT * FROM announcements";
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <tr>

        <td><?php echo $row['announcement_id']; ?></td>

        <td><?php echo htmlspecialchars($row['tittle']); ?></td>

        <td><?php echo htmlspecialchars($row['message']); ?></td>

        <td><?php echo $row['publication_date']; ?></td>

        <td><?php echo htmlspecialchars($row['postedby']); ?></td>

        <td>

            <a class="edit"
               href="announcements.php?edit=<?php echo $row['announcement_id']; ?>">
                Update
            </a>

            <a class="delete"
               href="announcements.php?delete=<?php echo $row['announcement_id']; ?>"
               onclick="return confirm('Are you sure you want to delete this announcement?')">
                Delete
            </a>

        </td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
