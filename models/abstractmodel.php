<?php

namespace PHPMVC\MODELS;

class AbstractModel
{

    const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_DECIMAL = 4;
    const DATA_TYPE_DT = 5;
    private static $connection;
    private $db;

    public function __construct()
    {
        try {
            $this->db = new \PDO("mysql:hostname=localhost;dbname=ahmed_samir", "Rootroot02", "Rootroot02", array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ));

        } catch (\PDOException $e) {
            trigger_error('Error connecting with the database!', E_ERROR);
        }
    }

    private function prepareValues(\PDOStatement &$stmt)
    {

        foreach (static::$tableSchema as $paramsValues => $type) {
            if ($type == 4) {
                $sanitizedDecimalValue = filter_var($this->$paramsValues, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":$paramsValues", $sanitizedDecimalValue);
            } elseif ($type == 5) {
                // todo: check if it's date
                $sanitizedDateValue = date($this->$paramsValues);
                $stmt->bindValue(":$paramsValues", $sanitizedDateValue);

            } else {
                $stmt->bindValue(":$paramsValues", $this->$paramsValues, $type);
            }
        }
    }

    private static function connection()
    {
        try {
            self::$connection = new \PDO("mysql:hostname=localhost;dbname=ahmed_samir", "Rootroot02", "Rootroot02", [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
            return self::$connection;
        } catch (\PDOException $e) {

            trigger_error('Error while connecting with the database static function!', E_WARNING);
        }
        return false;
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM ' . static::$table_name;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return self::getData($stmt);
    }

    public static function S_getAll()
    {
        $connection = self::connection();
        $sql = 'SELECT * FROM ' . static::$table_name;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return self::getData($stmt);
    }

    private static function getData(\PDOStatement &$stmt)
    {
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        if (is_array($result) && !empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getByPK($pk = null)
    {
        $pk = empty($pk) ? $this->{static::$PK} : $pk;
        $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE ' . static::$PK . ' = ' . $pk;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return self::getData($stmt);
    }

    public static function S_getByPK($pk = null)
    {
        $connection = self::connection();
        if (empty($pk)) {
            return false;
        }
        $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE ' . static::$PK . ' = ' . $pk;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return self::getData($stmt);
    }

    private static function BindParams()
    {
        $params = '';
        foreach (static::$tableSchema as $fieldName => $value) {
            $params .= $fieldName . ' = :' . $fieldName . ' , ';
        }
        $params = trim($params, ', ');
        return $params;
    }

    private function BindValues(\PDOStatement &$stmt)
    {
        foreach (static::$tableSchema as $paramsValues => $type) {
            if ($type == 4) {
                $sanitizedDecimalValue = filter_var($this->$paramsValues, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":$paramsValues", $sanitizedDecimalValue);
            } elseif ($type == 5) {
                //  DATE
                $sanitizedDateValue = date($this->$paramsValues);
                $stmt->bindValue(":$paramsValues", $sanitizedDateValue);
            } else {
                $stmt->bindValue(":$paramsValues", $this->$paramsValues, $type);
            }
        }
    }

    public function save($getId = false)
    {
        // TODO:: IF THE $user has an id then u want to make an update not to save the user .
        $sql = 'INSERT INTO ' . static::$table_name . ' SET ' . self::BindParams();
        $stmt = $this->db->prepare($sql);
        $this->BindValues($stmt);
        $res = $stmt->execute();
        return $getId != false ? $this->fetchBack($stmt) : $res;
    }

    private function fetchBack(\PDOStatement &$stmt)
    {

        $sql = 'SELECT LAST_INSERT_ID() as ' . static::$PK;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (is_array($result) && !empty($result)) ? $this->{static::$PK} = array_shift($result)[static::$PK] : false;
    }

    public function edit()
    {
        $sql = 'UPDATE ' . static::$table_name . ' SET ' . self::BindParams() . ' WHERE ' . static::$PK . ' = ' . $this->{static::$PK};
        $stmt = $this->db->prepare($sql);
        $this->BindValues($stmt);
        return $stmt->execute();
    }

    public function delete()
    {
        $sql = 'DELETE FROM ' . static::$table_name . ' WHERE ' . static::$PK . ' = ' . $this->{static::$PK};
        $stmt = $this->db->prepare($sql);
        return $stmt->execute();
    }

    public static function S_delete($Id)
    {
        $connection = self::connection();
        $sql = 'DELETE FROM ' . static::$table_name . ' WHERE ' . static::$PK . ' = ' . $Id;
        $stmt = $connection->prepare($sql);
        return $stmt->execute();
    }

    public function getByQuery($sql, $options = array())
    {

        $stmt = self::connection()->prepare($sql);

        if (!empty($options)) {
            foreach ($options as $columnName => $type) {
                if ($type[0] == 4) {
                    $sanitizedValue = filter_var($type[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $stmt->bindValue(":$columnName", $sanitizedValue);
                } else {
                    $stmt->bindValue(":$columnName", $type[1], $type[0]);
                }
            }
        }

        $stmt->execute();
        return self::getData($stmt);
    }

    public function getBy(array $roles = []) // asscociated array
    {
        // ["id"    => '1', 'name' => 'ahmed'];
        $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE ';
        foreach ($roles as $fieldName => $role) {
            $sql .= $fieldName . ' = "' . $role . '" AND ';
        }
        $sql = trim($sql, 'AND ');
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return self::getData($stmt);
    }
}
