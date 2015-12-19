<?php

namespace core\lib;

class db
{
	private $host;
	private $user;
	private $password;
	private $database;

	private $mysqli;
	private $result;

	public $log = array();
	public $total_time = 0;
	public $debug = false;

	public function __construct($host, $user, $password, $database, $debug = false) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
		$this->debug = $debug;

		$this->connect($this->host, $this->user, $this->password, $this->database);
	}
	
	/**
	 * Real escape string
	 * @param string $str Some string
	 * @return string Escaped string
	 */
	public function escape($str) {
		return $this->mysqli->real_escape_string($str);
	}

	/**
	 * MySQL Query
	 * @param string $qstring
	 * @return \Db
	 */
	public function query($qstring) {
		if ($this->debug) {
			$stime = microtime(true);
		}

		if (!($this->result = $this->mysqli->query($qstring))) {
			$this->log_error($qstring);
		}

		if ($this->debug) {
			$etime = microtime(true);
			$this->log[] = (object) array(
				'query'	=>	$qstring,
				'time'	=>	$etime - $stime,
			);
			$this->total_time += $etime - $stime;
		}

		return $this;
	}

	/**
	 * Get all objects of MySQL Query
	 * @return array
	 */
	public function result() {
		$data = array();
		while ($object = $this->result->fetch_object()) {
			$data[] = $object;
		}
		$this->result->free();
		return $data;
	}

	/**
	 * Get count of all objects
	 * @return int
	 */
	public function count() {
		return $this->result->num_rows;
	}

	/**
	 * Get first row of MySQL Query
	 * @return object
	 */
	public function row() {
		return ($this->result->fetch_object() ? : null);
	}

	/**
	 * Get last insert ID
	 * @return int
	 */
	public function insert_id() {
		return $this->mysqli->insert_id;
	}

	/**
	 * Display log 
	 * @param double $bad_time
	 */
	public function print_log($bad_time = 0.1) {
		$total_time = 0;
		echo '<table style="font-face:courier new; font-size:11px">';
		foreach ($this->log as $item) {
			echo '<tr><td>', $item->query, '</td><td>', (($item->time >= $bad_time) ? '<b style="color:red">' . $item->time . '</b>' : $item->time), '</td></tr>';
			$total_time += $item->time;
		}
		echo '<tr><td><b>Total: ', count($this->log), ' queries</b></td><td><b>' . $total_time . '</b></td></tr>';
		echo '</table>';
	}

	/**
	 * Write log
	 */
	public function write_log() {
		file_put_contents('sql.log', '');
		$time = 0;
		foreach ($this->log as $item) {
			file_put_contents('sql.log', $item->query . "\t" . $item->time, FILE_APPEND);
			$time += $item->time;
		}
		file_put_contents('sql.log', "total\t" . $time, FILE_APPEND);
	}

	/**
	 * Insert data
	 * @param string $table
	 * @param array $data
	 * @return int last insert ID
	 */
	public function insert($table, $data) {
		$this->exec_single('INSERT INTO', $table, $data);
		return $this->insert_id();
	}
	
	public function insert_ignore($table, $data) {
		$this->exec_single('INSERT IGNORE INTO', $table, $data);
		return $this->insert_id();
	}
	
	/**
	 * Insert batch of data
	 * @param string $table
	 * @param array $data
	 */
	public function insert_batch($table, $data) {
		return $this->exec_batch('INSERT INTO', $table, $data);
	}
	
	/**
	 * Replace batch of data
	 * @param string $table
	 * @param array $data
	 */
	public function replace_batch($table, $data) {
		return $this->exec_batch('REPLACE INTO', $table, $data);
	}

	/**
	 * Update data
	 * @param string $table
	 * @param array $data
	 * @param array $where
	 * @return int Affected rows
	 */
	public function update($table, $data, $where = array()) {
		$this->exec_single('UPDATE', $table, $data, $where);
		return $this->affected_rows();
	}

	/**
	 * Update data ignore errors
	 * @param string $table
	 * @param array $data
	 * @param array $where
	 * @return int Affected rows
	 */
	public function update_ignore($table, $data, $where = array()) {
		$this->exec_single('UPDATE IGNORE', $table, $data, $where);
		return $this->affected_rows();
	}

	/**
	 * Replace data
	 * @param string $table
	 * @param array $data
	 * @param array $where
	 * @return boolean
	 */
	public function replace($table, $data, $where = array()) {
		$this->exec_single('REPLACE INTO', $table, $data, $where);
		return $this->affected_rows();
	}

	/**
	 * Get count of affected rows for last MySQL Query
	 * @return int
	 */
	public function affected_rows() {
		return $this->mysqli->affected_rows;
	}

	/**
	 * Get count of found rows for last MySQL Query
	 * @return int
	 */
	public function found_rows() {
		return $this->query('SELECT FOUND_ROWS() AS count')->row()->count;
	}
	
	/**
	 * Start MySQL transaction
	 */
	public function start_transaction() {
		$this->mysqli->begin_transaction();
	}
	
	/**
	 * Commit transaction
	 */
	public function commit() {
		$this->mysqli->commit();
	}
	
	/**
	 * Rollback transaction
	 */
	public function rollback() {
		$this->mysqli->query('ROLLBACK');
	}

	/**
	 * MySQL Query error
	 */
	private function log_error($qstring) {
		throw new \Exception($this->mysqli->errno . ': ' . $this->mysqli->error);
	}

	/**
	 * Generate secure `key` = "value"
	 * @param array data Data
	 * @param string glue Glue
	 * @return string Result string
	 */
	private function generate_key_value_query($data, $glue = ',') {
		$set = array();
		foreach ($data as $key => $val) {
			if (is_array($val)) {
				foreach ($val as &$t) {
					$t = $this->escape($t);
				}
				unset($t);
				$set[] = '`' . $key . '` IN ("' . implode('", "', $val) . '")';
			} else {
				$set[] = '`' . $key . '` = ' . $this->escape_value($val);
			}
			
		}
		return $set ? implode($glue, $set) : '';
	}
	
	/**
	 * Escape value
	 * @param string $val
	 * @return string
	 */
	private function escape_value($val) {
		return is_null($val) ? 'NULL' : '"' . $this->escape($val) . '"';
	}

	/**
	 * Update or Replace batch of data
	 * @param string mode Mode
	 * @param string table Table
	 * @param array data Data
	 * @return boolean
	 */
	private function exec_batch($mode, $table, $data) {
		if (!count($data)) {
			return FALSE;
		}

		$cols = array_keys(reset($data));
		$cols_sql = '(`' . implode('`,`', $cols) . '`)';

		$vals = array();
		foreach ($data as $item) {
			foreach ($item as &$val) {
				$val = $this->escape($val);
			}
			unset($val);
			$vals[] = '("' . implode('","', $item) . '")';
		}
		$vals_sql = implode(',', $vals);

		$this->query($mode . ' ' . $table . $cols_sql .' VALUES ' . $vals_sql);

		$insert_id = $this->insert_id();
		return range($insert_id, $insert_id + count($data) - 1);
	}

	/**
	 * Insert, Update or Replace of data
	 * @param string mode Mode
	 * @param string table Table
	 * @param array data Data
	 * @param array where Where
	 * @return int Insert ID
	 */
	private function exec_single($mode, $table, $data, $where = array()) {
		$set = $this->generate_key_value_query($data);
		$where = $this->generate_key_value_query($where, ' AND ');

		if (!$set) {
			return FALSE;
		}

		$this->query('
			' . $mode . '
				`' . $table . '`
			SET
				' . $set . '
			' . ($where ? 'WHERE ' . $where : '' ) . '
		');
	}

	/**
	 * Connect to database
	 */
	public function connect() {
		$this->mysqli = new \mysqli($this->host, $this->user, $this->password, $this->database);
		if ($this->mysqli->connect_errno) {
			$this->log_error('Cannot connect to server');
		}
		
		$this->query('SET NAMES UTF8');
	}
	
	public function disconnect() {
		$this->mysqli->close();
	}
	
	public function __destruct() {
		$this->disconnect();
	}

}
