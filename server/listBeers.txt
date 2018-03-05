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
  
<h4>Here are the beers from the selected brewery:</h4>
  
<?php
  
$brewery = $_POST['brewery'];

$query = "SELECT brew.name AS 'Brewery', b.name AS 'Beer'
		FROM beer.Beer AS b
		JOIN beer.Brewery brew ON brew.brewery_id = b.brew_id
		WHERE brew.name LIKE '%{$brewery}%';";

if($stmt = $conn->prepare($query))
{
	$stmt->bind_param("s", $_GET['brewery']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($col1, $col2);
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
    print "BREWERY: $col1, BEER: $col2 \n";
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
<a href="listBeers.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>