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
$date1=explode('-',$date);
$num="";
for($i=6;$i<strlen($number);$i++)
{
$num=$num.$number[$i];
}
$idnum=strtoupper($fname[0]).strtoupper($surname[0]).$num.$date1[2].$date1[1];
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
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "GET"){
    // Check if file was uploaded without errors
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("upload/" . $_FILES["photo"]["name"])){
                echo $_FILES["photo"]["name"] . " is already exists.";
            } else{
                move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" . $_FILES["photo"]["name"]);
                echo "Your file was uploaded successfully.";
            }
        } else{
            echo "Error: There was a problem uploading your file. Please try again.";
        }
    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}
if($_FILES["photo"]["error"] > 0){
    echo "Error: " . $_FILES["photo"]["error"] . "<br>";
} else{
   $filename=$_FILES["photo"]["name"];
   $filetype=$_FILES["photo"]["type"];
   $filesize=($_FILES["photo"]["size"] / 1024);
   $Storedin=$_FILES["photo"]["tmp_name"];
   $image=$Storedin.$filename;
    echo "File Name: " . $filename . "<br>";
    echo "File Type: " . $filetype . "<br>";
    echo "File Size: " . $filesize . " KB<br>";
    echo "Stored in: " . $Storedin;
}
include "get-details-of-uploaded-file.php";

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
//include "upload-manager.php"; 
?>
</body>
</html>
