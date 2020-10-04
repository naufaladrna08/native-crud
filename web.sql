USE `acpnepur.sch.id`;

-- Hapus dan buat table
DROP TABLE `quizzes`; 
DROP TABLE `questions`;
DROP TABLE `result`;
DROP TABLE `users`;

CREATE TABLE IF NOT EXISTS users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS result (
  `result_id` INT(11) NOT NULL AUTO_INCREMENT,
  `attempt` INT(11) NOT NULL,
  `correct` INT(11) NOT NULL,
  `wrong` INT(11) NOT NULL,
  `percentage` varchar(100) NOT NULL,
  `user_id` VARCHAR(11) NOT NULL,
  `code` INT NOT NULL,
  PRIMARY KEY (`result_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
 
CREATE TABLE IF NOT EXISTS quizzes (
	quiz_id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_title VARCHAR(255) NOT NULL,
    quiz_description TEXT NOT NULL,
    quiz_thumbnail VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS questions (
	question_id INT AUTO_INCREMENT PRIMARY KEY,
    question_number INT NOT NULL,
    question TEXT NOT NULL,
    answers TEXT NOT NULL,
    correct_index INT NOT NULL,
    quiz_id INT
) ENGINE=InnoDB;

SHOW TABLES;
SELECT * FROM questions