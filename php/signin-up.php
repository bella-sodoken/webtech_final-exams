<?php

    require('Database_Connection.php');


   session_start();
    $_SESSION['is_login'] = FALSE;

    $_SESSION['email'] = null;
    $_SESSION['user_id'] = null;
    $_SESSION['password'] = null;
    $_SESSION['has_acc'] = null;
    $_SESSION['name'] = null;
    $_SESSION['is_login'] = FALSE;
    $email = null;
    $password = null;
    $user_name = null;
    $phone = null;

    // VALIDATING THE LOGIN CREDENTIALS
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sqlSELECT = "SELECT `signup_id`, `username`, `email`, `password`, `contact` FROM `signup` WHERE email = '$email'";

        $result_for_select = $conn->query($sqlSELECT);

        if($result_for_select->num_rows > 0){
            while($row2 = $result_for_select->fetch_assoc()){
                $temp_password = $row2['password'];
            }
            if ($temp_password === $password) {
               
                    $sqlINSERT = "INSERT INTO `log_in`(`email`, `password`) VALUES ('$email','$password')";    
        $result = $conn->query($sqlINSERT);

        if($result === True){
            $_SESSION['email'] = $email;
            $_SESSION['is_login'] = TRUE;
            $_SESSION['password'] = $password;

            //checking if he has the account
           $check_for_user_acc = "SELECT `personID`, `fname`, `lname`, `gender`, `dob`, `nationality`, `tel`, `personal_email` FROM `PERSON_SIGN_UP` WHERE personal_email = '$email'";
           $result = $conn->query($check_for_user_acc);

           if($result->num_rows > 0){
            $_SESSION['has_acc'] = TRUE;

            while ($row = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $row['person_ID'];
                $userid = $_SESSION['user_id'];
                $_SESSION['name'] = $row['fname']." ".$row['lname'];
                $user_name = $_SESSION['name'];
            }
           
           
           }
           else{
            echo "no acc";
           }
            header('Location:\WebTech Final Exams\BBflowershop\BBflowershop\index.html');
        }
        else{
            echo "
            <script>
            window.alert('Could not log in. There is a problem with email or password');
            </script>

            ";
        }

            }
            else{
                echo "
                      <script>
                          alert('password incorrect!!');
                      </script>
                    ";
            }
        }
        else{
            echo "
                      <script>
                          alert('Email or password error');
                      </script>
                    ";
        }


    }


        

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <!-- Bootstrap CSS for styling and layout-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <style>
            body {
    margin: 0;
    color: #6a6f8c;
    background: #c8c8c8;
    font: 600 16px/18px 'Open Sans', sans-serif
}

.login-box {
    width: 100%;
    margin: auto;
    max-width: 525px;
    min-height: 1000px;
    position: relative;
    background: url(https://images.unsplash.com/photo-1507208773393-40d9fc670acf?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1268&q=80) no-repeat center;
    box-shadow: 0 12px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19)
}

.login-snip {
    width: 100%;
    height: 100%;
    position: absolute;
    padding: 90px 70px 50px 70px;
    background: rgba(0, 77, 77, .9)
}

.login-snip .login,
.login-snip .sign-up-form {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    position: absolute;
    transform: rotateY(180deg);
    backface-visibility: hidden;
    transition: all .4s linear
}

.login-snip .sign-in,
.login-snip .sign-up,
.login-space .group .check {
    display: none
}

.login-snip .tab,
.login-space .group .label,
.login-space .group .button {
    text-transform: uppercase
}

.login-snip .tab {
    font-size: 22px;
    margin-right: 15px;
    padding-bottom: 5px;
    margin: 0 15px 10px 0;
    display: inline-block;
    border-bottom: 2px solid transparent
}

.login-snip .sign-in:checked+.tab,
.login-snip .sign-up:checked+.tab {
    color: #fff;
    border-color: #1161ee
}

.login-space {
    min-height: 345px;
    position: relative;
    perspective: 1000px;
    transform-style: preserve-3d
}

.login-space .group {
    margin-bottom: 15px
}

.login-space .group .label,
.login-space .group .input,
.login-space .group .button {
    width: 100%;
    color: #fff;
    display: block
}

.login-space .group .input,
.login-space .group .button {
    border: none;
    padding: 15px 20px;
    border-radius: 25px;
    background: rgba(255, 255, 255, .1)
}

.login-space .group input[data-type="password"] {
    -webkit-text-security: circle
}

.login-space .group .label {
    color: #aaa;
    font-size: 12px
}

.login-space .group .button {
    background: #1161ee
}

.login-space .group label .icon {
    width: 15px;
    height: 15px;
    border-radius: 2px;
    position: relative;
    display: inline-block;
    background: rgba(255, 255, 255, .1)
}

.login-space .group label .icon:before,
.login-space .group label .icon:after {
    content: '';
    width: 10px;
    height: 2px;
    background: #fff;
    position: absolute;
    transition: all .2s ease-in-out 0s
}

.login-space .group label .icon:before {
    left: 3px;
    width: 5px;
    bottom: 6px;
    transform: scale(0) rotate(0)
}

.login-space .group label .icon:after {
    top: 6px;
    right: 0;
    transform: scale(0) rotate(0)
}

.login-space .group .check:checked+label {
    color: #fff
}

.login-space .group .check:checked+label .icon {
    background: #1161ee
}

.login-space .group .check:checked+label .icon:before {
    transform: scale(1) rotate(45deg)
}

.login-space .group .check:checked+label .icon:after {
    transform: scale(1) rotate(-45deg)
}

.login-snip .sign-in:checked+.tab+.sign-up+.tab+.login-space .login {
    transform: rotate(0)
}

.login-snip .sign-up:checked+.tab+.login-space .sign-up-form {
    transform: rotate(0)
}

*,
:after,
:before {
    box-sizing: border-box
}

.clearfix:after,
.clearfix:before {
    content: '';
    display: table
}

.clearfix:after {
    clear: both;
    display: block
}

a {
    color: inherit;
    text-decoration: none
}

.hr {
    height: 2px;
    margin: 60px 0 50px 0;
    background: rgba(255, 255, 255, .2)
}

.foot {
    text-align: center
}

.card {
    width: 500px;
    left: 100px
}

::placeholder {
    color: #b3b3b3
}
        </style>
    </head>
            <title>
                LOGIN/SIGNUP
            </title>
                <body>
                        
                    <div class="row">
                        <div class="col-md-6 mx-auto p-0">
                            <div class="card">
                                <!--log in page-->
                                <form method="POST">
                                <div class="login-box">
                                    <div class="login-snip"> <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Login</label> <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">SIGN UP</label>
                                        <div class="login-space">
                                            <div class="login">
                                                <!--email-->
                                                <div class="group"> <label for="user" class="label">email</label> <input id="user" type="text" class="input" placeholder="email@example.com" name="email"> </div>
                                                <!--password-->
                                                <div class="group"> <label for="pass" class="label">Password</label> <input id="pass" type="password" class="input" data-type="password" placeholder="Enter your password" name="password"> </div>
                                                <!--agreement-->
                                                <div class="group"> <input id="check" type="checkbox" class="check" checked> <label for="check"><span class="icon"></span> Keep me Signed in</label> </div>
                                                <!--sign in button-->
                                                <div class="group"> <input name="submit" type="submit" class="button" value="Sign In"> </div>
                                                <div class="hr"></div>
                                                <!--forgot password-->
                                                <div class="foot"> <a href="#">Forgot Password?</a> </div>
                                            </div>
                                        </form>



                                            <!--sign up page-->
                                            <form>
                                            <div class="sign-up-form">
                                                <!--name-->
                                                <div class="group"> <label for="user" class="label">First name</label> 
                                                    <input name = "first_name" id="user" type="text" class="input" required placeholder="last name"> </div>

                                                <div class="group"> <label for="user" class="label">Last name</label> 
                                                    <input name = "last_name" id="user" type="text" class="input" required placeholder="last name"> </div>
                                                <!--gender-->
                                                <div class="group"> <label for="pass" class="label">Gender</label> 
                                                <input name="gender" id="pass" type="text" class="input" required placeholder="gender"> </div>
                                                <!--date of birth-->
                                                <div class="group"> <label for="pass" class="label">Date Of Birth</label> 
                                                <input name="dob" id="pass" type="text" class="input" required placeholder="dob"> </div>
                                                <!--email-->
                                                <div class="group"> <label for="pass" class="label">Nationality</label> 
                                                <input name="nationality" id="pass" type="text" class="input" required placeholder="nationality"> </div>
                                                <!--phone number-->
                                                <div class="group"> <label for="phone" class="label">Phone number</label>
                                                 <input name="phone" id="phone" type="tel" class="input" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                                                    required placeholder="0558396316"> </div>
                                                 <!--email-->
                                                 <div class="group"> <label for="pass" class="label">Email Address</label> 
                                                <input name="email" id="pass" type="text" class="input" required placeholder="email"> </div>
                                                <!--password-->
                                                <div class="group"> <label for="pass" class="label">Password</label> 
                                                    <input name="password" id="pass" type="password" class="input" data-type="password" required placeholder="Create password"> </div>
                                                <!--confirm password-->
                                                <div class="group"> <label for="pass" class="label">Confirm Password</label> 
                                                    <input name="confirmPassword" id="pass" type="password" class="input" data-type="password" required placeholder="Confirm password"> </div>
                                                <!--signup button-->
                                                <div class="group"> <input name="sign_up" type="submit" class="button" value="Sign Up"> </div>
                                                <div class="hr"></div>
                                                <!--log in if you already have an account-->
                                                <div class="foot"> <label for="tab-1">Have an account?Login</label> </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </body>
</html>









<?php

    // INSERTING INTO SIGING UP CREDENTIALS

    if(isset($_GET['sign_up'])){

        $user_name = $_GET['first_name'];
        $user_name = $_GET['last_name'];
        $gender = $_GET['gender'];
        $dob = $_GET['dob'];
        $nationality = $_GET['nationality'];
        $email = $_GET['email'];
        $phone = $_GET['tel'];
        $password = $_GET['password'];
        $confirmPassword = $_GET['confirmPassword'];
        $sqlINSERT = "INSERT INTO `SIGNUP`(`username`,'username','gender', 'dob','nationality',`email`, `tel`, `password`) VALUES ('$user_name','$email','$phone','$password')";

        if ($conn->query($sqlINSERT) === TRUE) {
            echo "
                <script>
                    alert('sign up successful');

                </script>


            New record created successfully";
        } else {
        
            
            echo $user_name;          
            echo "Error: " . $sqlINSERT . "<br>" . $conn->error;
        }
            $conn->close();
    }




?>