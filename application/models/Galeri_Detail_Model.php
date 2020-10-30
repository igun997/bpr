<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Galeri_Detail_Object
{

    public $id;
    public string $img;
    public int $galeri_id;

    public static $fields = [
          'id' ,
        'img' ,
       'galeri_id'
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
        $this->img = (string) $object->img;
        $this->galeri_id = intval($object->galeri_id);

        $this->ci = Global_Helper::getCIInstance();
    }

    public static function getFields()
    {

        return self::$fields;
    }
}

class Galeri_Detail_Model extends Indie_Model
{

    const SORT_CREATED_ASC = 1;
    const SORT_CREATED_DESC = 2;

    public function __construct()
    {

        parent::__construct();

        $db_name = "";
        $this->db_name = $db_name;

        $this->_table_name = 'galeri_detail';
        $this->_primary_key = 'id';
        $this->_object_name = 'Galeri_Detail_Object';
        $this->fields = Galeri_Detail_Object::getFields();
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
    public function withGaleriIdLike(int $galeri_id)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.galeri_id', $galeri_id);

        return $this;
    }

    public function withGaleriId(int $galeri_id)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.galeri_id', $galeri_id);

        return $this;
    }
}
