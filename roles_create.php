<?php
session_start();
$email = $_SESSION['email'];
$usersFile = 'users.json';
$users = file_exists( $usersFile ) ? json_decode( file_get_contents( $usersFile ), true ) : [];
$user = $users[$email]['username'];
$role = $users[$email]['role'];
if(isset($email) && $role === 'admin') {
    $status = "loggedin";
    $message = "You're logged in now.";

    $rolesFile = 'roles.json';
    $roles = file_exists( $rolesFile ) ? json_decode( file_get_contents( $rolesFile ), true ) : [];

    function saveRoles( $roles, $file ) {
        file_put_contents( $file, json_encode( $roles, JSON_PRETTY_PRINT ) );
    }

if ( isset( $_POST['roles_create'] ) ) {
    $role = $_POST['role'];
    
    //Validation
    if ( empty( $role ) ) {
        $errorMsg = "Please fill all the fields.";
    } else {
        if ( isset( $roles[$role] ) ) {
            $errorMsg = "Role already exists.";
        } else {
            $roles[$role] = [];
            $successMsg = "($role) role created successfully.";
            saveRoles( $roles, $rolesFile );
        }
    }
}

} else {
    $message = "You are not allowed here.";
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
        <form action="./roles_create.php" method="post">
            <?php
            if ( isset( $errorMsg ) ) {
                echo "<p>$errorMsg</p>";
            }
            if ( isset( $successMsg ) ) {
                echo "<p>$successMsg</p>";
            }
            ?>
            <div>
                <label for="role">Role</label>
                <input type="text" name="role" id="role">
            </div>
            <div>
                <input type="submit" name="roles_create" value="Add Role">
            </div>
        </form>
        <p><?php echo $message; ?></p>
        <a href='./logout.php'>Logout</a>
    <?php } else {
        echo $message;
        echo "<p><a href='./index.php'>Home</a></p>";
    } ?>
    </div>
  </body>
</html>
