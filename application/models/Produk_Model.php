<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produk_Object
{

    public $id;
    public string $nama;
    public $total_pinjaman;
    public $suku_bunga;
    public int $tempo;
    public int $status;
    public string $img;
    public $created_at;
    public $updated_at;

    public static $fields = [
          'id' ,
        'nama' ,
          'total_pinjaman' ,
        'suku_bunga' ,
        'tempo' ,
         'status' ,
        'img' ,
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
        $this->tempo = intval($object->tempo);
        $this->status = intval($object->status);
        $this->img = (string) $object->img;

        $this->ci = Global_Helper::getCIInstance();
    }

    public static function getFields()
    {

        return self::$fields;
    }
}

class Produk_Model extends Indie_Model
{

    const SORT_CREATED_ASC = 1;
    const SORT_CREATED_DESC = 2;

    public function __construct()
    {

        parent::__construct();

        $db_name = "";
        $this->db_name = $db_name;

        $this->_table_name = 'produk';
        $this->_primary_key = 'id';
        $this->_object_name = 'Produk_Object';
        $this->fields = Produk_Object::getFields();
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
    public function withTotalPinjamanLike($total_pinjaman)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.total_pinjaman', $total_pinjaman);

        return $this;
    }

    public function withTotalPinjaman($total_pinjaman)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.total_pinjaman', $total_pinjaman);

        return $this;
    }
    public function withTempoLike(int $tempo)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.tempo', $tempo);

        return $this;
    }

    public function withTempo(int $tempo)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.tempo', $tempo);

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
