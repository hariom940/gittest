<?php
$quickbook_application_login = '';
$quickbook_connection_ticket = '';
$host = '127.0.0.1';
$username = 'vanagain_va';
$password = 'AXXXI6D?d.#U';
$dbname = 'vanagain_vanagain';
$con = mysqli_connect($host,$username,$password,$dbname);

// Check connection
if (mysqli_connect_errno())
 {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

 $query = mysqli_query($con,"SELECT quickbook_application_login, quickbook_connection_ticket  FROM settings where id = 1");
while ($row = $query->fetch_assoc()) {
    $quickbook_application_login = $row['quickbook_application_login'];
    $quickbook_connection_ticket = $row['quickbook_connection_ticket'];
}
?>