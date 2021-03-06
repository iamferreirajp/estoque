﻿<?php 

	echo form_open('produto/update', 'class="form-cadastro"');
	$field_array = array('Codigo', 'Nome', 'Categoria', 'Marca', 'Minimo');
	
	echo heading($headline, 3, 'class="form-cadastro-heading"');
	echo br();
	
	echo form_hidden('id_produto', $produto[0]->id_produto);
	
	echo form_input('codigo', $produto[0]->codigo, 'title="Código do produto formado por 3 caracteres iniciais do tipo e 3 digitos sequenciais daquele tipo" class="required input-block-level input-xlarge" placeholder="Código"');
	echo br();
	
	echo form_input('nome_produto', $produto[0]->nome_produto, 'title="Nome do produto" class="required input-block-level input-xlarge" placeholder="Nome"');
	echo br();
	
	echo ('<select name="categoria" title="Categoria ou tipo de Produto" class="required input-block-level input-xlarge">');
	foreach($categorias->result() as $categoria):
		echo ('<option value="'.$categoria->id_categoria.'"'); 
			if($categoria->id_categoria == $produto[0]->categoria) 
				echo ('selected="selected"');
			echo('>'.$categoria->nome_categoria.'</option>');
	endforeach;
	echo ('</select>');
	
	echo ('<select name="marca" title="marca de medida do produto" class="required input-block-level input-xlarge">');
	foreach($marcas->result() as $marca):
		echo ('<option value="'.$marca->id_marca.'"');
			if($marca->id_marca == $produto[0]->marca)
				echo('selected="selected"');
			echo('>'.$marca->nome_marca.'</option>');
	endforeach;
	echo ('</select>');
	echo br();
	
	echo form_submit('', 'Atualizar', 'class="btn btn-primary"'); 
	echo form_close();
	
/* End of file produto_edit.php */
/* Location: ./system/application/views/produto_edit.php */