<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produto extends CI_Controller {

	public function Produto() 
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
        $data['title'] = "Cadastro de Produto - Controle de Estoque";
        $data['headline'] = "Cadastro de Produtos";
        $data['include'] = "produto_add";
		$this->load->model('MMarca', '', TRUE);
		$data['marcas'] = $this->MMarca->listMarca();
		$this->load->model('MCategoria', '', TRUE);
		$data['categorias'] = $this->MCategoria->listCategoria();
        $this->load->view('template', $data);
    }
	
	function create()
    {
        $this->load->model('MProduto','',TRUE);
        $codigo = $_POST["codigo"];
        $nome_produto = $_POST["nome_produto"];
        $marca = $_POST["marca"];
        $categoria = $_POST["categoria"];
        $foto = $_FILES["imagem"];
		if (!empty($foto["name"])) {
			
			// Largura máxima em pixels
			$largura = 1500;
			// Altura máxima em pixels
			$altura = 1800;
			// Tamanho máximo do arquivo em bytes
			$tamanho = 2000000;
	 
			$error = array();
	 
	    	// Verifica se o arquivo é uma imagem
	    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
	     	   $error[1] = "Isso não é uma imagem.";
	   	 	} 
		
			// Pega as dimensões da imagem
			$dimensoes = getimagesize($foto["tmp_name"]);
		
			// Verifica se a largura da imagem é maior que a largura permitida
			if($dimensoes[0] > $largura) {
				$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
			}
	 
			// Verifica se a altura da imagem é maior que a altura permitida
			if($dimensoes[1] > $altura) {
				$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
			}
			
			// Verifica se o tamanho da imagem é maior que o tamanho permitido
			if($foto["size"] > $tamanho) {
	   		 	$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
			}
	 
			// Se não houver nenhum erro
			if (count($error) == 0) {
			
				// Pega extensão da imagem
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
	 
	        	// Gera um nome único para a imagem
	        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
	 
	        	// Caminho de onde ficará a imagem
	        	$caminho_imagem = $_SERVER['DOCUMENT_ROOT']."/estoque/assets/images/produtos/" . $nome_imagem;
	 
				// Faz o upload da imagem para seu respectivo caminho
				move_uploaded_file($foto["tmp_name"], $caminho_imagem);
			
				// Insere os dados no banco
				$sql = mysql_query("INSERT INTO produto VALUES ('', '".$codigo."', '".$nome_produto."','', '".$marca."', '".$categoria."', '".$nome_imagem."')");
			
			}
		
			// Se houver mensagens de erro, exibe-as
			if (count($error) != 0) {
				foreach ($error as $erro) {
					echo $erro . "<br />";
				}
			}
	}

        //$this->MProduto->addProduto($_POST);
        redirect('produto/listing', 'refresh');
    }
	
	function edit()
	{
		$id = $this->uri->segment(3);
		$this->load->model('MProduto', '', TRUE);
		$data['produto'] = $this->MProduto->getProduto($id)->result();
		$data['title'] = "Modificar Produto - Controle de Estoque";
		$data['headline'] = "Edição de Produtos";
		$data['include'] = "produto_edit";
		$this->load->model('MMarca', '', TRUE);
		$data['marcas'] = $this->MMarca->listMarca();
		$this->load->model('MCategoria', '', TRUE);
		$data['categorias'] = $this->MCategoria->listCategoria();
		$this->load->view('template', $data);
	}
	
	function update()
	{
		$this->load->model('MProduto','',TRUE);
		$this->MProduto->updateProduto($_POST['id_produto'], $_POST);
		redirect('produto/listing', 'refresh');
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$this->load->model('MProduto','',TRUE);
		$this->MProduto->deleteProduto($id);
		redirect('produto/listing', 'refresh');
	}

	function listing()
	{
		$this->load->model('MProduto','',TRUE);
		$qry = $this->MProduto->listProduto();
		$table = $this->table->generate($qry);
		$tmpl = array ( 'table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;"); 
		$this->table->set_heading('Codigo', 'Nome', 'Categoria', 'Marca', 'Imagem', 'Editar', 'Excluir');
		$table_row = array();
		foreach ($qry->result() as $produto)
		{
			$table_row = NULL;
			$table_row[] = $produto->codigo;
			$table_row[] = $produto->nome_produto;
			$table_row[] = $produto->nome_categoria;
			$table_row[] = $produto->nome_marca;
			$caminho_imagem = base_url("/assets/images/produtos/" . $produto->imagem);
			$imagem = '<img src="'.$caminho_imagem.'" alt="" width="300" height="300">';
			$table_row[] = $imagem;//$produto->imagem;
			$table_row[] = anchor('produto/edit/' . $produto->id_produto, '<span class="ui-icon ui-icon-pencil"></span>');
			$table_row[] = anchor('produto/delete/' . $produto->id_produto, '<span class="ui-icon ui-icon-trash"></span>', 
							"onClick=\" return confirm('Tem certeza que deseja remover o registro?')\"");
			$this->table->add_row($table_row);
		}    
		$table = $this->table->generate();
		$data['title'] = "Listagem de Produtos - Controle de Estoque";
		$data['headline'] = "Listagem de Produtos";
		$data['include'] = 'produto_listing';
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}
}

/* End of file Produto.php */
/* Location: ./application/controllers/Produto.php */