-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Maio-2025 às 21:13
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
(5, 'sapato'),
(6, 'saia'),
(7, 'beleza'),
(8, 'Vestido'),
(9, 'BOLSA');

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
(3, 8, 'essa  sati foi muito bom gostei tanto de fazer as minhas compras foi bem recebida', '2025-04-13 10:11:41'),
(5, 1, 'gostei de fazer parte desse sati  comprei coisas e me trataram muito bem', '2025-04-13 10:13:50'),
(6, 2, 'foi muito satisfatorio  amei bastante  a forma que fui recebida', '2025-04-13 11:38:10');

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
(5, 3, 42, 1, 3.00),
(6, 4, 43, 11, 1.00),
(7, 4, 43, 14, 1.00);

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
(8, 7, 36, 11, 11.00),
(9, 7, 30, 9, 10.00);

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
(5, 'OPPO', 'Patrocinador', '683274b4eae2d.png', '2025-05-25 01:39:00'),
(7, 'coca', 'patrocin', '683275664335b.png', '2025-05-25 01:41:58'),
(8, 'tr', 'sdf', '683275b8a278a.png', '2025-05-25 01:43:20'),
(9, 'rt', 'zu', '683275d2e8a52.png', '2025-05-25 01:43:46'),
(10, '4567', 'fgh', '683275ed918c4.png', '2025-05-25 01:44:13'),
(11, '45', 'dfg', '6832763247b0e.png', '2025-05-25 01:45:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `nome_cliente` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `localidade` varchar(50) DEFAULT NULL,
  `pagamento` varchar(50) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `data_pedido` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `total`, `nome_cliente`, `telefone`, `endereco`, `localidade`, `pagamento`, `observacoes`, `data_pedido`) VALUES
(1, 2, 4710.00, 'Esmael Adriano adriano', '940923748', 'Angola-Luanda', 'Luanda', 'transferencia', 'zzzzzz', '2025-05-24 11:06:45'),
(2, 1, 10.00, 'ameliajustino Justino', '921015416', 'ssss', 'Benguela', 'mobile', 'ggg', '2025-05-29 17:38:42'),
(3, 2, 3.00, 'A', '943787590', 'ESTALAGEM', 'Benguela', 'transferencia', '', '2025-05-30 00:02:38'),
(4, 1, 25.00, 'ameliajustino Justino', '943787590', 'ssss', 'Benguela', 'mobile', 'jjjjjjjjjjj', '2025-05-30 15:36:56');

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
(28, 'lllll', 'oooo', 2500.00, 5, '6831cd680b0e8.jpg', 1, '2025-05-24 13:45:12'),
(30, 'BOTA DE  NAPA ALTO', 'Cor: Preto \r\n Marca:ZARA', 10.00, 5, '6831db644c014.jpg', 0, '2025-05-24 14:44:52'),
(36, 'BOLSA', 'COR: LARANJA \r\nMARCA : JANEL', 11.00, 9, '68320d6c24677.jpg', 0, '2025-05-24 18:18:20'),
(39, 'SAPATO ALTO ELEGANTE', 'COR:ROSA MARCA:MARIA LICE', 5.00, 5, '6832537be3636.jpg', 0, '2025-05-24 23:17:15'),
(40, 'PASTA', 'COR:LARANJA MARCA:CHARNEL', 7.00, 9, '68325477dc4d7.jpg', 0, '2025-05-24 23:21:27'),
(41, 'GLOSSE', 'COR: LILAS E ROSA MARCA: NAKED', 7.00, 7, '6832577a98088.jpg', 0, '2025-05-24 23:34:18'),
(42, 'MALETA DE PINCEL', 'COR:PRETO MARCA:MAC', 3.00, 7, '683259abc5b3d.jpg', 0, '2025-05-24 23:43:39'),
(43, 'DELINHADORE', 'COR:PRETO MARCA:MAC', 1.00, 7, '68325a3b28896.jpg', 0, '2025-05-24 23:46:03'),
(44, 'BATOM', 'COR : ROSA MARCA: MAC', 2.00, 7, '68325af48445c.jpg', 0, '2025-05-24 23:49:08'),
(48, 'VESTIDO', 'COR :PRETO MARCA:MARIA LICE', 6.00, 8, '6838e288a7dd3.jpeg', 0, '2025-05-29 22:41:12'),
(49, 'VESTIDO', 'COR: ROSA MARCA: MEYDE', 6.00, 8, '6838e3800aff8.jpeg', 0, '2025-05-29 22:45:20'),
(50, 'VESTIDO', 'COR: LARANJA  MARCA :AL', 5.00, 8, '6838e3eb5a03f.jpeg', 0, '2025-05-29 22:47:07'),
(51, 'VESTIDO', 'COR:ROSA MARCA: ZARA', 5.00, 8, '6838e46964e31.jpeg', 0, '2025-05-29 22:49:13'),
(52, 'VESTIDO', 'COR: AZUL MARCA: MARIA LICE', 5.00, 8, '6838e66403e30.jpeg', 0, '2025-05-29 22:57:40'),
(53, 'VESTIDO', 'COR:VERMELHO MARCA: MARIA LICE', 4.00, 8, '6838e6c77aa99.jpeg', 0, '2025-05-29 22:59:19'),
(55, 'VESTIDO', 'COR: BRANCA MARCA: MARIA LICE', 7.00, 8, '6838e769c4257.jpeg', 0, '2025-05-29 23:02:01'),
(56, 'VESTIDO', 'COR: CASTAMHO MARCA: MARIA LICE', 8.00, 8, '6838e7a98cfe7.jpeg', 0, '2025-05-29 23:03:05'),
(57, 'VESTIDO', 'COR: BANCA E PRETO MARCA : MARIA LICE', 8.00, 8, '6838e7f212f3a.jpeg', 0, '2025-05-29 23:04:18'),
(58, 'VESTIDO', 'COR: VERDE MARCA A: ZARA', 8.00, 8, '6838e827141fb.jpeg', 0, '2025-05-29 23:05:11'),
(59, 'VESTIDO', 'COR: PRETO MARGA : DEL', 4.00, 8, '6838e892cbf19.jpeg', 0, '2025-05-29 23:06:58'),
(60, 'VESTIDO', 'COR: ROSA E BRANCA MARCA:', 4.00, 8, '6838e913ab910.jpeg', 0, '2025-05-29 23:09:07'),
(61, 'VESTIDO', 'COR: CASTANHO MARCA:ZARA', 9.00, 8, '6838e99a3ae63.jpeg', 0, '2025-05-29 23:11:22'),
(62, 'VESTIDO', 'COR: PRETO MARCA: ZARA', 9.00, 8, '6838e9ea2308b.jpeg', 0, '2025-05-29 23:12:42'),
(63, 'VESTIDO', 'COR: VERMELHO MARCA: ZARA', 10.00, 8, '6838ea39a0cf2.jpeg', 0, '2025-05-29 23:14:01'),
(64, 'BOLSA', 'COR: PRETO MARCA: ZARA', 6.00, 9, '6838eb35276a6.jpg', 0, '2025-05-29 23:18:13'),
(65, 'BOLSA', 'COR: ROSA MARCA: ZARA', 6.00, 9, '6838eb8b7834a.jpg', 0, '2025-05-29 23:19:39'),
(66, 'BOLSA', 'COR: CASTANHO MARCA ZARA', 7.00, 9, '6838ebba0b1f6.jpg', 0, '2025-05-29 23:20:26'),
(67, 'BOLSA', 'COR: LARANJA MARCA : ZARA', 7.00, 9, '6838ec15e8cbb.jpg', 0, '2025-05-29 23:21:57'),
(68, 'BOLSA', 'COR:  PRETO MARCA : ZARA', 12.00, 9, '6838ec8ebad6c.jpg', 0, '2025-05-29 23:23:58'),
(69, 'Beleza', 'COR : 1 MARCA :MAC', 5.00, 7, '6838ed498215c.jpg', 0, '2025-05-29 23:27:05'),
(70, 'VESTIDO', 'COR: CASTANHO MARCA: MARIA LICE', 12.00, 8, '6838edf4e5614.jpeg', 0, '2025-05-29 23:29:56'),
(91, 'BOLSA', 'COR: LARANJA MARCA:  DEL', 7.00, 9, '6839b43b95b78.jpg', 0, '2025-05-30 13:35:55'),
(92, 'BOLSA', 'COR: VERDE MARCA: ZARA', 4.00, 9, '6839b4afd38f0.jpg', 0, '2025-05-30 13:37:51'),
(93, 'BOLSA', 'COR: SINZA MARCA: ZARA', 12.00, 9, '6839b50a91c11.jpg', 0, '2025-05-30 13:39:22'),
(94, 'BOLSA', 'COR: SINZA MARCA: ADIDAS', 12.00, 9, '6839b5923f86c.jpg', 0, '2025-05-30 13:41:38'),
(95, 'BOLSA', 'COR: DORADA MARCA : ZARA', 6.00, 9, '6839b611d3e1d.jpg', 0, '2025-05-30 13:43:45'),
(96, 'BOLSA', 'COR: AMARELO MARCA: ZARA', 9.00, 9, '6839b9e4931bb.jpg', 0, '2025-05-30 14:00:04'),
(97, 'BOLSA', 'COR: PRETO MARCA: ZARA', 3.00, 9, '6839ba5f23772.jpg', 0, '2025-05-30 14:02:07'),
(98, 'SAPATOS', 'COR: VERMALHO MARCA: ZARA', 12.00, 5, '6839bbfb8c0ce.png', 0, '2025-05-30 14:08:59'),
(99, 'BOLSA', 'COR: AZUL BEBE MARCA : ZARA', 6.00, 9, '6839be97cb367.jpg', 0, '2025-05-30 14:20:07'),
(100, 'BOLSA', 'COR: CASTANHO MARCA: GUGI', 6.00, 9, '6839bf213826c.jpg', 0, '2025-05-30 14:22:25'),
(101, 'BOLSA', 'COR: AZUL BEBE MARCA: ZARA', 7.00, 9, '6839bf5f1ad1c.jpg', 0, '2025-05-30 14:23:27'),
(102, 'hh', 'hhhh', 5655.00, 7, '6839cf9a3ef8c.jpeg', 1, '2025-05-30 15:32:42'),
(103, 'sapado', 'eee', 200000.00, 5, '6839e75fb2d71.jpg', 1, '2025-05-30 17:14:07'),
(104, 'vestido', 'jjjj', 3000.00, 8, '6839e8228d1ea.jpeg', 1, '2025-05-30 17:17:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_baner`
--

CREATE TABLE `produtos_baner` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `data_adicao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos_baner`
--

INSERT INTO `produtos_baner` (`id`, `nome`, `descricao`, `preco`, `categoria_id`, `imagem`, `data_adicao`) VALUES
(1, 'VESTIDOS EGANTE', 'sss', 3.00, 6, '68389fa724086.jpeg', '2025-05-29 17:55:51'),
(2, 'VESTIDOS EGANTE', 'aaaaaaaaa', 3.00, 9, '6838a231302eb.jfif', '2025-05-29 18:06:41'),
(3, 'VESTIDOS EGANTE', '', 3.00, 7, '6838e2f40f88c.jpeg', '2025-05-29 22:43:00'),
(4, 'VESTIDOS EGANTE', 'rt', 3.00, 7, '68399b5088646.jpg', '2025-05-30 11:49:36'),
(5, 'VESTIDOS EGANTE', 'rt', 3.00, 7, '68399cda9a2a7.jpg', '2025-05-30 11:56:10'),
(6, 'VESTIDOS EGANTE', '45TZ', 3.00, 6, '6839c031758e1.jpeg', '2025-05-30 14:26:57'),
(7, 'VESTIDOS EGANTE', 'RTZ', 3.00, 7, '6839c08f032ea.jpg', '2025-05-30 14:28:31'),
(8, 'VESTIDOS EGANTE', '', 3.00, 8, '6839e7b3ef02c.jpeg', '2025-05-30 17:15:31');

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
(2, 'ALice', 'admin@gmail.com', '$2y$10$tqvyz5uR8FW9KqSmt1TTW.ywFdYbO143jLR7E3bS9dlrAN7L7yi9q', 'cliente', '2025-04-13 10:15:16'),
(7, 'aaa', 'admain@gmail.com', '$2y$10$XdY/AbeHbEP58rlnKRXZLusF4tPWwrG/HiXXdciVTQ4h8vyO7E6aO', 'cliente', '2025-04-13 22:53:27'),
(8, 'Amelia justino', 'meli@gmail.com', '$2y$10$gKEr0zQjJHTN3aP3HWezjORFvpHmS6H1Ogu16ib4R6GVO1w/Y2L9a', 'cliente', '2025-05-24 13:47:56'),
(9, 'leonoraleo', 'Leopoldinaleonora@gmail.com', '$2y$10$BlQlG7agZsHd..Mgxs.98ereEZI2W1HRobiWpyOi.H9jHoC.IdFCu', 'cliente', '2025-05-30 17:19:19'),
(10, 'mariaa', 'maria@gmail.com', '$2y$10$CkPSYYKme87wllyNEUfSX.gYaH2sb4o.GWKRZCwG35ayQXGHhEOKK', 'cliente', '2025-05-30 17:26:19'),
(11, 'janeth', 'a@f', '$2y$10$qozkFx9H5LQHHt1j7vXl7.EQcGUoppA.2tABZ.C7iOLwMj9rRLR5.', 'cliente', '2025-05-30 17:27:21');

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
(7, 'sss', '2025-05-30 15:40:20', 'Dinheiro');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrinho_ibfk_1` (`id_usuario`),
  ADD KEY `fk_produto_carrinho` (`id_produto`);

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
  ADD KEY `id_idcarri` (`id_produto`);

--
-- Índices para tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `fk_produto_venda` (`id_produto`),
  ADD KEY `fk_produto_vendaas` (`id_venda`);

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
  ADD KEY `fk_produto_categoria` (`categoria_id`);

--
-- Índices para tabela `produtos_baner`
--
ALTER TABLE `produtos_baner`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `depoimentos`
--
ALTER TABLE `depoimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de tabela `produtos_baner`
--
ALTER TABLE `produtos_baner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrinho_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_produto_carrinho` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `depoimentos`
--
ALTER TABLE `depoimentos`
  ADD CONSTRAINT `depoimentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `id_idcarri` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD CONSTRAINT `fk_produto_venda` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_produto_vendaas` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Limitadores para a tabela `produtos_baner`
--
ALTER TABLE `produtos_baner`
  ADD CONSTRAINT `produtos_baner_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
