<!DOCTYPE html>
<!-------------------------------------------------------------------------------
    Desenvolvimento Web
    PUCPR
    Profa. Cristina V. P. B. Souza
    Agosto/2022
---------------------------------------------------------------------------------->
<!-- medExcluir.php -->

<html>
	<head>

	  <title>Observatório da Inclusão - APP</title>
	  <link rel="icon" type="image/png" href="imagens/favicon.png" />
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	  <link rel="stylesheet" href="css/customize.css">
	</head>
<body onload="w3_show_nav('menuMedico')">
<!-- Inclui MENU.PHP  -->
<?php require 'geral/menu.php';?>
<?php require 'bd/conectaBD.php'; ?>

<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
<div class="w3-main w3-container" style="margin-left:270px;margin-top:130px;">

<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
  <p class="w3-large">
  <div class="w3-code cssHigh notranslate">
  <!-- Acesso em:-->
	<?php

	date_default_timezone_set("America/Sao_Paulo");
	$data = date("d/m/Y H:i:s",time());
	echo "<p class='w3-small' > ";
	echo "Acesso em: ";
	echo $data;
	echo "</p> "
	?>
	<div class="w3-container w3-theme">
	<h2>Exclusão de Associado</h2>
	</div>

	<!-- Acesso ao BD-->
	<?php
				
		// Cria conexão
		$conn = mysqli_connect($servername, $username, $password, $database);
		
		//ID do registro a ser excluído
		$id = $_POST['Id'];

		// Verifica conexão
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		// Iniciar transação
		$conn->begin_transaction();

		Try{
			// Primeiro DELETE
			$sql1 = "DELETE FROM socios WHERE id = $id";
			if (!$conn->query($sql1)) {
				throw new Exception("Erro ao deletar da tabela socios: " . $conn->error);
			}		
			// Segundo DELETE
			$sql2 = "DELETE FROM addresses WHERE id = $id";
			if (!$conn->query($sql2)) {
				throw new Exception("Erro ao deletar da tabela addresses: " . $conn->error);
			}		
			// Se tudo deu certo, commit na transação
			$conn->commit();
			echo "<p><p>Registros excluídos com sucesso.";

		 } catch (Exception $e) {
			// Se houve erro, rollback na transação
			$conn->rollback();
			echo "Falha ao deletar registros: " . $e->getMessage();
	 	}	 
		$conn->close(); 	
		
		?>

  	</div>
	</div>


	<?php require 'geral/sobre.php';?>
	<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php';?>

</body>
</html>
