<html>
<head>
<title>dipaly content</title>
</head>
<body>
<?php
$fname=$_GET['fname'];
$surname=$_GET['surname'];
$email=$_GET['email'];
$number=$_GET['number'];
$anumber=$_GET['anumber'];
$date=$_GET['date'];
$date=explode('-',$date);
$num="";
for($i=6;$i<strlen($number);$i++)
{
$num=$num.$number[$i];
}
$idnum=strtoupper($fname[0]).strtoupper($surname[0]).$num.$date[2].$date[1];
echo  "id num is".$idnum."<>";
$host="localhost";$user="root";
$pass="Root@1234";$dbname="identification";
//  echo  "date: ".$date."</br>";
//echo  "department: ".$department."</br>";
	echo  "number ".$number."</br>";
//  echo  "dname:".$dname."</br>";
$conn=mysqli_connect($host,$user,$pass,$dbname);
if(!$conn)
die("could not connect to the DB".mysqli_connect_error());
else
echo "connected sucessfully............. <br>";
	$sql = "CREATE TABLE identifications  (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
idnum varchar(30) not null,
fname VARCHAR(30) NOT NULL,
surname VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
number VARCHAR(15) not null,
anumber VARCHAR(15) not null,
date date not null UNIQUE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table identifications created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
echo "<br>";
/*php image upload in database start
$sql1="CREATE TABLE images (
id int(10) unsigned AUTO_INCREAMENT PRIMARY KEY,
addimg varchar(200) not null,
status varchar(20)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table identification created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

echo "<br>";
if($_GET)
	if($_FILES["file"]["error"])
	{
		echo "Return Code:".$_FILES["file"]["error"]."<br>";
	}
	else
	{
		if(file_exists("images/" . $_FILES["file"]["name"]))
		{
			echo $_FILES["file"]["name"] . " already exists. ";
		}
		else
		{	
			if(move_uploaded_file($_FILES["file"]["tmp_name"],"images/" . $_FILES["file"]["name"]))
			{
			    $sql="insert into images(addimg,status) values("$_FILES["file"]["name"]","dispaly")"
			    if(mysql_query($query_image))
			    {
				echo "Stored in: " . "images/" . $_FILES["file"]["name"];
			    }
			    else
			    {
				echo "file name is not stored in database.....";
			    }
			}
		}
	}
}
php image upload in to database ends*/	
echo "<br>";
$sql="insert into identifications(idnum,fname,surname,email,number,anumber,date) 
 values('$idnum','$fname','$surname','$email','$number','$anumber','$date');";
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
