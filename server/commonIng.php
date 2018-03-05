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
  
<h4>Here is a list of common ingredients of beers with the selected type:</h4>
  
<?php
  
$type = $_POST['type'];

$query = "SELECT i.name AS 'Name', COUNT(*) AS 'No. of Beers' FROM Ingredient i
		JOIN Ingredients_Used ing_used ON ing_used.ing_id = i.ingredient_id
		JOIN Beer b ON b.beer_id = ing_used.beer_id
		JOIN Macrobrews macro ON macro.beer_id = b.beer_id
		WHERE macro.type LIKE '%{$type}%'
		GROUP BY i.ingredient_id
		UNION
		SELECT i.name AS 'Name', COUNT(*) AS 'No. of Beers' FROM Ingredient i
		JOIN Ingredients_Used ing_used ON ing_used.ing_id = i.ingredient_id
		JOIN Beer b ON b.beer_id = ing_used.beer_id
		JOIN Microbrews micro ON micro.beer_id = b.beer_id
		WHERE micro.type LIKE '%{$type}%'
		GROUP BY i.ingredient_id
		ORDER BY 2 DESC;";

if($stmt = $conn->prepare($query))
{
	$stmt->bind_param("s", $_GET['type']);
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
    print "INGREDIENT: $col1, # OF BEERS: $col2 \n";
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
<a href="commonIng.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>