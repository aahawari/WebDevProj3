<?php
    
    $UMIDErrror = $FNamError = $LNamError = $ProjTitleError = "";
    $PhoneNumError = $DateTimeError = $message = $EmailError = "";
    $emailPatteren = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
    $phonePatteren = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
    $UMID = $FirstName = $LastName = $projTitle = $email = $phoneNum = $datetime = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["txtUMID"]) && preg_match("/^[0-9]{8}$/", htmlspecialchars(trim($_POST["txtUMID"]))))
        {
            $UMID = htmlspecialchars(trim($_POST["txtUMID"]));
        }
        else
        {
            $UMIDErrror = "Invalid UMID!";
        }
        
        if(isset($_POST["txtFirstNam"]) && preg_match("/^[a-zA-Z]{1,200}$/", htmlspecialchars(trim($_POST["txtFirstNam"]))))
        {
            $FirstName = htmlspecialchars(trim($_POST["txtFirstNam"]));
        }
        else
        {
            $FNamError = "Invalid First Name!";
        }

        if(isset($_POST["txtLastNam"]) && preg_match("/^[a-zA-Z]{1,200}$/", htmlspecialchars(trim($_POST["txtLastNam"]))))
        {
            $LastName = htmlspecialchars(trim($_POST["txtLastNam"]));
        }
        else
        {
            $LNamError = "Invalid Last Name!";
        }

        if(isset($_POST["txtProjTitle"]) && preg_match('/^[a-zA-Z :,\';"!@#%^&*()-]{5,200}$/', htmlspecialchars(trim($_POST["txtProjTitle"]))))
        {
            $projTitle = htmlspecialchars(trim($_POST["txtProjTitle"]));
        }
        else
        {
            $ProjTitleError = "Invalid Project Title!";
        }

        if(isset($_POST["txtEmail"]) && preg_match($emailPatteren, htmlspecialchars(trim($_POST["txtEmail"]))))
        {
            $email = htmlspecialchars(trim($_POST["txtEmail"]));
        }
        else
        {
            $EmailError = "Invalid Email Entry!";
        }

        if(isset($_POST["txtPhoneNum"]) && preg_match($phonePatteren, htmlspecialchars(trim($_POST["txtPhoneNum"]))))
        {
            $phoneNum = htmlspecialchars(trim($_POST["txtPhoneNum"]));
        }
        else
        {
            $PhoneNumError = "Invalid Phone Number!";
        }

        if(isset($_POST["opp"]) && $_POST["opp"] == 'ch1')
        {
            $datetime  = 1;
        }
        else if(isset($_POST["opp"]) && $_POST["opp"] == 'ch2')
        {
            $datetime  = 2;
        }
        else if(isset($_POST["opp"]) && $_POST["opp"] == 'ch3')
        {
            $datetime  = 3;
        }
        else if(isset($_POST["opp"]) && $_POST["opp"] == 'ch4')
        {
            $datetime  = 4;
        }
        else if(isset($_POST["opp"]) && $_POST["opp"] == 'ch5')
        {
            $datetime  = 5;
        }
        else if(isset($_POST["opp"]) && $_POST["opp"] == 'ch6')
        {
            $datetime  = 6;
        }
        else
        {
            $DateTimeError = "Invalid Date/Time Selection";
        }
    }

    //end validation
    if($UMIDErrror == "" and $FNamError == "" and $LNamError == "" and
    $ProjTitleError == "" and $EmailError == "" and $PhoneNumError == "" and
    $DateTimeError == "")
    {
        if($UMID == "" || $FirstName == "" || $LastName == "" || 
        $projTitle == "" || $email == "" || $phoneNum == "" || $datetime == "")
        {
            //do nothing
        }
        else
        {
            unset($_POST['submit']);

            //query the database with the new information
            include('dbConnObj.php');

            $testsql = "SELECT umid FROM registrants WHERE umid LIKE " . $UMID . ";";
            $testresult = $conn->query($testsql);
            if($testresult->num_rows == 0)
            {
                $sql = "SELECT slotsremn FROM timeslots WHERE perid = $datetime";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                
                $seatsAvail = $row["slotsremn"];
                $seatsAvail--;

                if($seatsAvail <= -1)
                {
                    die("Error: this slot is full or seat was just taken! Please choose a different time slot.");
                }

                $sql2 = "INSERT registrants VALUES($UMID, \"$FirstName\", \"$LastName\", \"$projTitle\", \"$email\", \"$phoneNum\",  $datetime);";

                $sql3 = "UPDATE timeslots SET slotsremn = $seatsAvail WHERE perid LIKE " . $datetime . ";";

                $result = $conn->query($sql2);

                $result = $conn->query($sql3);

                header("Location: registration.php?success=1"); 
                exit();
            }
            else
            {
                //redirect to 3rd page
                header("Location: confRegistration.php?umid=$UMID&fnam=$FirstName&lnam=$LastName" . 
                "&projt=$projTitle&email=$email&phone=$phoneNum&slot=$datetime"); 
                exit();
            }
            
            $conn->close();
            
            $UMIDErrror = $FNamError = $LNamError = $ProjTitleError = $EmailError = "";
            $PhoneNumError = $DateTimeError = $message = $UMID = $FirstName = "";
            $LastName = $projTitle = $email = $phoneNum = $datetime = "";

            
        }
    }
    
?>