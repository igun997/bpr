<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
    public $blade;
	public function __construct()
	{
		parent::__construct();
		$this->blade = new Blade_helper();
		$this->load->model("User_Model","user_model");
	}

    public function index()
    {

        $this->blade->view("layout.landing");
	}
}
/* End of file '/Main.php' */
/* Location: ./application/controllers//Main.php */
