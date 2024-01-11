<!DOCTYPE html>
<!-------------------------------------------------------------------------------
    Desenvolvimento Web
    PUCPR
    Profa. Cristina V. P. B. Souza
    Agosto/2022
---------------------------------------------------------------------------------->
<!-- medIncluir_exe.php -->

<html>
<head>
	<title>Clínica Médica ABC</title>
	<link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
</head>

<body onload="w3_show_nav('menuMedico')">
	<!-- Inclui MENU.PHP  -->
	<?php require 'geral/menu.php'; ?>
	<?php require 'bd/conectaBD.php'; ?>
	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container" style="margin-left:270px;margin-top:130px;">

		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate">
				<!-- Acesso em:-->
				<?php

				date_default_timezone_set("America/Sao_Paulo");
				$data = date("d/m/Y H:i:s", time());
				echo "<p class='w3-small' > ";
				echo "Acesso em: ";
				echo $data;
				echo "</p> "
				?>

				<!-- Acesso ao BD-->
				<?php
				$fullname = $_POST['fullname'];
				$cpf = $_POST['cpf'];
				$dt_nasc  = $_POST['dt_nasc'];
				$logradouro =  $_POST['logradouro'];
				$num_casa =  $_POST['num_casa'];
				$complemento =  $_POST['complemento'];
				$bairro =  $_POST['bairro'];
				$cidade =  $_POST['cidade'];
				$uf =  $_POST['UF'];
				$celular =  $_POST['celular'];
				$profession = $_POST['profession'];
				$email =  $_POST['email'];
				$sexo_genero =  $_POST['sexo_genero'];
				$pcd_responsavel =  $_POST['UF'];
				$nome_pdc =  $_POST['UF'];
				$escola_pcd =  $_POST['UF'];
				$trabalho_pcd =  $_POST['UF'];
				$dfciencia = $_POST['deficiencia'];

				// rotina inclusão endereço
				INSERT INTO addresses (logradouro, numero, complemento, bairro, cidade, cep, estado, phones, socios_id_socio)
										VALUES
										($logradouro, $num_casa, $complemento, $bairro, $cidade, ?????$cep, $uf, $celular, ??????????$socios_id_socio );



z
				
				// Cria conexão
				$conn = new mysqli($servername, $username, $password, $database);
				// Verifica conexão
				if ($conn->connect_error) {
					die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
				}
				//carrega a variável pcd_deficiência para a partir de pcd_responsável.
				$pcd_deficiencia = 1;
				if ($pcd_responsavel != "pcd") { 
					$pcd_deficiencia = 0;
				}
				$status = 1; //marca o sócio na inclusão como ativo, default!
				$realiza_trab_voluntario = "sim";

				// Faz Select na Base de Dados	
				/*
				INSERT INTO socios (fullname, cpf, celular, email, dt_nasc, profission, 
									pcd_deficiencia, parentesco_responsavel, status, 
									sexo_genero, deficiencias, escola_pcd, local_trabalho_pcd,
									realiza_trab_voluntario, criado_changed, imagem) 
									VALUES 
									("Marcos", "200", "999742598", "marcos.carreira@gmail.com", "1976-11-11", "Professor", 
									0, "pai", 1, 
									"M", NULL, NULL, NULL, 
									NULL, "2024-01-09 23:50:01", NULL);
				*/

				if ($_FILES['imagem']['size'] == 0) { // Não recebeu uma imagem binária
					$sql = "INSERT INTO socios (fullname, cpf, celular, email, dt_nasc, profission, 
												pcd_deficiencia, parentesco_responsavel, status, 
												sexo_genero, deficiencias, escola_pcd, local_trabalho_pcd, 
												realiza_trab_voluntario, criado_changed, imagem) 
										VALUES ('$fullname', '$cpf', '$celular', '$email', '$dt_nasc', '$profession', 
												$pcd_deficiencia, '$pcd_responsavel', $status, 
												'$sexo_genero', '$dfciencia', '$escola_pcd', '$trabalho_pcd', 
												'$realiza_trab_voluntario', '$data', NULL);";
				} else {                              // Recebeu uma imagem binária (preciso finalizar ess query 10/01/2024, igual e de cima.)
					$imagem = addslashes(file_get_contents($_FILES['Imagem']['tmp_name'])); // Prepara para salvar em BD
					$sql = "INSERT INTO socio (Nome, CRM, Dt_Nasc, ID_Espec, Foto) VALUES ('$fullname','$CRM','$dtNasc', '$espec','$imagem')";
				}
				
				?>
				<div class='w3-responsive w3-card-4'>
					<div class="w3-container w3-theme">
						<h2>Inclusão de Novo Associado</h2>
					</div>
					<?php
					if ($result = $conn->query($sql)) {
						echo "<p>&nbsp;Registro cadastrado com sucesso! </p>";
					} else {
						echo "<p style='text-align:center'>Erro executando INSERT: " . $conn->connect_error . "</p>";
					}
					echo "</div>";
					$conn->close();  //Encerra conexao com o BD

					?>
				</div>
			</div>

			<?php require 'geral/sobre.php'; ?>
			<!-- FIM PRINCIPAL -->
		</div>
		<!-- Inclui RODAPE.PHP  -->
		<?php require 'geral/rodape.php'; ?>

</body>

</html>