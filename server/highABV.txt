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
  
<h4>Here is a list of beers sorted by highest ABV from the selected brewery</h4>
  
<?php
  
$brewery = $_POST['brewery'];

$query = "SELECT brew.name, b.name, macro.ABV FROM Beer b
		JOIN Macrobrews macro ON macro.beer_id = b.beer_id
		JOIN Brewery brew ON brew.brewery_id = b.brew_id
		WHERE brew.name LIKE '%{$brewery}%'
		UNION
		SELECT brew.name, b.name, micro.ABV FROM Beer b
		JOIN Microbrews micro ON micro.beer_id = b.beer_id
		JOIN Brewery brew ON brew.brewery_id = b.brew_id
		WHERE brew.name LIKE '%{$brewery}%'
		ORDER BY 3 DESC, 2 ASC;";

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
    print "BREWERY: $col1, BEER: $col2, ABV: $col3% \n";
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
<a href="highABV.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>