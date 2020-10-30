<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Peminjaman_Detail_Object
{

    public $id;
    public int $peminjaman_id;
    public $total;
    public int $user_id;
    public $created_at;
    public $updated_at;

    public static $fields = [
          'id' ,
        'peminjaman_id' ,
         'total' ,
         'user_id' ,
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
        $this->peminjaman_id = intval($object->peminjaman_id);
        $this->user_id = intval($object->user_id);

        $this->ci = Global_Helper::getCIInstance();
    }

    public static function getFields()
    {

        return self::$fields;
    }
}

class Peminjaman_Detail_Model extends Indie_Model
{

    const SORT_CREATED_ASC = 1;
    const SORT_CREATED_DESC = 2;

    public function __construct()
    {

        parent::__construct();

        $db_name = "";
        $this->db_name = $db_name;

        $this->_table_name = 'peminjaman_detail';
        $this->_primary_key = 'id';
        $this->_object_name = 'Peminjaman_Detail_Object';
        $this->fields = Peminjaman_Detail_Object::getFields();
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
    public function withPeminjamanIdLike(int $peminjaman_id)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.peminjaman_id', $peminjaman_id);

        return $this;
    }

    public function withPeminjamanId(int $peminjaman_id)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.peminjaman_id', $peminjaman_id);

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
    public function withTotalLike($total)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.total', $total);

        return $this;
    }

    public function withTotal($total)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.total', $total);

        return $this;
    }
}
