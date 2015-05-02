DROP SCHEMA IF EXISTS DDL CASCADE;

CREATE SCHEMA DDL;
SET search_path = DDL, public;

-- DROP TABLE IF EXISTS DDL.log;
-- DROP TABLE IF EXISTS DDL.authentication;
-- DROP TABLE IF EXISTS DDL.user_info;
-- Table: DDL.user_info
-- Columns:
--    username          - The username for the account, supplied during registration.
--    registration_date - The date the user registered. Set automatically.
--    description       - A user-supplied description.
-- CREATE TABLE DDL.user_info (
-- 	username 		VARCHAR(30) PRIMARY KEY,
-- 	registration_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
-- 	description 		VARCHAR(500)
-- );

-- Table: DDL.authentication
-- Columns:
--    username      - The username tied to the authentication info.
--    password_hash - The hash of the user's password + salt. Expected to be SHA1.
--    salt          - The salt to use. Expected to be a SHA1 hash of a random input.
-- CREATE TABLE DDL.authentication (
-- 	username 	VARCHAR(30) PRIMARY KEY,
-- 	password_hash 	CHAR(40) NOT NULL,
-- 	salt 		CHAR(40) NOT NULL,
-- 	FOREIGN KEY (username) REFERENCES DDL.user_info(username)
-- );

-- Table: DDL.log
-- Columns:
--    log_id     - A unique ID for the log entry. Set by a sequence.
--    username   - The user whose action generated this log entry.
--    ip_address - The IP address of the user at the time the log was entered.
--    log_date   - The date of the log entry. Set automatically by a default value.
-- --    action     - What the user did to generate a log entry (i.e., "logged in").
-- CREATE TABLE DDL.log (
-- 	log_id  	SERIAL PRIMARY KEY,
-- 	username 	VARCHAR(30) NOT NULL REFERENCES DDL.user_info,
-- 	ip_address 	VARCHAR(15) NOT NULL,
-- 	log_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
-- 	action 		VARCHAR(50) NOT NULL
-- );


DROP TABLE IF EXISTS Login;

CREATE TABLE Login(
	username varchar(32) NOT NULL,
	password_hash char(40) NOT NULL,
	salt char(40) NOT NULL,
	registration_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(username)

);
DROP TABLE IF EXISTS log;

CREATE TABLE log (
	log_id  	SERIAL PRIMARY KEY,
	username 	VARCHAR(30) NOT NULL REFERENCES Login,
	ip_address 	VARCHAR(15) NOT NULL,
	log_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	action 		VARCHAR(50) NOT NULL
);
CREATE INDEX log_log_id_index ON DDL.log (username);

DROP TABLE IF EXISTS Person;

CREATE TABLE Person(
	username varchar(32) NOT NULL,
	fname varchar(32) NOT NULL,
	lname varchar(32) NOT NULL,
	PRIMARY KEY(username),
	FOREIGN KEY(username) REFERENCES Login(username) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_an_applicant;

CREATE TABLE is_an_applicant(
	username varchar(32) NOT NULL,
	id integer NOT NULL,
	gpa numeric NOT NULL,
	grad_date date NOT NULL,
	email varchar(255) NOT NULL,
	phone char(10) NOT NULL,
	gato char NOT NULL,
	employer varchar(255),
	--ta_rank char(2),
	resume bytea,
	PRIMARY KEY(username),
	FOREIGN KEY(username) REFERENCES Person(username) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_a_grad;

CREATE TABLE is_a_grad(
	username varchar(32) NOT NULL,
	degree char(3) NOT NULL,
	advisor varchar(32) NOT NULL,
	PRIMARY KEY(username),
	FOREIGN KEY(username) REFERENCES is_an_applicant(username) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_an_undergrad;

CREATE TABLE is_an_undergrad(
	username varchar(32) NOT NULL,
	degree_program varchar(32 NOT NULL,
	level varchar(10) NOT NULL,
	PRIMARY KEY(username),
	FOREIGN KEY(username) REFERENCES is_an_applicant(username) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_international;

CREATE TABLE is_international(
	username varchar(32) NOT NULL,
	speak integer NOT NULL,
	speak_taken char NOT NULL,
	test_date date NOT NULL,
	onita char NOT NULL,
	PRIMARY KEY(username),
	FOREIGN KEY(username) REFERENCES is_an_applicant(username) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_a_faculty;

CREATE TABLE is_a_faculty(
	username varchar(32) NOT NULL,
	admin char DEFAULT 'n',
	PRIMARY KEY(username),
	FOREIGN KEY(username) REFERENCES Person(username) ON DELETE CASCADE

);

DROP TABLE IF EXISTS Semester;

CREATE TABLE Semester(
	name char(4) NOT NULL,
	studentstart date NOT NULL,
	studentend date NOT NULL,
	facultystart date NOT NULL,
	facultyend date NOT NULL,
	PRIMARY KEY (name)
);

DROP TABLE IF EXISTS Comments;

CREATE TABLE Comments(
	professor varchar(32) NOT NULL,
	ta_username varchar(32) NOT NULL,
	comment varchar(1024) NOT NULL,
	semester char(4) NOT NULL,
	PRIMARY KEY(professor,ta_username),
	FOREIGN KEY(professor) REFERENCES is_a_faculty(username),
	FOREIGN KEY(ta_username) REFERENCES is_an_applicant(username) ON DELETE CASCADE,
	FOREIGN KEY(semester) REFERENCES Semester(name) ON DELETE CASCADE


);

DROP TABLE IF EXISTS Course;

CREATE TABLE Course(
	c_id serial,
	name varchar(32)  NOT NULL,
	numb char(6) UNIQUE NOT NULL,
	section char(2),
	professor varchar(32)NOT NULL,
	PRIMARY KEY(c_id),
	FOREIGN KEY(professor) REFERENCES is_a_faculty(username) ON DELETE CASCADE

);

DROP TABLE IF EXISTS has_taught;

CREATE TABLE has_taught(
	ta_username varchar(32)  NOT NULLNOT NULL,
	c_id integer  NOT NULLNOT NULL,
	PRIMARY KEY(ta_username,c_id),
	FOREIGN KEY(ta_username) REFERENCES is_an_applicant(username) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE

);

DROP TABLE IF EXISTS wants_to_teach;

CREATE TABLE wants_to_teach(
	ta_username varchar(32),
	grade CHAR(2),
	c_id integer,
	PRIMARY KEY(ta_username,c_id),
	FOREIGN KEY(ta_username) REFERENCES is_an_applicant(username) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS has_taken;

CREATE TABLE are_teaching(
	ta_username varchar(32),
	c_id integer,
	PRIMARY KEY(ta_username,c_id),
	FOREIGN KEY(ta_username) REFERENCES is_an_applicant(username) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE
);



DROP TABLE IF EXISTS professor_wants_ta;

CREATE TABLE professor_wants_ta(
	ta_username varchar(32) NOT NULL,
	professor varchar(32) NOT NULL,
	c_id integer NOT NULL,
	PRIMARY KEY (ta_username,professor),
	FOREIGN KEY(ta_username) REFERENCES is_an_applicant(username) ON DELETE CASCADE,
	FOREIGN KEY(professor) REFERENCES is_a_faculty(username) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE

);


DROP TABLE IF EXISTS applicant_applies_for_semester;

CREATE TABLE applicant_applies_for_semester(
	username varchar(32) NOT NULL,
	semester char(4) NOT NULL,
	ta_rank integer NOT NULL,
	PRIMARY KEY(username,semester),
	FOREIGN KEY(semester) REFERENCES Semester(name),
	FOREIGN KEY(username) REFERENCES is_an_applicant(username) ON DELETE CASCADE

);

DROP TABLE IF EXISTS semester_has_class;

CREATE TABLE semester_has_class(
	semester char(4),
	c_id integer,
	FOREIGN KEY(semester) REFERENCES Semester(name),
	FOREIGN KEY(c_id) REFERENCES Course(c_id),
	PRIMARY KEY (semester,c_id)
);

DROP TABLE IF EXISTS assigned_to;

CREATE TABLE assigned_to(
	ta_username varchar(32),
	semester char(4),
	c_id integer NOT NULL,
	PRIMARY KEY(ta_username,semester),
	FOREIGN KEY(ta_username) REFERENCES is_an_applicant(username) ON DELETE CASCADE,
	FOREIGN KEY(semester) REFERENCES Semester(name) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE
);
