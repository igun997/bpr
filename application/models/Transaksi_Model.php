<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Transaksi_Object
{

    public $id;
    public int $nasabah_id;
    public $total;
    public int $user_id;
    public int $tipe;
    public $created_at;
    public $updated_at;

    public static $fields = [
          'id' ,
        'nasabah_id' ,
        'total' ,
         'user_id' ,
       'tipe' ,
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
        $this->nasabah_id = intval($object->nasabah_id);
        $this->user_id = intval($object->user_id);
        $this->tipe = intval($object->tipe);

        $this->ci = Global_Helper::getCIInstance();
    }

    public static function getFields()
    {

        return self::$fields;
    }
}

class Transaksi_Model extends Indie_Model
{

    const SORT_CREATED_ASC = 1;
    const SORT_CREATED_DESC = 2;

    public function __construct()
    {

        parent::__construct();

        $db_name = "";
        $this->db_name = $db_name;

        $this->_table_name = 'transaksi';
        $this->_primary_key = 'id';
        $this->_object_name = 'Transaksi_Object';
        $this->fields = Transaksi_Object::getFields();
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
    public function withNasabahIdLike(int $nasabah_id)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.nasabah_id', $nasabah_id);

        return $this;
    }

    public function withNasabahId(int $nasabah_id)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.nasabah_id', $nasabah_id);

        return $this;
    }
    public function withUserIdLike(int $user_id)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.user_id', $user_id);

        return $this;
    }

    public function withUserId(int $user_id)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.user_id', $user_id);

        return $this;
    }
    public function withTipeLike(int $tipe)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.tipe', $tipe);

        return $this;
    }

    public function withTipe(int $tipe)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.tipe', $tipe);

        return $this;
    }
}
