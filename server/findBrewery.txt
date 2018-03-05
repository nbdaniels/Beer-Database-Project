<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>CIS 451 Final Project</title>
  </head>
  
  <body bgcolor="white">
  
  
  <hr>
  
<h4>Here is a list of the breweries found with that name:</h4>
  
<?php
  
$brewery = $_POST['brewery'];

$query = "SELECT brew.name, brew.city, brew.state
		FROM Brewery AS brew
		WHERE brew.name LIKE '%{$brewery}%';";

if($stmt = $conn->prepare($query))
{
	$stmt->bind_param("s", $_GET['brewery']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($col1, $col2, $col3);
}
else
{
	echo "Couldn't prepare query.";
}
?>

<p>
The query:
<p>
<?php
print $query;
?>

<hr>
<p>
Result of query:
<p>

<?php

print "<pre>";
while($stmt->fetch())
  {
    print "NAME: $col1, CITY: $col2, STATE: $col3 \n";
  }
print "</pre>";

$stmt->close();

mysqli_close($conn);

?>

<form action="http://ix.cs.uoregon.edu/~ndaniels/451Final/finalProject.html">
    <input type="submit" value="Go back" />
</form>
<p>
<hr>

<p>
<a href="findBrewery.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>