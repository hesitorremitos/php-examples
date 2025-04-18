<?php
$personData=['name'=>'John Doe','age'=>30,'city'=>'New York'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>
    <?php
    echo "<h1>test</h1>";
foreach($personData as $data => $values ){
    echo "<li>$values</li>";
};
?>
</body>
</html>
