-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 28 2022 г., 15:38
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yii2basic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `order_id` int NOT NULL,
  `products_count` int NOT NULL,
  `cost` float NOT NULL,
  `user_id` int NOT NULL,
  `status` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`order_id`, `products_count`, `cost`, `user_id`, `status`, `date`) VALUES
(74, 1, 554, 1, 'Ожидание принятия заказа', '2022-04-28 15:17:21');

-- --------------------------------------------------------

--
-- Структура таблицы `order_products`
--

CREATE TABLE `order_products` (
  `product_id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `length` varchar(255) NOT NULL,
  `patchcord` int NOT NULL,
  `cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_products`
--

INSERT INTO `order_products` (`product_id`, `order_id`, `product_name`, `price`, `length`, `patchcord`, `cost`) VALUES
(54, 74, 'Кабель 2', 3, '178', 1, 554);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `price`) VALUES
(1, 'Кабель 1', 'Кабель 1 - цена 2 руб за см', 2),
(2, 'Кабель 2', 'Кабель 2 - цена 3 руб за см', 3),
(3, 'Кабель 3', 'Кабель 3 - цена 1.5 руб за см', 1.5),
(4, 'Кабель 4', 'Кабель 4 - стоимость за см 6 руб', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `role` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'user', '123@123.123', '$2y$13$UuCWR6zcbMO4htdY7uPNP.0l3R5kctAK5MVq833s2/JHG.rjMmZO.', 'user'),
(2, 'user', '123@123.12', '$2y$13$c9Vp7dneuvIjnkOT/4RT9uMkemDF5SrFFScUeIqtOdkPwU3R8//Si', 'admin'),
(3, 'userыы', '123@123.1234', '$2y$13$ispUt3Vr9iXBpI7wkeped.LapUondOOx5/sleTZmv3vdS76oe1k1y', 'user'),
(4, 'userыы', '123@123.1236', '$2y$13$KlPwITrXvTjwfgCSHRwXp.AjxUIyzfvSO3QKOtrCA4H4DQzOPjayG', 'user'),
(5, 'user', '123@123.12345', '$2y$13$Xfo4fJ0I.bpa0sF4efY7A.sWxnCHUz4k4PKFbM4Enn5cONlTQKqAe', 'user'),
(6, 'Lexus', '123@123.321', '$2y$13$ISZaP.pncxPA8XrWa.a4PeiGNB9rD57smlXNG4caKyp2IFuHrRwoa', 'user'),
(7, 'admin', 'admin@admin.admin', '$2y$13$R3UaDJlPcpNsNcxW/B6feezX0FXYL/.O3OF1t2H8PsMZtKymu0YPW', 'admin'),
(8, 'user0', '123@123.1111', '$2y$13$svgIc4x5DBJkjKgC0SDiVub3cWYyqdUplu3LEaviltlh.HkQz4Scq', 'user'),
(9, 'Lexus', 'lex@mail.ru', '$2y$13$65iOsWMFC4uDVPm2ZgyAnekTbrTmEIWFM.Gb11AsnLenREyDn5nnq', 'user'),
(10, 'Lexus', 'lex@mail.rus', '$2y$13$RAXZTBB7g5vWqSvmYKUjQOhX8ryzkTPphmKhQdjTOTfQAjZoq535C', 'user'),
(11, 'Lexus', 'lex@mail.rusd', '$2y$13$DNGK6CRATWdt1KCQZEn.aeqpif8f3Ffz0mBk6NaI7BtYxfCbCcnJi', 'user'),
(12, 'Lexus', 'lex@mail.rusdd', '$2y$13$3Z4kxfaLyoCd3nnJ05C6P.cHzFApIbwSCTSPtw1V0.aRlMBu5iMD6', 'user'),
(13, 'Lexus', 'lex@mail.rusdda', '$2y$13$zvZp6WiC1btBuC6yCMNxc.hB1VxJ2f6Ri6db9txDGAz1rX4ev3Lg.', 'user'),
(14, 'Lexus', 'lex@mail.rusddaa', '$2y$13$KzDElleIxJUvKjd1voPrlutBoYNEqVThidiFSJ1yp4SN2cV1CuIve', 'user'),
(15, 'test', 'test@mail.ru', '$2y$13$mB6WLHPRmmT8RDyXUBq1B.vFcMSlRW1uYi384xVXJ4RR9TjBnIS3.', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT для таблицы `order_products`
--
ALTER TABLE `order_products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
