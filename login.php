<?php
$Email = $Password = "";
$EmailErr = $PasswordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Email"])) {
        $EmailErr = "Email is required*";
    } else {
        $Email = $_POST["Email"];
    }

    if (empty($_POST["Password"])) {
        $PasswordErr = "Password is required*";
    } else {
        $Password = $_POST["Password"];
    }

    if (!empty($Email) && !empty($Password)) {
        include("Connections.php");
        $check_email = mysqli_query($Connections, "SELECT * FROM login_tbl WHERE email = '$Email'");
        $check_email_row = mysqli_num_rows($check_email);
       

        if ($check_email_row > 0) {
            $row = mysqli_fetch_assoc($check_email);
            $db_password = $row["Password"];
            $db_account_type = $row["Account_Type"];
        
            if ($db_password === $Password) {
                if ($db_account_type === "1") {
                    header("Location: Admin.php");
                    exit();
                } else {
                    header("Location: User.php");
                    exit();
                }
            } else {
                $PasswordErr = "Incorrect password!";
            }
        } else {
            $EmailErr = "Email is not registered!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login1.css">
    <title>Login Form</title>
    
</head>
    <body>

        <div class="login-container">
            <center> <h2>Login</h2> </center>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

                <div class="input">
                    <span><?php echo $EmailErr;?></span>
                    <input type="text" placeholder="Email" name="Email" value="<?php echo $Email;?>">
                </div>
                <div class="input">
                    <span><?php echo $PasswordErr;?></span>
                    <input type="password" placeholder="Password" name="Password">
                </div>

                <center> <button type="submit" class="btn">Submit</button> </center>
                
            </form>
        </div>

    </body>
</html>
