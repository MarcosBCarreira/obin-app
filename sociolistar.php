<?php
require 'geral/menu.php';
require 'bd/conectaBD.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Observatório da Inclusão - APP</title>
    <link rel="icon" type="image/png" href="imagens/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/customize.css">
</head>
<body onload="w3_show_nav('menuMedico')">
<!-- Inclui MENU.PHP - desloquei o código PHP para a primeira linha deste arquivo pq dava problema no heard do menu.php, qdo chamado na aqui. -->

    <!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->

    <!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
    <div class="w3-main w3-container" style="margin-left:270px;margin-top:130px;">
        <div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
            <p class="w3-large">
            <p>
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
                <div class="w3-container w3-theme">
                    <h2>Listagem de Associados</h2>
                </div>
                <!-- Acesso ao BD-->
                <?php
                // Cria conexão
                $conn = new mysqli($servername, $username, $password, $database);

                // Verifica conexão 
                if ($conn->connect_error) {
					die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
				}

                // Faz Select na Base de Dados  09/01- tenho de arrumar essa query.
                $sql = "SELECT id, cpf, fullname, celular, deficiencias, dt_nasc, imagem
                        FROM socios ORDER BY fullname";
                                
                $result = $conn->query($sql);
                echo "<div class='w3-responsive w3-card-4'>";
                if ($result->num_rows >0) {
                    echo "<table class='w3-table-all'>";
                    echo "	<tr>";
                    echo "	  <th width='5%'>Código</th>";
                    echo "	  <th width='12%'>CPF</th>";
                    echo "	  <th width='20%'>Nome</th>";
                    echo "	  <th width='16%'>Celular</th>";
                    echo "	  <th width='10%'>Deficiência</th>";
                    echo "	  <th width='10%'>Nascimento</th>";
                    echo "	  <th width='7%'>Idade</th>";
                    echo "	  <th width='10%'> </th>";
                    echo "	  <th width='5%'> </th>";
                    echo "	  <th width='5%'> </th>";
                    echo "	</tr>";
                    // Apresenta cada linha da tabela
                    while ($row = $result->fetch_assoc()) {
                        $data = $row['dt_nasc'];
                        list($ano, $mes, $dia) = explode('-', $data);
                        $nova_data = $dia . '/' . $mes . '/' . $ano;
                        // data atual
                        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                        // Descobre a unix timestamp da data de nascimento do fulano
                        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
                        // cálculo
                        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                        $cod = $row["id"];
                        echo "<tr>";
                        echo "<td>";
                        echo $cod;
                        echo "</td><td>";
                        echo $row["cpf"];
                        echo "</td><td>";
                        echo $row["fullname"];
                        echo "</td><td>";
                        echo $row["celular"];
                        echo "</td><td>";
                        echo $row["deficiencias"];
                        echo "</td><td>";
                        echo $nova_data;
                        echo "</td><td>";
                        echo $idade;
                        echo "</td>";
                        //=================
                        if ($row['imagem']) { ?>
                            <td>
                                <img id="imagemSelecionada" class="w3-circle w3-margin-top" src="data:image/png;base64,<?= base64_encode($row['imagem']) ?>" />
                            </td>
                            <td>
                            <?php
                        } else {
                            ?>
                            <td>
                                <img id="imagemSelecionada" class="w3-circle w3-margin-top" src="imagens/pessoa.jpg" />
                            </td>
                            <td>
                            <?php
                        }




                        //==============






                        //Atualizar e Excluir registro de médicos
                            ?>
                            <td>
                                <a href='socioAtualizar.php?id=<?php echo $cod; ?>'><img src='imagens/Edit.png' title='Editar Associado' width='32'></a>
                            </td>
                            <td>
                                <a href='socioExcluir.php?id=<?php echo $cod; ?>'><img src='imagens/Delete.png' title='Excluir Associado' width='32'></a>
                            </td>
                            </tr>
                    <?php
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p style='text-align:center'>Erro executando SELECT: " . $conn->connect_error . "</p>";
                }
                $conn->close();
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