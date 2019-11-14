<!doctype html>

<html lang="en">
<head>
    <title>Registration List</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="images/SmallPic.ico">
    <link rel="stylesheet" href="styles/registration.css">
</head>
<body>
    <header>
        <h2>List of Registrants For Presentation Time</h2>
    </header>
    <br>
    <div class="navbar">
        <a id="bigsize" href="index.php">Sign-Up</a>
        <a id="bigsize" href="registration.php">Registrants</a>
    </div>
    <br>
    <?php 
        if(isset($_GET['success']) && $_GET['success'] == 1)
        {
            echo "<p id=\"RegComp\">Registration Complete, Thank You!!! </p>";
        }
        else
        {
            //do nothing
        }
    ?>
    <br>
    <div>
        <h3>Presentation Times:</h3>
    </div>
    <br>
    <table>
        <tr>
            <th>UMID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Project title</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th>Time Slot</th>
        </tr>
        
    <?php 

        include('dbConnObj.php'); 
        
        $sql = "SELECT umid, fnam, lnam, projtitle, email, phonenum, period FROM registrants";
        $result = $conn->query($sql);
 
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) 
            {
                echo "<tr> <td>" . $row["umid"] . "</td> <td>" . $row["fnam"] . "</td> <td>" . $row["lnam"] .
                "</td> <td>" . $row["projtitle"] . "</td> <td>" . $row["email"] . "</td> <td>" . $row["phonenum"] .
                "</td>";

                $sql2 = "SELECT availdate, availbegtime, availendtime FROM timeslots WHERE perid LIKE " . $row["period"] . ";";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) 
                {
                    $row2 = $result2->fetch_assoc();

                    echo "<td>" . date("m/d/y", strtotime($row2["availdate"])) . ", " . 
                    date("g:iA", strtotime($row2["availbegtime"])) . " - " 
                    . date("g:iA", strtotime($row2["availendtime"])) . "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<p id=\"NoRes\">No Registration Records Found !!! </p>";
        }
        
        $conn->close();
    ?>

    </table>
    
    <br>
    <footer>
		<p>&copy; This page was created and will be maintained by Abed Hawari.</p>
    </footer>
</body>
</html>