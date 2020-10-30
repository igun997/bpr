<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Artikel_Object
{

    public $id;
    public string $judul;
    public string $cover;
    public string $konten;
    public $created_at;
    public $updated_at;

    public static $fields = [
          'id' ,
        'judul' ,
         'cover' ,
         'konten' ,
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
        $this->judul = (string) $object->judul;
        $this->cover = (string) $object->cover;
        $this->konten = (string) $object->konten;

        $this->ci = Global_Helper::getCIInstance();
    }

    public static function getFields()
    {

        return self::$fields;
    }
}

class Artikel_Model extends Indie_Model
{

    const SORT_CREATED_ASC = 1;
    const SORT_CREATED_DESC = 2;

    public function __construct()
    {

        parent::__construct();

        $db_name = "";
        $this->db_name = $db_name;

        $this->_table_name = 'artikel';
        $this->_primary_key = 'id';
        $this->_object_name = 'Artikel_Object';
        $this->fields = Artikel_Object::getFields();
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
}
