<?php

if (isset($_POST['signup'])) {

    $check = Db::userExist($_POST['email']);

    if ($check) {
        echo 'email alredy registered';
    } else {
        $mail = htmlspecialchars($_POST['email'], ENT_QUOTES);

        $pass = md5($_POST['pass']);
        $db = Db::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO `users` (`email`, `password`, `uname`, `sname`, `phone`, `adress`) VALUES ('" . $mail . "' , '" . $pass . "' , '" . $_POST['usern'] . "' , '" . $_POST['sname'] . "' , '" . $_POST['phone'] . "' , '" . $_POST['adress'] . "' )");
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            echo '<script> alert(" You succesfuly registered.  Enter your email and password ")</script>';
            header('Refresh: 0; url=index.php');
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
            <label for="usern">Your username</label> <br>
            <input name="usern" required="required" type="text" placeholder="mysuperusername690"/>
        </p>
        <p>
            <label for="sname">Your username</label> <br>
            <input name="sname" required="required" type="text" placeholder="mysuperusername690"/>
        </p>
        <p>
            <label for="email"> Your email</label><br>
            <input name="email" required="required" type="email" placeholder="mysupermail@mail.com"/>
        </p>
        <p>
            <label for="pass">Your password </label><br>
            <input name="pass" required="required" type="password" placeholder="eg. X8df!90EO"/>
        </p>
        <p>
            <label for="phone">Your phone number</label> <br>
            <input name="phone" required="required" type="text" placeholder="380960000000"/>
        </p>
        <p>
            <label for="adress">Your adress</label> <br>
            <input name="adress" required="required" type="text" placeholder="Ukraine, some street Sambir"/>
        </p>
        <p>
            <input type="submit" value="Sign up" name="signup"/>
        </p>

    </form>
</div>
