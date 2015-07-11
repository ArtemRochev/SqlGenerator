<?php

require_once('StatementGenerator.php');

$generator = new StatementGenerator;
$sqlResult = $generator->generateStatements('schema.yaml');


echo $sqlResult;
