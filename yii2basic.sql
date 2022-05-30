-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 30 2022 г., 10:42
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
(79, 2, 534, 16, 'Принят', '2022-05-29 17:13:33'),
(80, 2, 789, 16, 'Ожидание принятия заказа', '2022-05-29 17:13:50'),
(81, 1, 2070, 16, 'Ожидание принятия заказа', '2022-05-29 17:31:47'),
(82, 1, 422, 16, 'Ожидание принятия заказа', '2022-05-29 17:32:07');

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
(61, 79, 'Кабель 3', 1.5, '178', 0, 267),
(62, 79, 'Кабель 3', 1.5, '178', 0, 267),
(63, 80, 'Кабель 1', 2, '156', 0, 312),
(64, 80, 'Кабель 2', 3, '159', 0, 477),
(65, 81, 'Кабель 4', 6, '345', 0, 2070),
(66, 82, 'Кабель 4', 6, '67', 1, 422);

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
  `fio` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `role` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `fio`, `email`, `password`, `role`) VALUES
(7, 'admin', '', 'admin@admin.admin', '$2y$13$R3UaDJlPcpNsNcxW/B6feezX0FXYL/.O3OF1t2H8PsMZtKymu0YPW', 'admin'),
(16, 'user', 'Бухвин Алексей Дмитриевич', '123@123.123', '$2y$13$C1df45hSG3hqsL1SSyYbnO1lWxTOTMBzEIyO/6v1dpK.tT5kPO82q', 'user'),
(17, 'Lexuss', 'Бухвин Алексей Дмитриевич', '123@123.1234', '$2y$13$ai4HpZtjAYpZWLE7f/oFzuiJI40h3UZmX8WDI1muF1Su2N4eQ3rMG', 'user');

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
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT для таблицы `order_products`
--
ALTER TABLE `order_products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
