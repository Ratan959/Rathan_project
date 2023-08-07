
<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['college']) &&
        isset($_POST['clg_id']) && isset($_POST['blood_group'])&&isset($_POST['age'])&&
        isset($_POST['gender']) && isset($_POST['email']) &&
        isset($_POST['phoneCode']) && isset($_POST['phone'])) {
        
        $username = $_POST['username'];
        $college = $_POST['college'];
        $college_id = $_POST['clg_id'];
        $BloodGroup = $_POST['blood_group'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phoneCode = $_POST['phoneCode'];
        $phone = $_POST['phone'];

        $host = "sql202.epizy.com";
        $dbUsername = "epiz_33503696";
        $dbPassword = "B3oEuI1yWp";
        $dbName = "epiz_33503696_DBMS";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(username, college, clg_id, blood_group, age,gender,email,phoneCode,phone) values(?, ?, ?, ?, ?, ?,?,?,?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssissii",$username, $college, $college_id, $BloodGroup, $age,$gender,$email,$phoneCode,$phone);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.\n \n thanks for your help";
                    
                   
                    
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>
