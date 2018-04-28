<?php

namespace PHPMVC\MODELS;

class FilterModel extends AbstractModel
{

    public $Id;
    public $FirstName;
    public $LastName;
    public $Email;
    public $Password;

    protected static $table_name = 'users';
    protected static $PK = 'Id';

    protected static $tableSchema = [
        'FirstName' => self::DATA_TYPE_STR,
        'LastName' => self::DATA_TYPE_STR,
        'Email' => self::DATA_TYPE_STR,
        'Password' => self::DATA_TYPE_STR,
    ];


    public static function getTheFilteredUser($name)
    {
        $sql = 'SELECT * FROM users WHERE FirstName like "%' . $name . '%" OR LastName like "%' . $name . '%" AND Status = 0';
        $users = static::getByQuery($sql);
        return $users ;
    }

}