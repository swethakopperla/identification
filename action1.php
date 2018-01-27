<html>
<body>
<?php
$fname=$_GET['fname'];
$surname=$_GET['surname'];
$email=$_GET['email'];
$number=$_GET['number'];
$anumber=$_GET['anumber'];
$date=$_GET['date'];
//$department=$_GET['department'];
//$dname=$_GET['dname'];
//$text=$_GET['comment'];
$host="localhost";$user="root";
$pass="Root@1234";$dbname="identification";
  echo  "date: ".$date."</br>";
echo  "department: ".$department."</br>";
	echo  "number ".$number."</br>";
  echo  "dname:".$dname."</br>";
$conn=mysqli_connect($host,$user,$pass,$dbname);
if(!$conn)
die("could not connect to the DB".mysqli_connect_error());
else
echo "connected sucessfully............. <br>";
	$sql = "CREATE TABLE identification  (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
fname VARCHAR(30) NOT NULL,
surname VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
number VARCHAR(15) not null,
anumber VARCHAR(15) not null,
date date not null UNIQUE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table identification created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
echo "<br>";


echo "<br>";
$sql="insert into identification (fname,surname,email,number,anumber,date) 
 values('$fname','$surname','$email','$number','$anumber','$date');";
if(mysqli_query($conn,$sql)){
echo "record sucessfully inserted.......";
echo "<br>";
//$to = "yugandhar@itblabs.com";
$subject = "Test mail";
$message = "your appointmented on your give date".$date;
$from = "swetha.k@itblabs.com";
$headers = "From: $from";
mail($email,$subject,$message,$headers,"-f".$from);
echo "Mail Sent.";
}
else{
echo "could not insert record:".mysqli_error($conn);

echo "<br>";
//$to = "yugandhar@itblabs.com";
$subject = "Test mail";
$message = "your not appointmented on your given date!! ".$date."   fix another date";
$from = "swetha.k@itblabs.com";
$headers = "From: $from";
mail($email,$subject,$message,$headers,"-f".$from);
echo "Mail Sent.";

}
mysqli_close($conn);
?>
</body>
</html>
