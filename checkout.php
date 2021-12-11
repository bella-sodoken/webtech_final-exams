<?php

    require('C:\NEW XAMPP\htdocs\WebTech Final Exams\BBflowershop\BBflowershop\php\Database_Connection.php');


   session_start();
    $_SESSION['is_login'] = FALSE;

    $_SESSION['email'] = null;
    $_SESSION['password'] = null;

   
    $_SESSION['is_login'] = FALSE;
    $firstname = null;
    $lastname = null;
    $gender = null;
    $dob = null;
    $nationality = null;
    $tel = null;
    $email = null;
    $password = null;
    $user_name = null;
    $phone = null;

    // VALIDATING THE LOGIN CREDENTIALS
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sqlSELECT = "SELECT `signup_id`, `username`, `email`, `password`, `tel` FROM `PERSON_SIGN_UP` WHERE personal_email = '$email'";

        $result_for_select = $conn->query($sqlSELECT);

        if($result_for_select->num_rows > 0){
            while($row2 = $result_for_select->fetch_assoc()){
                $temp_password = $row2['password'];
            }
            if ($temp_password === $password) {
               
                    $sqlINSERT = "INSERT INTO `LOG_IN`(`email`, `password`) VALUES ('$email','$password')";    
        $result = $conn->query($sqlINSERT);

        if($result === True){
            $_SESSION['email'] = $email;
            $_SESSION['is_login'] = TRUE;
            $_SESSION['password'] = $password;

            //checking if he has the account
           $check_for_user_acc = "SELECT `person_sign_up`, `fname`, `lname`, `gender`, `dob`, `nationality`, `tel`, `email`,  `password`, `comfirm_password` FROM `person_sign_up` WHERE personal_email = '$email'";
           $result = $conn->query($check_for_user_acc);

           if($result->num_rows > 0){
            $_SESSION['has_acc'] = TRUE;

            while ($row = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $row['potential_userid'];
                $userid = $_SESSION['user_id'];
                $_SESSION['name'] = $row['fname']." ".$row['lname'];
                $user_name = $_SESSION['name'];
            }
           
           if($_SESSION['has_acc']){
            $sql_get_acc = "SELECT `accountno`, `potential_userid`, `account_type`, `balance` FROM `account` WHERE potential_userid = '$userid'";

            $result = $conn->query($sql_get_bnk_acc);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    $_SESSION['accno'] =  $row['accountno'];
                    $_SESSION['acc_bal'] = $row['balance'];
                }
            }
           }



           }
           else{
            echo "you do not have an account";
           }
            header('Location:C:\NEW XAMPP\htdocs\WebTech Final Exams\BBflowershop\BBflowershop\index.html');
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
                          alert('Email or password incorrect');
                      </script>
                    ";
        }


    }


        

?>





<?php

    // INSERTING INTO SIGING UP CREDENTIALS

    if(isset($_GET['sign_up'])){

        $user_name = $_GET['full_name'];
        $email = $_GET['email'];
        $phone = $_GET['phone'];
        $password = $_GET['password'];
        $confirmPassword = $_GET['confirmPassword'];
        $sqlINSERT = "INSERT INTO `SIGNUP`(`username`, `email`, `contact`, `password`) VALUES ('$user_name','$email','$phone','$password')";

        if ($conn->query($sqlINSERT) === TRUE) {
            echo "
                <script>
                    alert('sign up successful');

                </script>


            New record created successfully";
        } else {
        
            // echo "
            //     <script>
            //         alert('This is a duplicate');

            //     </script>
            // ";
            echo $user_name;          
            echo "Error: " . $sqlINSERT . "<br>" . $conn->error;
        }
            $conn->close();
    }




?>