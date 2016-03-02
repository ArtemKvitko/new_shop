<div id="authForm">
    <?php
    $err = '';
    $email = '';
    if (!isset($_SESSION['user'])) {
        if (isset($_POST['login'])) {

            $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
            $check = Db::userExist($email);
          //if email founded
            if ($check) {
                $pass = md5($_POST['password']);
                //comparing passwords
                if ($pass == $check->password) {
                    $_SESSION['user'] = new User($check->id, $check->email, $check->uname, $check->sname, $check->phone, $check->adress);
                    header('Refresh: 0; url=index.php');
                } else {
                    $err = '<b id="err"> Your e-mail or password is incorrect </b>';
                }
            } else {
                $err = '<b id="err">User not found</b>';
            }
        }
        echo '
<div id="nouser"><form method="post" action="index.php">
<label>e - mail: &nbsp;  </label> <input name="email" type="text" value="' . $email . '" ><br>
<label>Password</label> <input name="password" type="password" ><br>
<input name="login" type="submit" value="LogIn" id="login"> or <a href="index.php?page=regUser"> Sing Up </a>
</form>  ' . $err . ' </div>';
    } else {

        $_SESSION['bucket'] = $_SESSION['user']->getBucket();
        $bkimg = empty($_SESSION['bucket']) ? 'bucket_empty.png' : 'bucket_full.png';

        echo "
    <form id='reguser'>Hello, <a href='index.php?page=userInfo'>" . $_SESSION['user']->name . " " . $_SESSION['user']->sname . "</a>
    <a href='index.php?page=logOut' ><img src='img/logout.png' height='16px' alt='log Out' ></a></form>
    ";
        echo '<a href = index.php?page=bucket><img src = "img/' . $bkimg . '" id="bucket"></a>';
    }
    ?>
</div>
