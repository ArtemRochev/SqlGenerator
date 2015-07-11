<?php

require_once('SqlGenerator.php');

$generator = new SqlGenerator;
$sqlResult = $generator->generateStatements('schema.yaml');


echo $sqlResult;
