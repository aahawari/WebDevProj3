<!doctype html>

<html lang="en">
<head>
	<title>Sign-Up Form</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="images/SmallPic.ico">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/conf.css">
</head>
<body>
    <header>
        <h2>Register For Presentation Time</h2>
    </header>
    <br>
    <div class="navbar">
        <a id="bigsize" href="index.php">Sign-Up</a>
        <a id="bigsize" href="registration.php">Registrants</a>
    </div>
    <br>
    <div>
        <h3>Instructions:</h3> 
        <p>You have already submitted a form for your presentation time! Please choose "Yes" to change your
            presentation time or choose "No" to keep your current presentation time.
        </p>
        <h4>PAST PRESENTATION INFORMATION:</h4>
    </div>
    
    <?php

        $UMID = $_GET['umid'];
        $FirstName = $_GET['fnam'];
        $LastName = $_GET['lnam'];
        $projTitle = $_GET['projt'];
        $email = $_GET['email'];
        $phoneNum = $_GET['phone'];
        $datetime = $_GET['slot'];

        echo"<form action=\"confRegistration.php?umid=$UMID&fnam=$FirstName&lnam=$LastName" . 
        "&projt=$projTitle&email=$email&phone=$phoneNum&slot=$datetime\" method=\"post\">";

        if(isset($_POST['btnyes']))
        {
            
            include('dbConnObj.php');

            $getsql = "SELECT period FROM registrants WHERE umid LIKE \"$UMID\";";
            $result = $conn->query($getsql);
            $resRow = $result->fetch_assoc();
            $oldSlot = $resRow['period'];
            
            $sqlupdate = "UPDATE registrants SET fnam=\"$FirstName\", lnam=\"$LastName\", projtitle=\"$projTitle\", email=\"$email\", phonenum=\"$phoneNum\", period=$datetime WHERE umid like \"$UMID\";";
            $result = $conn->query($sqlupdate);

            /************************************************************************************** */
            $getsql = "SELECT slotsremn FROM timeslots WHERE perid LIKE \"$datetime\";";
            $result = $conn->query($getsql);
            $val = $result->fetch_assoc();

            $tempv = $val['slotsremn'];
            $tempv--;

            $sqlupdate2 = "UPDATE timeslots SET slotsremn=" . $tempv . " WHERE perid LIKE \"$datetime\";";
            $result = $conn->query($sqlupdate2);
            /************************************************************************************** */
            $sqlupdate = "SELECT slotsremn FROM timeslots WHERE perid like \"$oldSlot\";";
            $result = $conn->query($sqlupdate);
            $val = $result->fetch_assoc();
            
            $tempv = $val['slotsremn'];
            $tempv++;

            $sqlupdate2 = "UPDATE timeslots SET slotsremn=" . $tempv . " WHERE perid LIKE \"$oldSlot\";";
            $result = $conn->query($sqlupdate2);
            

            $conn->close();
            header("Location: registration.php?success=1");
            exit();
        }
        if(isset($_POST['btnno']))
        {
            header("Location: registration.php?success=1"); 
            exit();
        }
    
        include('dbConnObj.php');

        $sql = "SELECT umid, fnam, lnam, projtitle, email, phonenum, period FROM registrants WHERE umid LIKE " . $_GET['umid'] . ";";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $sql2 = "SELECT availdate, availbegtime, availendtime FROM timeslots WHERE perid LIKE " . $row["period"] . ";";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();

        echo "<div><lable>UMID: " . $row["umid"] . "</lable><br><lable>First Name:"
        . $row["fnam"] . "</lable><br><lable>Last Name:" . $row["lnam"] . 
        "</lable><br><lable>Project Title:" . $row["projtitle"] . "</lable><br><lable>Email:" . 
        $row["email"] . "</lable><br><lable>Phone Number:" . $row["phonenum"] . 
        "</lable><br><lable>Presentation Time:" . date("m/d/y", strtotime($row2["availdate"])) . 
        ", " . date("g:iA", strtotime($row2["availbegtime"])) . " - " 
        . date("g:iA", strtotime($row2["availendtime"])) . "</lable></div>";
            
        /* ******************************************** */
        $sql = "SELECT availdate, availbegtime, availendtime, slotsremn FROM timeslots WHERE perid LIKE " . $_GET['slot'] .";";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        
        echo "<br><h4>REQUESTED PRESENTATION INFORMATION:</h4>";
        echo "<div><lable>UMID: " . $_GET['umid'] . "</lable><br><lable>First Name:" 
        . $_GET['fnam'] . "</lable><br><lable>Last Name:" . $_GET['lnam'] . 
        "</lable><br><lable>Project Title:" . $_GET['projt'] . "</lable><br><lable>Email:" . 
        $_GET['email'] . "</lable><br><lable>Phone Number:" . $_GET['phone'] . 
        "</lable><br><lable>Presentation Time:" . date("m/d/y", strtotime($row["availdate"])) 
        . ", " . date("g:iA", strtotime($row["availbegtime"])) . " - " . 
        date("g:iA", strtotime($row["availendtime"])) . "</lable></div>";


        $conn->close();
    ?>
    
    <br>
    <br>
    <?php
        echo "<div id=\"wrapper\"> <button  type=\"submit\" name=\"btnyes\" id=\"left\" class=\"btn bton\">Yes</button>";
        echo "<button  type=\"submit\" name=\"btnno\" id=\"right\" class=\"btn bton\">No</button> </div><br>";
    ?>
    </form>
    <br>
    <footer>
		<p>&copy; This page was created and will be maintained by Abed Hawari.</p>
    </footer>
</body>
</html>