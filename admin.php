<?php
session_start();
$email = $_SESSION['email'];
$usersFile = 'users.json';
$users = file_exists( $usersFile ) ? json_decode( file_get_contents( $usersFile ), true ) : [];
if(isset($email)) {
    $user = $users[$email]['username'];
    $role = $users[$email]['role'];
    $status = "loggedin";
    $message = "You're logged in now.";
} else {
    $message = "You need to login first.";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel | Our Crew Project</title>
  </head>
  <body>
    <div class="container">
    <?php if ( $status === "loggedin" ) { ?>
      <h2>Welcome <?php echo $user; ?></h2>
      <?php if($role === "admin") { ?>
        <p>Logged in as admin.</p>
        <p>Add Roles <a href="./roles_create.php">Click Here</a></p>
        <p>Edit Roles <a href="./roles_update.php">Click Here</a></p>
        <p>Remove Roles <a href="./roles_delete.php">Click Here</a></p>
      <?php } else if ($role === "subscriber") { ?>
        <p>Hey, How are you today?</p>
      <?php } ?>
      <p><?php echo $message; ?></p>
      <a href='./logout.php'>Logout</a>
    <?php } else {
        echo $message;
        echo "<p><a href='./index.php'>Home</a></p>";
    } ?>
    </div>
  </body>
</html>
