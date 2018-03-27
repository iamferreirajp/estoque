<?php 

	echo form_open('estoque/update', 'class="form-cadastro"');
	$field_array = array('Produto', 'Quantidade');
	
	echo heading($headline, 3, 'class="form-cadastro-heading"');
	echo br();
	
	echo form_hidden('id_estoque', $estoque[0]->id_estoque);
	
	echo ('<select name="produto" disabled="disabled" class="input-block-level input-xlarge" >');
	foreach($produtos->result() as $produto):
		echo ('<option value="'.$produto->id_produto.'"'); 
			if($produto->id_produto == $estoque[0]->produto) 
				echo ('selected="selected"');
			echo('>'.$produto->nome_produto.'</option>');
	endforeach;
	echo ('</select>');
	echo ("Produtos disponíveis na loja:");
	echo form_input('quantidade_loja', $estoque[0]->quantidade_loja, 'title="Quantidade do produto disponível na loja." class="input-block-level input-xlarge"');
	echo br();
	echo ("Produtos disponíveis no depósito:");
	echo form_input('quantidade_deposito', $estoque[0]->quantidade_deposito, 'title="Quantidade do produto disponível no depósito." class="input-block-level input-xlarge"');
	echo br();
	
	echo form_submit('', 'Atualizar', 'class="btn btn-primary"'); 
	echo form_close();
	
/* End of file estoque_edit.php */
/* Location: ./system/application/views/estoque_edit.php */