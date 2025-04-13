-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Abr-2025 às 17:01
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_online`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT 1,
  `data_adicionado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Calças'),
(3, 'ssss');

-- --------------------------------------------------------

--
-- Estrutura da tabela `depoimentos`
--

CREATE TABLE `depoimentos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `depoimento` text DEFAULT NULL,
  `data_depoimento` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `depoimentos`
--

INSERT INTO `depoimentos` (`id`, `usuario_id`, `depoimento`, `data_depoimento`) VALUES
(2, 1, '222222222', '2025-04-13 09:07:09'),
(3, 1, 'Jglgfsfbsdfhjgsfesbfslfgdfldfsfisfse\r\nff44grjºreºtvºterihiwyihºaeiyraºirºayeiºeyitºihufgdfbdflgfere', '2025-04-13 10:11:41'),
(4, 1, 'Jglgfsfbsdfhjgsfesbfslfgdfldfsfisfse\r\nff44grjºreºtvºterihiwyihºaeiyraºirºayeiºeyitºihufgdfbdflgfere\r\n,asggha,sdgad', '2025-04-13 10:13:39'),
(5, 1, 'eetetwetwetwet<<<<a', '2025-04-13 10:13:50'),
(6, 2, 'ssdsss', '2025-04-13 11:38:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `id_pedido`, `id_produto`, `quantidade`, `preco_unitario`) VALUES
(1, 1, 3, 1, 34332.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_venda`
--

CREATE TABLE `itens_venda` (
  `id_item` int(11) NOT NULL,
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens_venda`
--

INSERT INTO `itens_venda` (`id_item`, `id_venda`, `id_produto`, `quantidade`, `preco_unitario`) VALUES
(5, 5, 3, 222, 34332.00),
(6, 6, 2, 5, 2345.00),
(7, 6, 2, 2, 2345.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `logo` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `marcas`
--

INSERT INTO `marcas` (`id`, `nome`, `descricao`, `logo`, `data_cadastro`) VALUES
(3, 'wdd', 'ww', '67fb955a2a065.jpg', '2025-04-13 10:43:38'),
(4, 'www', 'dddd', '67fb9570338b2.jpg', '2025-04-13 10:44:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_pedido` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `data_pedido`, `total`, `status`) VALUES
(1, 2, '2025-04-13 15:28:20', 34332.00, 'pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `destaque` tinyint(1) DEFAULT 0,
  `data_adicao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `categoria_id`, `imagem`, `destaque`, `data_adicao`) VALUES
(2, 'Bol', 'ssss', 2345.00, 1, '67fb988a8222c.jpg', 1, '2025-04-13 10:57:14'),
(3, 'dssd', 'fffd', 34332.00, 1, '', 1, '2025-04-13 13:04:52');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('cliente','admin') NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `data_cadastro`) VALUES
(1, 'Esmael Adriano', 'esma@gmail.com', '$2y$10$b/wFLskftp9D48bwwTlAfunlesB03.Pg3lSjA4qqtHldyCO/KBohW', 'admin', '2025-04-13 07:58:03'),
(2, 'ALice', 'admin@gmail.com', '$2y$10$tqvyz5uR8FW9KqSmt1TTW.ywFdYbO143jLR7E3bS9dlrAN7L7yi9q', 'cliente', '2025-04-13 10:15:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `data_venda` datetime DEFAULT current_timestamp(),
  `tipo_pagamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `nome_cliente`, `data_venda`, `tipo_pagamento`) VALUES
(5, 'dd', '2025-04-13 14:09:42', 'Dinheiro'),
(6, 'hh', '2025-04-13 14:13:44', 'Dinheiro');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `depoimentos`
--
ALTER TABLE `depoimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_venda` (`id_venda`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `depoimentos`
--
ALTER TABLE `depoimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `carrinho_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `depoimentos`
--
ALTER TABLE `depoimentos`
  ADD CONSTRAINT `depoimentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`),
  ADD CONSTRAINT `itens_venda_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
