CREATE DATABASE noteswall;
USE noteswall;
CREATE TABLE notes ( 
	id INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY (id), 
	username VARCHAR(16) NOT NULL, 
	message VARCHAR(128) NOT NULL,
	notetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO notes (username, message) VALUES ('admin', 'initial note!');
INSERT INTO notes (username, message) VALUES ('someuser', 'another note');

