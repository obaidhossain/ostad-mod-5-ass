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

    function deleteRoles( $roles, $file ) {
        file_put_contents( $file, json_encode( $roles, JSON_PRETTY_PRINT ) );
        // header("Location: ./roles_delete.php");
    }

if ( isset( $_POST['roles_delete'] ) ) {
    $role = $_POST['role'];
    
    //Validation
    if ( empty( $role ) ) {
        $errorMsg = "Please fill all the fields.";
    } else {
        if ( !isset( $roles[$role] ) ) {
            $errorMsg = "Role not exists.";
        } else {
            // $json = json_decode($status);
            $updatedRoles = [];

            foreach($roles as $key => $value) {
                    if($key != $role) {
                            $updatedRoles[$key] = [];
                    }
            }

            $successMsg = "($role) role removed successfully.";
            deleteRoles( $updatedRoles, $rolesFile );
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
        <form action="./roles_delete.php" method="post">
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
                <!-- <input type="text" name="role" id="role"> -->
                <select name="role" id="role">
                    <?php 
                    foreach($roles as $key => $value) {
                        echo "<option value='$key'>$key</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <input type="submit" name="roles_delete" value="Remove Role">
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
