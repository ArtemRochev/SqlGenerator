<?php

require_once('StatementGenerator.php');

$g = new StatementGenerator;

//var_dump($g->generateStatements('schema.yaml')) . "\n";
echo $g->generateStatements('schema.yaml')[2] . "\n";
echo $g->generateStatements('schema.yaml')[3] . "\n";
//echo $g->buildUpdateTimestampTrigger('article') . "\n";
