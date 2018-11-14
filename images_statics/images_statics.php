<?php 
/**
 * Plugin Name: Images Statics
 * Plugin URI: http://sp.senac.br/
 * Description: Images Statics
 * Version: 1.0.0
 * Author: Felipe Vieira, Henrique César. 
 * Author URI: http://sp.senac.br/
 * License: CC BY
 */

register_activation_hook(__FILE__, 'instala_statics_images');

function instala_statics_images(){
        global $wpdb;
        global $table_prefix;
 
		$wpdb->query("CREATE TABLE {$table_prefix}statics_images
		(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		 nome CHAR(255) NOT NULL,
		 extensao CHAR(255) NOT NULL,
		 tamanhoArquivo CHAR(255) NOT NULL,
         tamanhoImagem CHAR(255) NULL,
		 imagem LONGBLOB NULL);");	
}
add_action('admin_menu','tela_gravar_imagem');
function tela_gravar_imagem(){
	 add_submenu_page('options-general.php',
			'Images Statics',
			'Gravar Imagem',
			'administrator',
			'statics_images-config',
			'pagina_para_gravar_imagem');
}

function pagina_para_gravar_imagem(){
	global $wpdb;
	global $table_prefix;

        if (isset($_FILES['imagem'])) {
            $foto = $_FILES['imagem'];

             if(empty($foto['tmp_name'])){
               $msg = "Por favor selecionar a imagem";
             }else{                               
                $nome = $foto['name'];
                $tipo = $foto['type'];
                $tamanhoArquivo = $foto['size'];
                $arquivo = $foto['tmp_name'];
                $imagem = fopen($arquivo, "r");
                $fileParaDB = fread($imagem, $tamanhoArquivo);
                $fileParaDB = addslashes($fileParaDB);
                $teste = "$fileParaDB";
                if ($wpdb->query("INSERT INTO 
    		   			                {$table_prefix}statics_images 
                                        (nome, extensao, tamanhoArquivo, tamanhoImagem, imagem)
                                    VALUES
                                        ('$nome','$tipo', '$tamanhoArquivo','500x500', '$fileParaDB')"))
                {
                    $msg = 'Imagem gravada com sucesso';
                } else {
                    $msg = 'Erro ao gravar';
                }
	       }
   
	       $imagem = $wpdb-> get_results("SELECT * from {$table_prefix}statics_images ORDER BY 1 DESC");
        }
        

    include('tpl_pagina_para_gravar_imagem.php');
}

register_deactivation_hook(__FILE__, 'desinstala_images_statics');
function listarImagens(){
    global $wpdb;
    global $table_prefix;
    $imagem = $wpdb-> get_results("SELECT * from {$table_prefix}statics_images ORDER BY 1 DESC");
}
function desinstala_images_statics(){
  global $wpdb;
  global $table_prefix;

  $wpdb->query("DROP TABLE {$table_prefix}statics_images");
}
?>