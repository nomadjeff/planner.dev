<?php

Class Filestore
{
	public $filename;
	public $contents;
	protected $isCSV = false;
	protected $isText = false;

	function __construct($filename)
	{
		$this->filename = $filename;

		if (!file_exists($filename)) {
			touch ($filename);
		}
		if(substr($filename, -3) == 'csv') {
			$this->isCSV = true;
		}
		else if(substr($filename, -3) == 'txt') {
			$this->isText = true;
		}
		else {
			echo "File must be in csv or txt format.";
		}
	}

	public function read()
	{
		if($this->isCSV) {
			return $this->readCSV();
		}
		else if ($this->isText)	{
			return $this->readLines();
		}
	}

	public function write($array) {
		if ($this->isCSV) {
			$this->writeCSV($array);
		}
		else {
			$this->writeLines($array);
		}
	}

	protected function readCSV() {
		$array = [];
		$handle = fopen($this->filename, 'r');
		while(!feof($handle)) {
			$row = fgetcsv($handle);
			if (!empty($row)) {
				$array[] = $row;
			}
		}
		fclose($handle);
		return $array;
	}

	protected function writeCSV($array) {
		$handle = fopen($this->filename, 'w');

		foreach ($array as $item) {
			fputcsv($handle, $item);
		}
		fclose($handle);
	}

	protected function readLines()
	{
		$array = [];
		$filesize = filesize($this->filename);

		if($filesize > 0) {
			$handle = fopen($this->filename, 'r');
			$string = trim(fread($handle, $filesize));
			$array = explode("\n", $string);
			fclose($handle);
		}
		return $array;
	}

	protected function writeLines($array) {
		$handle = fopen($this->filename, 'w');
		$string = implode("\n", $array);
		fwrite($handle, $string);
		fclose($handle);
	}

	protected function validate()
	{
		
	}
}

