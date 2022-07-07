<?php require_once('./includes/header.php') ?>

<div class="container">

  <!-- CEATE -->
  <?php
  if (isset($_POST['addUser'])) {
    $user_name = trim($_POST['username']);
    $user_email = trim($_POST['email']);
    $user_password = "SECRETKEY";

    if (empty($user_name) || empty($user_email)) {
      $error = true;
    } else {
      // add new user
      $sql = "INSERT INTO users(user_name, user_email, user_password) VALUES(:name, :email, :password)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':name' => $user_name,
        ':email' => $user_email,
        ':password' => $user_password,
      ]);
      header("Location: index.php");
    }
  }
  ?>

  <!-- DELETE -->
  <?php
  if (isset($_POST['deleteUser'])) {
    $id = $_POST['val'];
    $sql = "DELETE FROM users WHERE user_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);
  }
  ?>

  <form action="index.php" method="POST" class="py-4">
    <div class="row">
      <div class="col">
        <input type="text" name="username" class="form-control" placeholder="Username">
      </div>
      <div class="col">
        <input type="text" name="email" class="form-control" placeholder="Email Address">
      </div>
      <div class="col">
        <input type="submit" name="addUser" class="form-control btn btn-secondary" value="Add New User">
        <?php echo isset($error) ? "<p class='text-danger'>Feild can't be blank</p>" : ""; ?>
      </div>
    </div>
  </form>

  <!-- READ -->
  <h2 class="text-center mt-4">Simple PDO User CRUD</h2>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = 'SELECT * FROM users';
      $stmt = $pdo->prepare($sql);
      $stmt->execute();

      while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $user['user_id'];
        $user_name = $user['user_name'];
        $user_email = $user['user_email']; ?>

        <tr>
          <th> <?php echo $user_id; ?> </th>
          <td><?php echo $user_name; ?></td>
          <td><?php echo $user_email; ?></td>
          <td>
            <form action="edit_user.php" method="POST">
              <input type="hidden" value="<?php echo $user_id; ?>" name="val">
              <input type="submit" name="submit" value="Edit" class="btn btn-primary">
            </form>
          <td>
            <form action="index.php" method="POST">
              <input type="hidden" value="<?php echo $user_id; ?>" name="val">
              <input type="submit" name="deleteUser" value="Delete" class="btn btn-danger">
            </form>
          </td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>

<?php require_once('./includes/footer.php') ?>