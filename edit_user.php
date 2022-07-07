<?php require_once('./includes/header.php') ?>

<div class="container">
    <h2 class="pt-4">User Update</h2>

    <!-- EDIT -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        header("Location: index.php");
    } else {
        $id = $_POST['val'];
        $sql = "SELECT * FROM users WHERE user_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $user['user_id'];
            $user_name = $user['user_name'];
            $user_email = $user['user_email'];
            $user_password = $user['user_password'];
        }
    }
    ?>

    <!-- UPDATE -->
    <?php
    if (isset($_POST['update_user'])) {
        $user_id = $_POST['val'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        if (empty($user_name) || empty($user_email) || empty($user_password)) {
            echo "<div class='alert alert-danger'> Feild can't be blank! </div>";
        } else {
            // update user
            $sql = 'UPDATE users SET user_name = :name, user_email = :email, user_password = :password WHERE user_id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $user_name,
                ':email' => $user_email,
                ':password' => $user_password,
                ':id' => $user_id
            ]);
            header("Location: edit_user.php");
        }
    }
    ?>

    <form action="edit_user.php" method="POST" class="py-2" autocomplete="off">
        <input type="hidden" value="<?php echo $user_id; ?>" name="val">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="user_name" class="form-control" value="<?php echo $user_name; ?>" id="username" placeholder="Desired username">

        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="user_email" class="form-control" value="<?php echo $user_email; ?>" id="email" placeholder="Desired email address">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="user_password" class="form-control" value="<?php echo $user_password; ?>" id="password" placeholder="Enter new password">
        </div>
        <div class="form-group">
            <input type="submit" name="update_user" value="Update" class="btn btn-primary">
            <a class="btn btn-danger" href="index.php">Back</a>
        </div>
    </form>
</div>

<?php require_once('./includes/footer.php') ?>