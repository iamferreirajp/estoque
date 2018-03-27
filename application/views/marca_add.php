<?php 

	
	echo form_open('marca/create', 'class="form-cadastro"');
	$field_array = array('Nome');
	
	echo heading($headline, 3, 'class="form-cadastro-heading"');
	echo br();

	echo form_input('nome_marca', '', 'title="Nome da marca do produto" class="input-block-level input-xlarge" placeholder="Nome" required');	
	echo br();

	echo form_submit('', 'Cadastrar', 'class="btn btn-primary"');
	echo form_close();
	
	
	
/* End of file marca_add.php */
/* Location: ./system/application/views/marca_add.php */