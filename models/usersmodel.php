<?php

namespace PHPMVC\MODELS;

class UsersModel extends AbstractModel
{

    public $Id;
    public $FirstName;
    public $LastName;
    public $Email;
    public $Password;
    public $Status ;
    public $Code ;

    protected static $table_name = 'users';
    protected static $PK = 'Id';

    protected static $tableSchema = [
        'FirstName' => self::DATA_TYPE_STR,
        'LastName' => self::DATA_TYPE_STR,
        'Email' => self::DATA_TYPE_STR,
        'Password' => self::DATA_TYPE_STR,
        'Status' => self::DATA_TYPE_INT,
        'Code' => self::DATA_TYPE_STR,
    ];

}