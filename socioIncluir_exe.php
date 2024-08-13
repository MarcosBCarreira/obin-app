<?php require 'geral/menu.php'; ?>
<?php require 'bd/conectaBD.php'; ?>
<!-- Inclui MENU.PHP  -->

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
	<title>Observatório da Inclusão - APP</title>
	<link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
</head>

<body onload="w3_show_nav('menuMedico')">
	

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
				/* 
				Campos específicos:
				Associado
				1) É responsável por PCD?
				2) Nome da PCD
				
				Associado PCD
				1) Deficiência
				2) Nome da Escola do PCD
				3) Local de Trabalho		
				*/				
				if(isset($_POST['pcd_responsavel'])) {  					
					$pcd_responsavel = $_POST['pcd_responsavel'];
					$nome_pdc = $_POST['nome_pcd'];
					$dfciencia = "";
					$escola_pcd = "";
					$trabalho_pcd = "";
				} else {  
					$escola_pcd =  $_POST['escola_pcd'];
					$trabalho_pcd =  $_POST['trabalho_pcd'];
					$dfciencia = $_POST['deficiencia'];
				}	
				// rotina inclusão endereço				
				// Cria conexão
				
					$conn = new mysqli($servername, $username, $password, $database);
					// Verifica conexão
					if ($conn->connect_error) {
						die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
					}
					//carrega a variável pcd_deficiência a partir de pcd_responsável.
					$pcd_deficiencia = 0;
					//if ($dfciencia != "") { 
					//	$pcd_deficiencia = 1;  
					//}
					$status = 1; //marca o sócio na inclusão como ativo, default!
					$realiza_trab_voluntario = "sim";

					$criado_changed = $data;
				try {
					// Iniciar uma transação
					$conn->begin_transaction();

					// Faz INSERT na Base de Dados
					if ($_FILES['imagem']['size'] == 0) { // Não recebeu uma imagem binária
							$sql = "INSERT INTO socios (fullname, cpf, celular, email, dt_nasc, profession, 
											pcd_deficiencia, deficiencias, parentesco_responsavel, status, 
											sexo_genero, escola_pcd, local_trabalho_pcd,
											realiza_trab_voluntario, criado_changed, imagem) 
									VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";					
							$stmt = $conn->prepare($sql);				
							$stmt->bind_param("ssssssisssssssss", $fullname, $cpf, $celular, $email, $dt_nasc, $profession,
											$pcd_deficiencia, $pcd_responsavel, $status, $sexo_genero, $dfciencia, $escola_pcd, $trabalho_pcd,
											$realiza_trab_voluntario, $data, $imagem);
							$stmt->execute();


							// Obter o ID do sócio inserido
							$socio_id = $conn->insert_id;

							echo " O número do Associado é: " . $socio_id;

							// Inserir o endereço do sócio na tabela endereco_socios
							$sql2 = "INSERT INTO addresses (logradouro, numero, complemento, bairro, cidade, estado, phones, socios_id_socio) 
								VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

							$stmt = $conn->prepare($sql2);
							$stmt->execute([$socio_id, $logradouro, $num_casa, $complemento, $bairro, $cidade, $uf, $celular]);
				
							// Confirmar a transação
							$conn->commit();
					} else {
						//implementar lógica com imagem (não fiz ainda, mas seria só trocar o null ali no if)
					}

		
					echo "<p>&nbsp;Registro sócio e endereço inseridos com sucesso!</p>";
				} catch (Exception $e) {
					// Reverter a transação em caso de erro
					$conn->rollBack();
					echo "<p style='text-align:center'>Erro executando inserção: " . $e->getMessage() . "</p>";
				}
	
				// Fechar a conexão
				$conn->close();
				
				/*					
				if ($_FILES['imagem']['size'] == 0) { // Não recebeu uma imagem binária
					$sql = "INSERT INTO socios (fullname, cpf, celular, email, dt_nasc, profission, 
												pcd_deficiencia, parentesco_responsavel, status, 
												sexo_genero, deficiencia, escola_pcd, trabalho_pcd, 
												realiza_trab_voluntario, criado_changed, imagem) 
										VALUES ('$fullname', '$cpf', '$celular', '$email', '$dt_nasc', '$profession', 
												$pcd_deficiencia, '$pcd_responsavel', $status, 
												'$sexo_genero', '$dfciencia', '$escola_pcd', '$trabalho_pcd', 
												'$realiza_trab_voluntario', '$data', NULL);";		
				} else {                              //TODO Recebeu uma imagem binária (preciso finalizar ess query 10/01/2024, igual e de cima.)
					$imagem = addslashes(file_get_contents($_FILES['Imagem']['tmp_name'])); // Prepara para salvar em BD
					$sql = "INSERT INTO socio (Nome, CRM, Dt_Nasc, ID_Espec, Foto) VALUES ('$fullname','$cpf','$dt_nasc', '$pcd_deficiencia','$imagem')";
				}
				
				
				<div class='w3-responsive w3-card-4'>
					<div class="w3-container w3-theme">
						<h2>Inclusão de Novo Associado</h2>
					</div>
					<?php
					if ($result = $conn->query($sql)) {
						echo "<p>&nbsp;Registro sócio com sucesso ! </p>";
					} else {
						echo "<p style='text-align:center'>Erro executando INSERT1: " . $conn->connect_error . "</p>";
					}					

					//consulta código do sócio para inserir o address
					$sql_consulta = "SELECT id FROM socios WHERE fullname = '$fullname';";
					$resulta_consulta_cod = $conn->query($sql_consulta);
									
					$tmp = $resulta_consulta_cod->fetch_assoc();
					$cod_socio = $tmp["id"];
					echo $cod_socio;

					//inserindo o endereço 			
					$sql = "INSERT INTO addresses (logradouro, numero, complemento, bairro, cidade, estado, phones, socios_id_socio) 
										VALUES ('$logradouro', $num_casa, '$complemento', '$bairro', '$cidade', '$uf', '$celular', $cod_socio)"; //FALTA O Cep

					if ($result = $conn->query($sql)) {
						echo "<p>&nbsp;Registro sócio address com sucesso ! </p>";
					} else {
						echo "<p style='text-align:center'>Erro executando INSERT2_address: " . $conn->connect_error . "</p>";
					}

					echo "</div>";
					$conn->close();  //Encerra conexao com o BD
					*/	
				
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