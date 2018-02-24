 <form method="POST" enctype="multipart/form-data" autocomplete="off">
    <input type="file" name="tImagem-1"/>
	<br/>
    <input type="submit" value="Enviar">
 </form>

<?php 

  if (isset($_FILES['tImagem-1']) && $_FILES['tImagem-1']['error'] == 0) {
      $imagem = array();
      $imagem = $_FILES['tImagem-1'];
      $url = save_image($imagem);
	  echo $url;
  }
  
  /**
   * Está função é responsável para salva uma imágem no diretório uploads/usuarios/
   * @return String "url da imagem" ou null
   * @author Joab Torres <joabtorres1508@gmail.com>
   */
  function save_image($file) {
      $imagem = array();
      $largura = 140; //largura desejada
      $altura = 140; // altura deseada
      $imagem['diretorio'] = 'uploads/estoque'; //diretório desejado
      $imagem['temp'] = $file['tmp_name'];
      $imagem['extensao'] = explode(".", $file['name']);
      $imagem['extensao'] = strtolower(end($imagem['extensao']));
      $imagem['name'] = md5(rand(1000, 900000) . time()) . '.' . $imagem['extensao'];
      if ($imagem['extensao'] == 'jpg' || $imagem['extensao'] == 'jpeg' || $imagem['extensao'] == 'png') {

          list($larguraOriginal, $alturaOriginal) = getimagesize($imagem['temp']);


          $ratio = max($largura / $larguraOriginal, $altura / $alturaOriginal);
          $alturaOriginal = $altura / $ratio;
          $x = ($larguraOriginal - $largura / $ratio) / 2; //transforma a imagem em guadrada
          $larguraOriginal = $largura / $ratio;


          $imagem_final = imagecreatetruecolor($largura, $altura);

          if ($imagem['extensao'] == 'jpg' || $imagem['extensao'] == 'jpeg') {
              $imagem_original = imagecreatefromjpeg($imagem['temp']);
              imagecopyresampled($imagem_final, $imagem_original, 0, 0, $x, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
              imagejpeg($imagem_final, $imagem['diretorio'] . "/" . $imagem['name'], 90);
          } else if ($imagem['extensao'] == 'png') {
              $imagem_original = imagecreatefrompng($imagem['temp']);
              imagecopyresampled($imagem_final, $imagem_original, 0, 0, $x, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
              imagepng($imagem_final, $imagem['diretorio'] . "/" . $imagem['name']);
          }
          return $imagem['diretorio'] . "/" . $imagem['name'];
      } else {
          return null;
      }
  }
?>