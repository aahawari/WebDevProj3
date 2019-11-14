<!doctype html>

<html lang="en">
<head>
	<title>Sign-Up Form</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="images/SmallPic.ico">
    <link rel="stylesheet" href="styles/main.css">
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
        <p>Please fill up the information below. Make sure to fill out EACH field. 
            Then choose one of the presentation day and time slot at the botton.
            Finally click the "Submit Registration" button. Thank You.</p>
    </div>
    <?php include('process.php'); ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <br>
        <label class="fldID">UMID:</label>
        <input class="txtBox" type = "text" id = "myText" name = "txtUMID" value="<?php echo isset($_POST['txtUMID']) ? $_POST['txtUMID'] : '' ?>" autofocus/>
        <label id="InvdUMID" class="invalid"><?= $UMIDErrror ?></label>
        <br><br>
        <label class="fldID">First Name:</label>
        <input class="txtBox" type = "text" id = "myText" name = "txtFirstNam"/>
        <label id="invdFN" class="invalid"><?= $FNamError ?></label>
        <br><br>
        <label class="fldID">Last Name:</label>
        <input class="txtBox" type = "text" id = "myText" name = "txtLastNam"/>
        <label id="invdLN" class="invalid"><?= $LNamError ?></label>
        <br><br>
        <label class="fldID">Project Title:</label>
        <input class="txtBox" type = "text" id = "myText" name = "txtProjTitle"/>
        <label id="invdPT" class="invalid"><?= $ProjTitleError ?></label>
        <br><br>
        <label class="fldID">Email:</label>
        <input class="txtBox" type = "text" id = "myText" name = "txtEmail"/>
        <label id="invdEM" class="invalid"><?= $EmailError ?></label>
        <br><br>
        <label class="fldID">Phone #:</label>
        <input class="txtBox" type = "text" id = "myText" name = "txtPhoneNum"/>
        <label id="invdPN" class="invalid"><?= $PhoneNumError ?></label>
        
        <br>
        <br>
        <h4>Presentation Time:</h4>
        
        <?php include('dbConnObj.php');
            $sql = "SELECT availdate, availbegtime, availendtime, slotsremn FROM timeslots";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) 
            {
                // output data of each row
                $i = 1;
                while($row = $result->fetch_assoc()) 
                {

                    if($row["slotsremn"] == 0)
                    {
                        echo "<input type=\"radio\" name=\"opp\" value=\"ch$i\" disabled/>";
                        echo date("m/d/y", strtotime($row["availdate"])) . ", " . 
                        date("g:iA", strtotime($row["availbegtime"])) . " - " 
                        . date("g:iA", strtotime($row["availendtime"])) . 
                        " --- Spots Remaining: " . $row["slotsremn"] . "<br>";
                    }
                    else
                    {
                        echo "<input type=\"radio\" name=\"opp\" value=\"ch$i\"/>";
                        echo date("m/d/y", strtotime($row["availdate"])) . ", " . 
                        date("g:iA", strtotime($row["availbegtime"])) . " - " 
                        . date("g:iA", strtotime($row["availendtime"])) . 
                        " --- Spots Remaining: " . $row["slotsremn"] . "<br>";
                    }

                    $i += 1;
                }
            } 
            else 
            {
                echo "0 results";
            }
            $conn->close();
        ?>
        
        <span id="invdSlctn" class="invalid"><?= $DateTimeError ?></span>
        
        <br>
        <br>
        
        <button type="submit">Submit Registration</button>
    </form>
    <br>
    <footer>
		<p>&copy; This page was created and will be maintained by Abed Hawari.</p>
    </footer>
</body>
</html>