<div id="authForm">
<?php

if(!isset($_SESSION['user'])) {
    echo '
<form method="post" id="nouser" action="index.php">
<label>e - mail: &nbsp;  </label> <input name="email" type="text" ><br>
<label>Password</label> <input name="password" type="password" ><br>
<input name="login" type="submit" value="LogIn" id="login"> or <a href="index.php?page=regUser"> Sing Up </a>
</form> ';


if (isset($_POST['login'])) {
    $check=Db::userExist($_POST['email']);

        if ($check) {

            $pass=md5($_POST['password']);

          if ($pass==$check->password){
            echo 'YoooHoo';
              var_dump($check);
            $_SESSION['user']= new User($check->id,$check->email,$check->name,$check->sname,$check->phone,$check->adress);
              header('Refresh: 0; url=index.php');
          } else {

           echo '<b id="err"> Your e-mail or password is incorrect </b>';

          }



        } else {
            echo '<b id="err">User not found</b>';}
}


} else {
    if (!isset($bucket)){
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
