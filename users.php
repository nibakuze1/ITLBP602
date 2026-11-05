
<?php
$conn = mysqli_connect("localhost", "root", "", "lol_sms");

$message = "";

if (!$conn) {
    die("Database connection failed!");
}

// INSERT USER
if (isset($_POST['save'])) {

    $a = trim($_POST['username']);
    $b = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $c = $_POST['role'];

    $check = mysqli_prepare($conn,
        "SELECT user_id FROM users WHERE user_name = ?"
    );

    mysqli_stmt_bind_param($check, "s", $a);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {

        $message = "Username already exists!";

    } else {

        $sql = mysqli_prepare($conn,
            "INSERT INTO users (user_name, password, role)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param($sql, "sss", $a, $b, $c);

        if (mysqli_stmt_execute($sql)) {
            $message = "User registered successfully!";
            
    header("Location: login.php");
        } else {
            $message = "Registration failed!";
        }

        mysqli_stmt_close($sql);
    }

    mysqli_stmt_close($check);
}

// DELETE USER
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $delete = mysqli_prepare($conn,
        "DELETE FROM users WHERE user_id = ?"
    );

    mysqli_stmt_bind_param($delete, "i", $id);
    mysqli_stmt_execute($delete);
    mysqli_stmt_close($delete);

    header("Location: users.php");
    exit;
}

// UPDATE USER
if (isset($_POST['update'])) {

    $id = intval($_POST['user_id']);
    $username = trim($_POST['username']);
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {

        $password = password_hash(
            $_POST['password'], PASSWORD_DEFAULT
        );

        $update = mysqli_prepare($conn,
            "UPDATE users
             SET user_name = ?, password = ?, role = ?
             WHERE user_id = ?"
        );

        mysqli_stmt_bind_param(
            $update, "sssi",
            $username, $password, $role, $id
        );

    } else {

        $update = mysqli_prepare($conn,
            "UPDATE users
             SET user_name = ?, role = ?
             WHERE user_id = ?"
        );

        mysqli_stmt_bind_param(
            $update, "ssi",
            $username, $role, $id
        );
    }

    if (mysqli_stmt_execute($update)) {
        header("Location: users.php");
        exit;
    }

    $message = "Update failed!";
    mysqli_stmt_close($update);
}

// GET USER FOR EDIT
$editUser = null;

if (isset($_GET['edit'])) {

    $id = intval($_GET['edit']);

    $edit = mysqli_prepare($conn,
        "SELECT user_id, user_name, role
         FROM users WHERE user_id = ?"
    );

    mysqli_stmt_bind_param($edit, "i", $id);
    mysqli_stmt_execute($edit);

    $resultEdit = mysqli_stmt_get_result($edit);
    $editUser = mysqli_fetch_assoc($resultEdit);

    mysqli_stmt_close($edit);
}

// VIEW USERS
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY user_id ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Users | LOL School</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #f1f5f9;
    min-height: 100vh;
}

.top-nav {
    background: #172554;
    padding: 18px;
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.top-nav a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.top-nav a:hover {
    color: #38bdf8;
}

.container {
    padding: 35px 15px;
    max-width: 1100px;
    margin: auto;
}

fieldset {
    max-width: 450px;
    margin: auto;
    border: none;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

h1, h2 {
    text-align: center;
    color: #172554;
    margin-bottom: 15px;
}

.subtitle {
    text-align: center;
    color: #64748b;
    margin-bottom: 25px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #334155;
}

input, select {
    width: 100%;
    padding: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 7px;
    margin-bottom: 18px;
    font-size: 15px;
}

button {
    width: 100%;
    padding: 13px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 7px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #1e40af;
}

.message {
    text-align: center;
    color: green;
    margin-bottom: 15px;
    font-weight: bold;
}

.table-container {
    margin-top: 40px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
}

th {
    background: #172554;
    color: white;
    padding: 14px;
}

td {
    padding: 13px;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
}

tr:hover {
    background: #f8fafc;
}

.edit {
    background: #16a34a;
    color: white;
    padding: 7px 12px;
    text-decoration: none;
    border-radius: 5px;
}

.delete {
    background: #dc2626;
    color: white;
    padding: 7px 12px;
    text-decoration: none;
    border-radius: 5px;
}

.footer {
    text-align: center;
    color: #64748b;
    margin-top: 20px;
    font-size: 13px;
}

@media(max-width: 500px) {
    .top-nav {
        gap: 15px;
    }

    fieldset {
        padding: 20px;
    }
}

</style>
</head>

<body>


<div class="container">

<fieldset>

<h1>User Registration</h1>

<p class="subtitle">LOL School Management System</p>

<?php if ($message != ''): ?>
    <p class="message">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form method="POST" action="">

    <label>Username</label>

    <input type="text" name="username"
    placeholder="Enter username"
    required>

    <label>Password</label>

    <input type="password" name="password"
    placeholder="<?= $editUser ? 'Leave blank to keep old password' : 'Enter password' ?>"
    <?= $editUser ? '' : 'required' ?>>

    <label>Select Role</label>

    <select name="role" required>

        <option value="">-- Select Role --</option>

        <option value="admin"
        <?= ($editUser['role'] ?? '') == 'admin' ? 'selected' : '' ?>>
        Admin</option>

        <option value="teacher"
        <?= ($editUser['role'] ?? '') == 'teacher' ? 'selected' : '' ?>>
        Teacher</option>

        <option value="student"
        <?= ($editUser['role'] ?? '') == 'student' ? 'selected' : '' ?>>
        Student</option>

    </select>

    <?php if ($editUser): ?>

        <input type="hidden" name="user_id"
        value="<?= $editUser['user_id'] ?>">

        <button type="submit" name="update">
            Update User
        </button>

        <br><br>

        <a href="users.php">Cancel Edit</a>

    <?php else: ?>

        <button type="submit" name="save">
            Register User
        </button>

    <?php endif; ?>

</form>

<p class="footer">

</p>

</fieldset>


<!-- USERS TABLE -->

<div class="table-container">

<h2>Registered Users</h2>

<table>

<thead>
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Role</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php if (mysqli_num_rows($result) > 0): ?>

<?php while ($row = mysqli_fetch_assoc($result)): ?>

<tr>

    <td><?= $row['user_id'] ?></td>

    <td>
        <?= htmlspecialchars($row['user_name']) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['role']) ?>
    </td>

    <td>

        <a class="edit"
        href="users.php?edit=<?= $row['user_id'] ?>">
        Edit</a>

        <a class="delete"
        href="users.php?delete=<?= $row['user_id'] ?>"
        onclick="return confirm('Are you sure you want to delete this user?')">
        Delete</a>

    </td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>
    <td colspan="4">No users registered yet.</td>
</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</body>
</html>
