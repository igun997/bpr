<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Nasabah_Object
{

    public $id;
    public int $user_id;
    public string $nama;
    public int $jk;
    public string $alamat;
    public ?string $ktp_no;
    public ?string $ktp_gambar;
    public ?string $sk_no;
    public ?string $sk_gambar;
    public string $no_hp;
    public int $status_akun;
    public int $status_pinjaman;
    public int $status_simpanan;
    public ?string $no_rekening;
    public $created_at;
    public $updated_at;

    public static $fields = [
          'id' ,
        'user_id' ,
       'nama' ,
          'jk' ,
        'alamat' ,
        'ktp_no' ,
        'ktp_gambar' ,
        'sk_no' ,
         'sk_gambar' ,
         'no_hp' ,
         'status_akun' ,
       'status_pinjaman' ,
       'status_simpanan' ,
       'no_rekening' ,
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
        $this->user_id = intval($object->user_id);
        $this->nama = (string) $object->nama;
        $this->jk = intval($object->jk);
        $this->alamat = (string) $object->alamat;
        $this->ktp_no = ($object->ktp_no === null) ? null : ($object->ktp_no);
        $this->ktp_gambar = ($object->ktp_gambar === null) ? null : ($object->ktp_gambar);
        $this->sk_no = ($object->sk_no === null) ? null : ($object->sk_no);
        $this->sk_gambar = ($object->sk_gambar === null) ? null : ($object->sk_gambar);
        $this->no_hp = (string) $object->no_hp;
        $this->status_akun = intval($object->status_akun);
        $this->status_pinjaman = intval($object->status_pinjaman);
        $this->status_simpanan = intval($object->status_simpanan);
        $this->no_rekening = ($object->no_rekening === null) ? null : ($object->no_rekening);

        $this->ci = Global_Helper::getCIInstance();
    }

    public static function getFields()
    {

        return self::$fields;
    }
}

class Nasabah_Model extends Indie_Model
{

    const SORT_CREATED_ASC = 1;
    const SORT_CREATED_DESC = 2;

    public function __construct()
    {

        parent::__construct();

        $db_name = "";
        $this->db_name = $db_name;

        $this->_table_name = 'nasabah';
        $this->_primary_key = 'id';
        $this->_object_name = 'Nasabah_Object';
        $this->fields = Nasabah_Object::getFields();
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
    public function withJkLike(int $jk)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.jk', $jk);

        return $this;
    }

    public function withJk(int $jk)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.jk', $jk);

        return $this;
    }
    public function withKtpNoLike(?string $ktp_no)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.ktp_no', $ktp_no);

        return $this;
    }

    public function withKtpNo(?string $ktp_no)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.ktp_no', $ktp_no);

        return $this;
    }
    public function withSkNoLike(?string $sk_no)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.sk_no', $sk_no);

        return $this;
    }

    public function withSkNo(?string $sk_no)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.sk_no', $sk_no);

        return $this;
    }
    public function withStatusAkunLike(int $status_akun)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.status_akun', $status_akun);

        return $this;
    }

    public function withStatusAkun(int $status_akun)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.status_akun', $status_akun);

        return $this;
    }
    public function withStatusPinjamanLike(int $status_pinjaman)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.status_pinjaman', $status_pinjaman);

        return $this;
    }

    public function withStatusPinjaman(int $status_pinjaman)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.status_pinjaman', $status_pinjaman);

        return $this;
    }
    public function withStatusSimpananLike(int $status_simpanan)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.status_simpanan', $status_simpanan);

        return $this;
    }

    public function withStatusSimpanan(int $status_simpanan)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.status_simpanan', $status_simpanan);

        return $this;
    }
    public function withNoRekeningLike(?string $no_rekening)
    {

        $this->_start_query_cache();

        $this->db->like($this->_table_name . '.no_rekening', $no_rekening);

        return $this;
    }

    public function withNoRekening(?string $no_rekening)
    {

        $this->_start_query_cache();

        $this->db->where($this->_table_name . '.no_rekening', $no_rekening);

        return $this;
    }
}
