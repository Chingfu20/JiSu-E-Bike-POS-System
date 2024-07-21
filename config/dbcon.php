<?php

define('DB_SERVER',"localhost");
define('DB_USERNAME',"u510162695_db_jisu_pos");
define('DB_PASSWORD',"1Db_jisu_pos");
define('DB_DATABASE',"u510162695_db_jisu_pos");

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if(!$conn){
    die("Connection Failed: ". mysqli_connect_error());
}

?>
