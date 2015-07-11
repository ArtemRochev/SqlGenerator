<?php

class StatementGenerator {
	private function buildFields($fieldPrefix, $fields) {
		$fieldsStr = "id SERIAL";
		
		foreach ($fields as $fieldName => $fieldType) {
			$fieldsStr .= ",\n	" . $fieldPrefix . $fieldName . " " . $fieldType;
		}
		
		return $fieldsStr;
	}
	
	private function buildCreateStatment($tableName, $features) {
		$fieldPrefix = strtolower($tableName) . "_";
		
		$fields = $this->buildFields($fieldPrefix, $features["fields"]);
		
		return sprintf(
			file_get_contents("sql_tpl/createTable.sql"), 
			$tableName, $fields, strtolower($tableName)
		) . "\n";
	}
	
	function buildUpdateTimestampTrigger($tableName) {
		return 
			sprintf(file_get_contents("sql_tpl/updateTimestamp_PlPg.sql"), strtolower($tableName) . "_updated") . "\n" .
			sprintf(file_get_contents("sql_tpl/updateTimestampTrigger.sql"), $tableName) . "\n";
	}
	
	function parseScheme($fileName) {
		return yaml_parse_file($fileName);
	}
	
	function generateStatements($fileName) {
		$schema = $this->parseScheme($fileName);
		$sqlOutput = "";
		
		foreach ($schema as $tableName => $features) {
			$sqlOutput .= $this->buildCreateStatment($tableName, $features);
			$sqlOutput .= $this->buildUpdateTimestampTrigger($tableName);
		}
		
		return $sqlOutput;
	}
}
