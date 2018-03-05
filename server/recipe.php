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
  
<h4>Here is a list of the ingredients found for that beer:</h4>
  
<?php
  
$beer = $_POST['beer'];

$query = "SELECT b.name AS 'Beer', ing.name AS 'Ingredient', ing_used.amount_used AS 'Amount'
		FROM Ingredients_Used AS ing_used
		JOIN Beer AS b ON b.beer_id = ing_used.beer_id
		JOIN Ingredient AS ing ON ing.ingredient_id = ing_used.ing_id
        	WHERE b.name LIKE '%{$beer}%'
		ORDER BY b.name;";

if($stmt = $conn->prepare($query))
{
	$stmt->bind_param("s", $_GET['beer']);
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
    print "BEER: $col1, INGREDIENT: $col2, AMOUNT: $col3 grams \n";
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
<a href="recipe.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>