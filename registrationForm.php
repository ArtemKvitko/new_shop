<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <title>Registration Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
    <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
    <meta name="author" content="Codrops" />
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/regs.css" />

</head>
<body>


<div id="register">
    <form  action="" autocomplete="on">
        <h1> Sign up </h1>
        <p>
            <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
            <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="mysuperusername690" />
        </p>
        <p>
            <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
            <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mysupermail@mail.com"/>
        </p>
        <p>
            <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
            <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="eg. X8df!90EO"/>
        </p>
        <p>
            <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
            <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="eg. X8df!90EO"/>
        </p>
        <p class="signin button">
            <input type="submit" value="Sign up"/>
        </p>

    </form>
</div>
