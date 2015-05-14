<?php

class StatementGenerator {
	private function buildFields($fieldPrefix, $fields) {
		$fieldsStr = 'id SERIAL';
		
		foreach ($fields as $fieldName => $fieldType) {
			$fieldsStr .= ', ' . $fieldPrefix . $fieldName . ' ' . $fieldType;
		}
		
		return $fieldsStr;
	}
	
	private function buildCreateStatment($tableName, $features) {
		$fieldPrefix = strtolower($tableName) . '_';
		
		$fields = $this->buildFields($fieldPrefix, $features['fields']);
		
		return sprintf(
			file_get_contents('sql_tpl/createTable.sql'), 
			$tableName, $fields, strtolower($tableName)
		);
	}
	
	function buildUpdateTimestampTrigger($tableName) {
		return 
			sprintf(file_get_contents('sql_tpl/updateTimestamp_PlPg.sql'), strtolower($tableName) . '_updated') .
			sprintf(file_get_contents('sql_tpl/updateTimestampTrigger.sql'), $tableName);
	}
	
	function parseScheme($fileName) {
		return yaml_parse_file($fileName);
	}
	
	function generateStatements($fileName) {
		$schema = $this->parseScheme($fileName);
		$statements = [];
		
		foreach ($schema as $tableName => $features) {
			$this->statements[] = $this->buildCreateStatment($tableName, $features);
			$this->statements[] = $this->buildUpdateTimestampTrigger($tableName);
		}
		
		return $this->statements;
	}
}
