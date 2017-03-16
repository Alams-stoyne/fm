DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `file_path` varchar(1000) NOT NULL,
  `file_url` varchar(1000) NOT NULL,
  `file_ext` varchar(5) NOT NULL,
  `date_create` int(11) NOT NULL,
  `date_last_action` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `user_role` int(1) NOT NULL,
  `delete` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251;

DROP TABLE IF EXISTS `files_history`;
CREATE TABLE IF NOT EXISTS `files_history` (
  `id` int(11) NOT NULL,
  `id_file` int(11) NOT NULL,
  `type_action` int(1) NOT NULL,
  `date_action` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `file_path` varchar(1000) NOT NULL,
  `file_ext` varchar(5) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251;


DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `login` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `login`, `password`, `role`) VALUES
(1, 'aDmin', 'admin', 'admin', 1),
(2, 'bRoker', 'broker', 'broker', 2),
(3, 'oWner', 'structure_owner', 'structure_owner', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `files_history`
--
ALTER TABLE `files_history`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `files_history`
--
ALTER TABLE `files_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
