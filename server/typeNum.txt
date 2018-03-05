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
  
<h4>Breakdown of beers by type:</h4>
  
<?php

$query = "SELECT macro.type, COUNT(*) FROM Macrobrews macro
		GROUP BY 1
		UNION
		SELECT micro.type, COUNT(*) FROM Microbrews micro
		GROUP BY 1
		ORDER BY 1 ASC;";

if($stmt = $conn->prepare($query))
{
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
    print "TYPE: $col1, # OF BEERS: $col2 \n";
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
<a href="typeNum.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>