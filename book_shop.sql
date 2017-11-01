CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`id_role` int(11) NOT NULL DEFAULT '1',
	`login` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`pass` varchar(255) NOT NULL,
	`hash` varchar(255) NOT NULL DEFAULT 'Null',
	PRIMARY KEY (`id`)
);

CREATE TABLE `roles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `rooms` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `events` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`id_user` int(11) NOT NULL,
	`id_room` int(11) NOT NULL,
	`description` TEXT NOT NULL,
	`time_start` DATETIME NOT NULL,
	`time_end` DATETIME NOT NULL,
	`id_parent` int(11) NULL,
	`create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);

ALTER TABLE `users` ADD CONSTRAINT `users_fk0` FOREIGN KEY (`id_role`) REFERENCES `roles`(`id`);

ALTER TABLE `events` ADD CONSTRAINT `events_fk0` FOREIGN KEY (`id_user`) REFERENCES `users`(`id`);

ALTER TABLE `events` ADD CONSTRAINT `events_fk1` FOREIGN KEY (`id_room`) REFERENCES `rooms`(`id`);
