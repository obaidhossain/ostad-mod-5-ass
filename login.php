<?php
session_start();

$usersFile = 'users.json';

$users = file_exists( $usersFile ) ? json_decode( file_get_contents( $usersFile ), true ) : [];

// Registration Form Handling
if ( isset( $_POST['login'] ) ) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    //Validation
    if ( empty( $email ) || empty( $password ) ) {
        $errorMsg = "Please fill  all the fields.";
    } else {
        if ( isset( $users[$email] ) ) {
            if($password === $users[$email]['password']) {
                $_SESSION['email'] = $email;
                header( 'Location: ./admin.php' );
            } else {
                $errorMsg = "Wrong credentials!";
            }
        } else {
            $errorMsg = "Wrong credentials!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Our Crew Project</title>
  </head>
  <body>
    <div class="container">
      <h2>Login</h2>
      <form action="./login.php" method="post">
        <?php
        if ( isset( $errorMsg ) ) {
            echo "<p>$errorMsg</p>";
        }
        ?>      
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" />
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" />
        </div>
        <div>
            <input type="submit" name="login" value="Login" />    
        </div>
      </form>
    </div>
  </body>
</html>
