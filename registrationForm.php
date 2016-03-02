<?php

$er='';
$mail = '';
$uname = '';
$sname = '';
$phone = '';
$adress = '';

if (isset($_POST['signup'])) {

    $check = Db::userExist($_POST['email']);
//checking is email unique
    if ($check) {
        echo 'email alredy registered';
    } else {
        $mail = htmlspecialchars($_POST['email'], ENT_QUOTES);
        $pass = md5($_POST['pass']);
        $uname = htmlspecialchars($_POST['usern'], ENT_QUOTES);
        $sname = htmlspecialchars($_POST['sname'], ENT_QUOTES);
        $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
        $adress = htmlspecialchars($_POST['adress'], ENT_QUOTES);

        $er .= strlen($mail) > 32 ? '\n e-mail is too long! Max 32 symbols.' : '';
        $er .= strlen($uname) > 32 ? '\n name is too long! Max 32 symbols.' : '';
        $er .= strlen($sname) > 32 ? '\n surname is too long! Max 32 symbols.' : '';
        $er .= strlen($phone) > 32 ? '\n phone number is too long! Max 32 symbols.' : '';

//checking is all lenght ok or there are errors
        if (!empty($er)) {
            echo '<script>alert("' . $er . '")</script>';
        } else {
            $db = Db::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO `users` (`email`, `password`, `uname`, `sname`, `phone`, `adress`) VALUES ('" . $mail . "' , '" . $pass . "' , '" . $uname . "' , '" . $sname . "' , '" . $phone . "' , '" . $adress . "' )");
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                echo '<script> alert(" You succesfuly registered.  Enter your email and password ")</script>';
                header('Refresh: 0; url=index.php');
            }
        }
    }
}

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8"/>
    <title>Registration Form</title>
</head>
<div id="register">
    <form action="" autocomplete="on" id="regField" method="post">
        <h1> Sign up </h1>
        <p>
            <label for="email"> Your email</label><br>
            <input name="email" required="required" type="email" placeholder="mysupermail@mail.com" value="<?php echo $mail; ?>"/>
        </p>
        <p>
            <label for="pass">Your password </label><br>
            <input name="pass" required="required" type="password" placeholder="eg. X8df!90EO"/>
        </p>
        <p>
            <label for="usern">Your name</label> <br>
            <input name="usern" required="required" type="text" placeholder="mysuperusername690" value="<?php echo $uname; ?>"/>
        </p>
        <p>
            <label for="sname">Your surname</label> <br>
            <input name="sname" required="required" type="text" placeholder="mysuperusername690" value="<?php echo $sname; ?>"/>
        </p>
        <p>
            <label for="phone">Your phone number</label> <br>
            <input name="phone" required="required" type="text" placeholder="380960000000" value="<?php echo $phone; ?>"/>
        </p>
        <p>
            <label for="adress">Your adress</label> <br>
            <input name="adress" required="required" type="text" placeholder="Ukraine, some street Sambir" value="<?php echo $adress; ?>"/>
        </p>
        <p>
            <input type="submit" value="Sign up" name="signup"/>
        </p>

    </form>
</div>
