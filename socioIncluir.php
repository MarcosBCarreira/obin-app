<!DOCTYPE html>
<!-------------------------------------------------------------------------------
    Desenvolvimento Web
    PUCPR
    Profa. Cristina V. P. B. Souza
    Agosto/2022
---------------------------------------------------------------------------------->
<!-- medIncluir.php -->
<html>
<head>

	<title>Observatório da Inclusão</title>
	<link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
</head>
<body onload="w3_show_nav('menuMedico')">
	<!-- Inclui MENU.PHP  -->
	<?php require 'geral/menu.php'; ?>
	<?php require 'bd/conectaBD.php'; ?>

	<!-- Conteúdo Principal: deslocado paa direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container" style="margin-left:270px;margin-top:130px;">

		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
			<!-- h1 class="w3-xxlarge">Contratação de Médico</h1 -->
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
				// Cria conexão
				$conn = new mysqli($servername, $username, $password, $database);

				// Verifica conexão 
				if ($conn->connect_error) {
					die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
				}

				// Obtém as Especialidades Médicas na Base de Dados para um combo box
				$sqlG = "SELECT id, nome_def FROM deficiencias";
				$result = $conn->query($sqlG);
				$optionsDeficiencia = array();

				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						array_push($optionsDeficiencia, "\t\t\t<option value='" . $row["id"] . "'>" . $row["nome_def"] . "</option>\n");
					}
				} else {
					echo "Erro executando SELECT: " . $conn->connect_error;
				}
                // (script para trazer para o formulário as PCD) -- //preciso verificar como isso vai ficar no banco!
                $sqlG2 = "SELECT id, fullname FROM socios WHERE pcd_deficiencia=1;";
				$result2 = $conn->query($sqlG2);
				$optionsPCD = array();

				if ($result2->num_rows > 0) {
					while ($row = $result2->fetch_assoc()) {
						array_push($optionsPCD, "\t\t\t<option value='" . $row["id"] . "'>" . $row["fullname"] . "</option>\n");
					}
				} else {
					echo "Erro executando SELECT: " . $conn->connect_error;
				}
                
				$conn->close();
				?>
				<div class="w3-responsive w3-card-4">
					<div class="w3-container w3-theme">
						<h2>Cadastro/Alteração Associado(a)s Observatório</h2>
					</div>
					
                    <form class="w3-container" action="socioIncluir_exe.php" method="post" enctype="multipart/form-data">
                        <table class='w3-table-all'>
                        <tr>
                        <td style="width:50%;">                                                  
                            <table>                               
                                <tr>                   
                                    <td style="width: 50%;">
                                        <label class="w3-text-IE"><b>Nome</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" name="fullname" id="fullname" type="text" pattern="[a-zA-Z\u00C0-\u00FF ]{10,100}$" title="Nome entre 10 e 100 letras." required>                                    
                                    </td>
                                    <td style="width: 25%;">
                                        <label class="w3-text-IE"><b>CPF</b></label>
                                        <input class="w3-input w3-border w3-light-grey " name="cpf" id="cpf" type="text" maxlength="15" placeholder="CPF XXX.XXX.XXX-XX" title="CPF" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}">                                    
                                    </td>
                                    <td style="width: 25%;">
                                            <label class="w3-text-IE"><b>Data de Nascimento</b></label>
                                            <input class="w3-input w3-border w3-light-grey" name="dt_nasc" type="date" placeholder="dd/mm/aaaa" title="dd/mm/aaaa">
                                    </td>
                                </tr>                        
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 30%;">
                                    
                                    <label class="w3-text-IE"><b>Rua/Av</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" name="logradouro" type="text"  title="Nome da Rua 10 e 100 letras." required>
                                    
                                    </td>
                                    <td style="width: 7%;">                                    
                                            <label class="w3-text-IE"><b>Nº</b>*</label>
                                            <input class="w3-input w3-border w3-light-grey" name="num_casa" type="text"  title="numero" required>                                    
                                    </td>
                                    <td style="width: 10%;">
                                        
                                            <label class="w3-text-IE"><b>Complemento</b>*</label>
                                            <input class="w3-input w3-border w3-light-grey" name="complemento" type="text"  title="Complemento">
                                    
                                    </td>
                                    <td style="width: 16%;">
                                    
                                            <label class="w3-text-IE"><b>Bairro</b>*</label>
                                            <input class="w3-input w3-border w3-light-grey" name="bairro" type="text"  title="Bairro">
                                    
                                    </td>
                                    <td style="width: 22%;">
                                    
                                            <label class="w3-text-IE"><b>Cidade</b>*</label>
                                            <input class="w3-input w3-border w3-light-grey" name="cidade" type="text"  title="Bairro" required>
                                    
                                    </td>
                                    <td style="width: 5%;">
                                        
                                            <label class="w3-text-IE"><b>UF</b>*</label>
                                            <input class="w3-input w3-border w3-light-grey" name="UF" type="text"  title="Bairro" required>
                                    
                                    </td>
                                </tr>
                            </table>
                            <table>
                            <tr>
                                <td style="width: 20%;">
                                   
                                    <label class="w3-text-IE"><b>Celular</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" name="celular" type="text"  title="Nome da Rua 10 e 100 letras." required>
                                </td>
                                <td style="width: 30%">
                                        <label class="w3-text-IE"><b>Profissão</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" name="profession" type="text"  title="numero" required>                                    
                                </td>
                                <td style="width: 40%px;">                                    
                                        <label class="w3-text-IE"><b>E-mail</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" name="email" type="text"  title="Complemento" required>                        
                                </td>
                                <td style="width: 10%;">
                                        <label class="w3-text-IE"><b>Sexo/Gênero</b>*<br></label>                          
                                        <select id="genero" name="sexo_genero">                            
                                        <option value="masculino">Masculino</option>
                                        <option value="feminino">Feminino</option>
                                        <option value="outro">Outro</option>                            
                                        </select>                                  
                                </td>
                            </tr>  
                            
                            <tr>                          
                                <td style="width: 25%;">                        
                                    <label class="w3-text-IE"><b>É pessoa com deficiência ou responsável por uma?</b>*</label><br>                     
                                    <select id="pcd_responsavel" name="pcd_responsavel">
                                        <option value=""></option> 
                                        <option value="pcd">PCD</option>                            
                                        <option value="mae">Mãe</option>
                                        <option value="pai">Pai</option>
                                        <option value="irmão">Irmão(ã)</option>
                                        <option value="tio(a)">Tio(a)</option>                                                                                
                                        <option value="outro">Outro</option>
                                    </select>                     
                                </td>
                                <td style="width: 35%;">                                        
                                        <label class="w3-text-IE"><b>Nome da Pessoa com deficiência</b></label>                                        
                                        <select name="nome_pcd" id="nome_pdc" class="w3-input w3-border w3-light-grey">
                                        <option value=""></option>
                                        <?php
                                        foreach ($optionsPCD as $key => $value) {
                                            echo $value;
                                        }
                                        ?>
                                    </select> 
                                </td>     
                                <td style="width: 40%;">                                  
                                    <label class="w3-text-IE"><b>Deficiência</b>*</label>
                                    <select name="deficiencia" id="deficiencia" class="w3-input w3-border w3-light-grey">
                                        <option value=""></option>
                                        <?php
                                        foreach ($optionsDeficiencia as $key => $value) {
                                            echo $value;
                                        }
                                        ?>
                                    </select>
                                </td>                                                                
                            </tr>

                            <tr>                            
                                <td style="width: 30%">
                                    
                                        <label class="w3-text-IE"><b>Nome da Escola da PCD</b></label>
                                        <input class="w3-input w3-border w3-light-grey" name="escola_pcd" type="text"  title="numero" >
                                    
                                </td>
                                <td style="width: 30%">
                                    
                                        <label class="w3-text-IE"><b>Local de trabalho da PCD</b></label>
                                        <input class="w3-input w3-border w3-light-grey" name="trabalho_pcd" type="text"  title="numero" >
                                    
                                </td>
                            </tr>


                        </table>                
                                </td>                             
                                    <td style width="20%">
                                    <p style="text-align:center"><label class="w3-text-IE"><b>Minha Imagem para Identificação: </b></label></p>
                                    <p style="text-align:center"><img id="imagemSelecionada" src="imagens/pessoa.jpg" /></p>
                                    <p style="text-align:center"><label class="w3-btn w3-theme">Selecione uma Imagem</label>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="16777215" />
                                            <input type="file" id="imagem" name="imagem" accept="imagem/*" onchange="validaImagem(this);"> 
                                    </p>
                                </td>                             


                            </tr>
                                <tr>
                                    <td colspan="2" style="text-align:center">
                                    <p>
                                    <input type="submit" value="Salvar" class="w3-btn w3-theme">
                                    <input type="button" value="Cancelar" class="w3-btn w3-theme" onclick="window.location.href='medListar.php'">
                                    </p>
                                    </td>
                                </tr>
                            </table>
                    </form>
				<br>
			</div>
		</div>
		</p>
	</div>

		<?php require 'geral/sobre.php'; ?>
		<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>
</body>
</html>