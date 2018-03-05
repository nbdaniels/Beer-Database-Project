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
  
<h4>Here is a list of current batches and their progress:</h4>
  
<?php
  
$brewery = $_POST['brewery'];

$query = "SELECT batch.batch_id, b.name,
		CASE WHEN DATE_ADD(batch.dateStarted, INTERVAL batch.timeToFerment week) < CURDATE() THEN 0 
		ELSE DATEDIFF(DATE_ADD(batch.dateStarted, INTERVAL batch.timeToFerment week), CURDATE()) END AS 'Days Remaining'
        	FROM Beer b
		JOIN Batch batch ON batch.beer_id = b.beer_id
		JOIN Brewery brew ON brew.brewery_id = b.brew_id
		WHERE brew.name LIKE '%{$brewery}%'
		ORDER BY brew.name, b.name;";

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
    print "BATCH: $col1, BEER: $col2, TIME: $col3 days remaining \n";
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
<a href="batchRemain.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>