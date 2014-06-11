DROP TABLE IF EXISTS bugs;
DROP TABLE IF EXISTS change_log;

CREATE TABLE bugs (
	id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title CHAR(200) NOT NULL,
	description TEXT,
	status ENUM('New', 'Confirmed', 'In Process', 'Resolved', 'Verified'),
	created DATETIME NOT NULL DEFAULT NOW(),
	modified DATETIME NOT NULL DEFAULT NOW())
	ENGINE = InnoDB,
	DEFAULT CHARACTER SET = 'utf8';

CREATE TABLE change_log (
	id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	bug_id MEDIUMINT NOT NULL,
	change_date DATETIME NOT NULL DEFAULT NOW(),
	from_status ENUM('New', 'Confirmed', 'In Process', 'Resolved', 'Verified'),
	to_status ENUM('New', 'Confirmed', 'In Process', 'Resolved', 'Verified')) 
	ENGINE = InnoDB,
	DEFAULT CHARACTER SET = 'utf8';
