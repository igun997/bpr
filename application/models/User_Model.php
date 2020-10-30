<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_Object
{

    public $id;
    public string $nama;
    public string $email;
    public string $username;
    public string $password;
    public int $level;
    public int $status;
    public $created_at;
    public $updated_at;

    public static $fields = [
          'id' ,
        'nama' ,
          'email' ,
         'username' ,
          'password' ,
          'level' ,
         'status' ,
        'created_at' ,
        'updated_at'
    ];


    // CI Global Object
    private $ci;

    public function __construct(object $object)
    {
        foreach (self::$fields as $field) {
            if (Global_Helper::isObjectEmpty($object, $field)) {
                $object->$field = null;
            }
        }

        $this->id = ($object->id === null) ? null : intval($object->id);
        $this->nama = (string) $object->nama;
        $this->email = (string) $object->email;
        $this->username = (string) $object->username;
        $this->password = (string) $object->password;
        $this->level = intval($object->level);
        $this->status = intval($object->status);

        $this->ci = Global_Helper::getCIInstance();
    }

    public static function getFields()
    {

        return self::$fields;
    }
}

class User_Model extends Indie_Model
{

    const SORT_CREATED_ASC = 1;
    const SORT_CREATED_DESC = 2;

    public function __construct()
    {

        parent::__construct();

        $db_name = $this->db->database;
        $this->db_name = $db_name;

        $this->_table_name = 'users';
        $this->_primary_key = 'id';
        $this->_object_name = 'User_Object';
        $this->fields = User_Object::getFields();
    }

    public function sortData(int $method)
    {

        switch (intval($method)) {
            case self::SORT_CREATED_ASC:
                $this->db->order_by($this->_table_name.'.time_created', 'asc');
                break;
            case self::SORT_CREATED_DESC:
                $this->db->order_by($this->_table_name.'.time_created', 'desc');
                break;

            default:
                break;
        }

        return $this;
    }
    public function withNamaLike(string $nama)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.nama', $nama);

        return $this;
    }

    public function withNama(string $nama)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.nama', $nama);

        return $this;
    }
    public function withEmailLike(string $email)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.email', $email);

        return $this;
    }

    public function withEmail(string $email)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.email', $email);

        return $this;
    }
    public function withUsernameLike(string $username)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.username', $username);

        return $this;
    }

    public function withUsername(string $username)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.username', $username);

        return $this;
    }
    public function withPasswordLike(string $password)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.password', $password);

        return $this;
    }

    public function withPassword(string $password)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.password', $password);

        return $this;
    }
    public function withLevelLike(int $level)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.level', $level);

        return $this;
    }

    public function withLevel(int $level)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.level', $level);

        return $this;
    }
    public function withStatusLike(int $status)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.status', $status);

        return $this;
    }

    public function withStatus(int $status)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.status', $status);

        return $this;
    }
}
