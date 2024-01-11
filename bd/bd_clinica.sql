SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- VERSÃO DIA 09/01/2023 16:00
CREATE TABLE `deficiencias` (
  `id` int(11) NOT NULL,
  `nome_def` varchar(45) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `Associado_status`
--
INSERT INTO `deficiencias` (`id`, `nome_def`, `descricao`) VALUES
(1, 'Síndrom de Down', 'Trissomia do Cromossomo 21'),
(2, 'T. Espectro Autista', 'Pode apresentar varidos graus de suporte.'),
(3, 'Síndrome de Williams', 'Condição genética que....');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medico`
--

CREATE TABLE `socios` (
  `ID_Pessoa` int(11) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `ID_Associado_status` int(11) NOT NULL,
  `Dt_Nasc` date DEFAULT NULL,
  `Foto` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERINDO DADOS EM SÓCIOS 09/01/2024
INSERT INTO `socios` (`id`, `fullname`, `cpf`, `pcd_deficiencia`, `sexo_genero` ) VALUES
(1, 'Felipe Santos Carreira', '200.067.758-45', 1, 'M')

--
-- Extraindo dados da tabela `medico`

-- Estrutura da tabela `usuario`

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Celular` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Login` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `Senha` varchar(40) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nome`, `Celular`, `Login`, `Senha`) VALUES
(1, 'Marcos B. Carreira', '(41)9974-2598', 'marcos.carreira', '70b4269b412a8af42b1f7b0d26eceff2');

--
-- Índices para tabela `medico`

  ALTER TABLE `Pessoas`
  ADD PRIMARY KEY (`ID_Pessoa`),
  ADD UNIQUE KEY `UN_CPF` (`CPF`),
  ADD KEY `ID_Associado_status` (`ID_Associado_status`);
--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `especialidade`
--
ALTER TABLE `Associado_status`
  MODIFY `ID_Associado_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `medico`
--
ALTER TABLE `Pessoas`
  MODIFY `ID_Associado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `medico`
--

SELECT ID_Pessoa, CPF, Nome, ID_Associado_status
FROM pessoas AS P INNER JOIN associado_status AS A ON (P.ID_Associado_status = A.ID_Associado_status) ORDER BY P.Nome; 

ALTER TABLE `Pessoas`
  ADD CONSTRAINT `ID_Associado_status` FOREIGN KEY (`ID_Associado_status`) REFERENCES `Associado_status` (`ID_Associado_status`); 

