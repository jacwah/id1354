<?php
namespace TastyRecipes\Integration;

class SqlConnection {
    private const ERROR_DUPLICATE_ENTRY = 1062;

    private $mysqli;

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->mysqli = new \mysqli();
            $this->mysqli->real_connect();
            $this->mysqli->select_db('tasty_recipes');
        } catch (\mysqli_sql_exception $e) {
            throw new DatastoreException($e);
        }
    }

    public function query(string $query) {
        error_log("Executing: $query");
        try {
            $result = $this->mysqli->query($query);
            return $result;
        } catch (\mysqli_sql_exception $e) {
            throw new DatastoreException($e);
        }
    }

    public function selectOne(string $query) {
        $result = $this->query($query);
        $row = $result->fetch_assoc();
        $result->free();
        if (isset($row))
            return $row;
        else
            throw new NoResultException();
    }

    public function queryAndExpectAffectedRows(string $query) {
        $this->query($query);
        if ($this->mysqli->affected_rows < 1)
            throw new DatastoreException('Expected affected rows, got none');
    }

    public function insertUnique(string $query) {
        try {
            $this->query($query);
        } catch (DatastoreException $e) {
            if ($this->mysqli->errno === static::ERROR_DUPLICATE_ENTRY)
                throw new NotUniqueException();
            else
                throw $e;
        }
    }

    public function escape(string $s) {
        return $this->mysqli->real_escape_string($s);
    }

    public function lastInsertId() {
        return $this->mysqli->insert_id;
    }
}
