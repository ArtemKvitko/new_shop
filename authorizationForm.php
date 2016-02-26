<div id="authForm">
<?php

if(!isset($_SESSION['user'])) {
    echo '
<div id="nouser"><form method="post" action="index.php">
<label>e - mail: &nbsp;  </label> <input name="email" type="text" ><br>
<label>Password</label> <input name="password" type="password" ><br>
<input name="login" type="submit" value="LogIn" id="login"> or <a href="index.php?page=regUser"> Sing Up </a>
</form> </div>' ;


if (isset($_POST['login'])) {
    $check=Db::userExist($_POST['email']);

        if ($check) {

            $pass=md5($_POST['password']);

          if ($pass==$check->password){

            $_SESSION['user']= new User($check->id,$check->email,$check->uname,$check->sname,$check->phone,$check->adress);
              header('Refresh: 0; url=index.php');
          } else {

           echo '<b id="err"> Your e-mail or password is incorrect </b>';

          }



        } else {
            echo '<b id="err">User not found</b>';}
}


} else {

    $_SESSION['bucket']=$_SESSION['user']->getBucket();

    if (empty( $_SESSION['bucket'])){
        $bkimg='empty.png';
    } else {
        $bkimg='full.png';
    }

    Echo "
    <form id='reguser'>Hello, <a href='index.php?page=userInfo'>".$_SESSION['user']->name." ".$_SESSION['user']->sname."</a>
    <a href='index.php?page=logOut' ><img src='img/logout.png' height='16px' alt='log Out' ></a></form>
    ";

    echo '
    <a href = index.php?page=bucket><img src = "img/'.$bkimg.'" id="bucket"></a>
    ';


}



?>

</div>
