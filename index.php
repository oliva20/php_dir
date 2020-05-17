<?php 
require_once './db/Initdb.php';

$db = new Initdb();

?>

<html> 
<head></head>
<body>
<div>
    <form style='display: inline-block' action='./search.php' method='GET'>
        <label for='value'>Search: </label>
        <input name='node' type='text' />
        <input type='submit' value='Search' />
    </form>
    
    <form style='display: inline-block' action='./loadData.php' method='POST'>
        <input type='submit' value='Load Data' />
    </form>

</div>
</body>

</html>

