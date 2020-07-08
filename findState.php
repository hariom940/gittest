<?php
require_once("dbcon.php");
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $cid = $_GET['country_id'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "alliance_club";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT  * FROM states where country_id='$cid'";
    $result = $conn->query($sql);
        $states = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $states[] = [
                'id' => $row['id'],
                'name' => $row['name'],
            ];
        }
    } 

    echo json_encode($states);
}
?>