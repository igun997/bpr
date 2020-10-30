<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_base extends CI_Migration {

	public function up() {

		## Create Table artikel
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'judul' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'cover' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'konten' => array(
				'type' => 'TEXT',
				'null' => FALSE,

			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'updated_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("artikel", TRUE);
		$this->db->query('ALTER TABLE  `artikel` ENGINE = InnoDB');

		## Create Table galeri
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'cover' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'updated_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("galeri", TRUE);
		$this->db->query('ALTER TABLE  `galeri` ENGINE = InnoDB');

		## Create Table galeri_detail
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'img' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'galeri_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("galeri_detail", TRUE);
		$this->db->query('ALTER TABLE  `galeri_detail` ENGINE = InnoDB');

		## Create Table nasabah
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'jk' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'alamat' => array(
				'type' => 'TEXT',
				'null' => FALSE,

			),
			'ktp_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'ktp_gambar' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'sk_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'sk_gambar' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'no_hp' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'status_akun' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'status_pinjaman' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'status_simpanan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'no_rekening' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'updated_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("nasabah", TRUE);
		$this->db->query('ALTER TABLE  `nasabah` ENGINE = InnoDB');

		## Create Table peminjaman
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'nasabah_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'total' => array(
				'type' => 'DOUBLE',
				'null' => FALSE,

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'produk_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'updated_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("peminjaman", TRUE);
		$this->db->query('ALTER TABLE  `peminjaman` ENGINE = InnoDB');

		## Create Table peminjaman_detail
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'peminjaman_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'total' => array(
				'type' => 'DOUBLE',
				'null' => FALSE,

			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'updated_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("peminjaman_detail", TRUE);
		$this->db->query('ALTER TABLE  `peminjaman_detail` ENGINE = InnoDB');

		## Create Table pengaturan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'meta_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'meta_value' => array(
				'type' => 'TEXT',
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("pengaturan", TRUE);
		$this->db->query('ALTER TABLE  `pengaturan` ENGINE = InnoDB');

		## Create Table produk
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'total_pinjaman' => array(
				'type' => 'DOUBLE',
				'null' => FALSE,

			),
			'suku_bunga' => array(
				'type' => 'DOUBLE',
				'null' => FALSE,

			),
			'tempo' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'img' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'updated_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("produk", TRUE);
		$this->db->query('ALTER TABLE  `produk` ENGINE = InnoDB');

		## Create Table transaksi
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'nasabah_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'total' => array(
				'type' => 'DOUBLE',
				'null' => FALSE,

			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'tipe' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'updated_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("transaksi", TRUE);
		$this->db->query('ALTER TABLE  `transaksi` ENGINE = InnoDB');

		## Create Table users
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'level' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'created_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'updated_at' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("users", TRUE);
		$this->db->query('ALTER TABLE  `users` ENGINE = InnoDB');
	 }

	public function down()	{
		### Drop table artikel ##
		$this->dbforge->drop_table("artikel", TRUE);
		### Drop table galeri ##
		$this->dbforge->drop_table("galeri", TRUE);
		### Drop table galeri_detail ##
		$this->dbforge->drop_table("galeri_detail", TRUE);
		### Drop table nasabah ##
		$this->dbforge->drop_table("nasabah", TRUE);
		### Drop table peminjaman ##
		$this->dbforge->drop_table("peminjaman", TRUE);
		### Drop table peminjaman_detail ##
		$this->dbforge->drop_table("peminjaman_detail", TRUE);
		### Drop table pengaturan ##
		$this->dbforge->drop_table("pengaturan", TRUE);
		### Drop table produk ##
		$this->dbforge->drop_table("produk", TRUE);
		### Drop table transaksi ##
		$this->dbforge->drop_table("transaksi", TRUE);
		### Drop table users ##
		$this->dbforge->drop_table("users", TRUE);

	}
}