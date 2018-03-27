<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marca extends CI_Controller {

	public function Marca() 
	{
		parent::__construct();
		$this->check_isvalidated();
	}
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }
	
	function add()
    {
        $data['title'] = "Cadastro de Marca - Controle de Estoque";
        $data['headline'] = "Cadastro de Marca";
        $data['include'] = "marca_add";
        $this->load->view('template', $data);
    }
	
	function create()
    {
        $this->load->model('MMarca','',TRUE);
        $this->MMarca->addMarca($_POST);
        redirect('produto/add', 'refresh');
    }
	
}

/* End of file Marca.php */
/* Location: ./application/controllers/Marca.php */