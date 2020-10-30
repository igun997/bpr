<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pengaturan_Object
{

    public $id;
    public string $meta_key;
    public string $meta_value;

    public static $fields = [
          'id' ,
        'meta_key' ,
          'meta_value'
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
        $this->meta_key = (string) $object->meta_key;
        $this->meta_value = (string) $object->meta_value;

        $this->ci = Global_Helper::getCIInstance();
    }

    public static function getFields()
    {

        return self::$fields;
    }
}

class Pengaturan_Model extends Indie_Model
{

    const SORT_CREATED_ASC = 1;
    const SORT_CREATED_DESC = 2;

    public function __construct()
    {

        parent::__construct();

        $db_name = "";
        $this->db_name = $db_name;

        $this->_table_name = 'pengaturan';
        $this->_primary_key = 'id';
        $this->_object_name = 'Pengaturan_Object';
        $this->fields = Pengaturan_Object::getFields();
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
    public function withMetaKeyLike(string $meta_key)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.meta_key', $meta_key);

        return $this;
    }

    public function withMetaKey(string $meta_key)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.meta_key', $meta_key);

        return $this;
    }
    public function withMetaValueLike(string $meta_value)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.meta_value', $meta_value);

        return $this;
    }

    public function withMetaValue(string $meta_value)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.meta_value', $meta_value);

        return $this;
    }
}
