<?php

require_once "DBMain2.php";

$dbMain = new ManipulateDB();

$dbMain->createDBandTAB();
$dbMain->insertMockDataToTABs();
$dbMain->selectFromTAB();

?>
