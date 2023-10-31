<?php
session_start();

$usersFile = 'users.json';

$users = file_exists( $usersFile ) ? json_decode( file_get_contents( $usersFile ), true ) : [];

function saveUsers( $users, $file ) {
    file_put_contents( $file, json_encode( $users, JSON_PRETTY_PRINT ) );
}

// Registration Form Handling
if ( isset( $_POST['register'] ) ) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password    = $_POST['password'];
    $role = $_POST['role'];
    
    //Validation
    if ( empty( $username ) || empty( $email ) || empty( $password ) ) {
        $errorMsg = "Please fill  all the fields.";
    } else {
        if ( isset( $users[$email] ) ) {
            $errorMsg = "Email already exists.";
        } else {
            $users[$email] = [
                'username' => $username,
                'password' => $password,
                'role'     => $role,
            ];
    
            saveUsers( $users, $usersFile );
            $_SESSION['email'] = $email;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration | Our Crew Project</title>
  </head>
  <body>
    <div class="container">
      <h2>Registration</h2>
      <form action="./registration.php" method="post">
        <?php
        if ( isset( $errorMsg ) ) {
            echo "<p>$errorMsg</p>";
        }
        ?>
        <div>
          <label for="username">Username</label>
          <input type="text" name="username" id="username" />
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" name="email" id="email" />
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" name="password" id="password" />
        </div>
        <div>
          <input type="hidden" name="role" value="">
          <input type="submit" name="register" value="Register" />
        </div>
      </form>
    </div>
  </body>
</html>
