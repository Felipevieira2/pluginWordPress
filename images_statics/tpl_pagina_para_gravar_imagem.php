<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<?php
	global $wpdb;
	global $table_prefix;
	if(isset($msg)){
		echo " " .$msg;
		echo $msg2;
	}
	$imagem = $wpdb-> get_results("SELECT * from {$table_prefix}statics_images ORDER BY 1 DESC");
?>

<form method="post" enctype="multipart/form-data">
 <div>
   <label for="file">Selecione a imagem</label>
   <input type="file" id="imagem" name="imagem">
 </div>
 <div>
 <?php submit_button(); ?>

</form>
 

<table class="table table-striped table-dark">

<?php 

if(is_array($imagem)){
	echo '<thead>
				<tr>
					<th scope="col">Nome:</th>
					<th scope="col">Extensão:</th>
					<th scope="col">Tamanho do Arquivo:</th>
					<th scope="col">Tamanho da Imagem:</th>
					<th scope="col">Imagem:</th>
				</tr>
			</thead>';
	foreach ($imagem as $objImagem){
		$image64 = $objImagem->imagem;
		$image64 = base64_encode($image64);
		$tamanhoImagem = getimagesize("data:image/jpeg;base64," . $image64);
		$tamanhoImagem = $tamanhoImagem[0] . 'x' . $tamanhoImagem[1];
		$image64 = "<img height='100px' weight='100px 'src=\"data:image/jpeg;base64," . $image64 . "\">";
		$tamanhoArquivo = $objImagem->tamanhoArquivo / 1000 . 'KB'; 

	     echo " <tbody>
	               <tr> 
		            <td class='text-left'>{$objImagem->nome}</td>
			        <td class='text-center'>{$objImagem->extensao}</td>
			        <td class='text-center'>{$tamanhoArquivo}</td>
			        <td class='text-center'>{$tamanhoImagem}</td>
			        <td class='text-left'>{$image64}</td>
			       </tr>
			    </tbody>";

			
			 
 	}
}

?>
</table>