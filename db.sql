-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.38-log - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.3.0.5051
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных msgsoft
CREATE DATABASE IF NOT EXISTS `msgsoft` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `msgsoft`;

-- Дамп структуры для таблица msgsoft.history_task
CREATE TABLE IF NOT EXISTS `history_task` (
  `history_task_id` int(11) NOT NULL AUTO_INCREMENT,
  `old_executor_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `comment` text,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`history_task_id`),
  KEY `idx-history_task-old_executor_id` (`old_executor_id`),
  KEY `idx-history_task-task_id` (`task_id`),
  CONSTRAINT `fk-history_task-task_id` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk-history_task-old_executor_id` FOREIGN KEY (`old_executor_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы msgsoft.history_task: ~0 rows (приблизительно)
DELETE FROM `history_task`;
/*!40000 ALTER TABLE `history_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `history_task` ENABLE KEYS */;

-- Дамп структуры для таблица msgsoft.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы msgsoft.migration: ~6 rows (приблизительно)
DELETE FROM `migration`;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1460916986),
	('m160417_172359_create_users', 1460916990),
	('m160417_173025_create_projects', 1460916990),
	('m160417_174540_create_tasks', 1460916990),
	('m160417_175203_create_history_task', 1460916992),
	('m160417_175714_data_insert', 1460916992);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- Дамп структуры для таблица msgsoft.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `expiration_date` datetime NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(3) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_id`),
  KEY `idx-projects-user_id` (`user_id`),
  KEY `idx-projects-status_id` (`status_id`),
  CONSTRAINT `fk-projects-user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы msgsoft.projects: ~3 rows (приблизительно)
DELETE FROM `projects`;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`project_id`, `title`, `create_date`, `expiration_date`, `description`, `user_id`, `status_id`, `deleted`) VALUES
	(1, 'Тестовое задание', '2016-04-16 20:11:29', '2016-04-16 20:11:30', 'description', 1, 2, 0),
	(2, 'Project 2', '2016-04-16 20:11:29', '2016-04-16 20:11:30', 'description', 2, 2, 0),
	(3, 'Project 3', '2016-04-16 20:11:29', '2016-04-16 20:11:30', 'description', 1, 0, 0);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Дамп структуры для таблица msgsoft.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `executor_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `status_id` int(3) NOT NULL DEFAULT '0',
  `expiration_date` datetime NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`task_id`),
  KEY `idx-tasks-executor_id` (`executor_id`),
  KEY `idx-tasks-author_id` (`author_id`),
  KEY `idx-tasks-project_id` (`project_id`),
  KEY `idx-tasks-status_id` (`status_id`),
  CONSTRAINT `fk-tasks-project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk-tasks-author_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk-tasks-executor_id` FOREIGN KEY (`executor_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы msgsoft.tasks: ~3 rows (приблизительно)
DELETE FROM `tasks`;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`task_id`, `title`, `description`, `executor_id`, `author_id`, `project_id`, `status_id`, `expiration_date`, `deleted`) VALUES
	(1, 'Task 1', 'task 1 description', 2, 1, 1, 1, '2016-04-17 11:04:51', 0),
	(2, 'Task 2', 'task 2 description', 2, 1, 1, 0, '2016-04-17 11:04:51', 0),
	(3, 'Task 3', 'task 3 description', 2, 2, 2, 0, '2016-04-17 11:04:51', 0);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Дамп структуры для таблица msgsoft.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `access_token` (`access_token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы msgsoft.users: ~2 rows (приблизительно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `fname`, `lname`, `birthday`, `picture`, `email`, `password`, `access_token`) VALUES
	(1, 'Иван', 'Иванов', '2000-04-17', 'ivan.jpg', 'ivan@i.ru', '123', 'QWxhZGRpbjpvcGVuIHNlc2FtZQ=='),
	(2, 'Вася', 'Васильев', '1996-05-27', 'vasia.jpg', 'vasia@v.ru', '123', 'QWxhZGRpbjpvcGVuIHNlc2FtZQ22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
