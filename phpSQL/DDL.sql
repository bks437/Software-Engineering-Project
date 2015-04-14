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
--    action     - What the user did to generate a log entry (i.e., "logged in").
-- CREATE TABLE DDL.log (
-- 	log_id  	SERIAL PRIMARY KEY,
-- 	username 	VARCHAR(30) NOT NULL REFERENCES DDL.user_info,
-- 	ip_address 	VARCHAR(15) NOT NULL,
-- 	log_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
-- 	action 		VARCHAR(50) NOT NULL
-- );


DROP TABLE IF EXISTS Login;

CREATE TABLE Login(
	sso serial UNIQUE,
	username varchar(32),
	password_hash char(40),
	salt char(40),
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
	sso integer,
	fname varchar(32),
	lname varchar(32),
	PRIMARY KEY(sso),
	FOREIGN KEY(sso) REFERENCES Login(sso) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_an_applicant;

CREATE TABLE is_an_applicant(
	sso integer,
	id integer,
	gpa numeric,
	grad_date date,
	email varchar(255),
	phone char(10),
	gato char,
	employer varchar(255),
	ta_rank char(2),
	PRIMARY KEY(sso),
	FOREIGN KEY(sso) REFERENCES Person(sso) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_a_grad;

CREATE TABLE is_a_grad(
	sso integer,
	degree char(3),
	advisor varchar(32),
	PRIMARY KEY(sso),
	FOREIGN KEY(sso) REFERENCES is_an_applicant(sso) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_an_undergrad;

CREATE TABLE is_an_undergrad(
	sso integer,
	degree_program varchar(32),
	level varchar(10),
	PRIMARY KEY(sso),
	FOREIGN KEY(sso) REFERENCES is_an_applicant(sso) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_international;

CREATE TABLE is_international(
	sso integer,
	speak integer,
	speak_taken char,
	test_date date,
	onita char,
	PRIMARY KEY(sso),
	FOREIGN KEY(sso) REFERENCES is_an_applicant(sso) ON DELETE CASCADE

);

DROP TABLE IF EXISTS is_a_faculty;

CREATE TABLE is_a_faculty(
	sso integer,
	PRIMARY KEY(sso),
	FOREIGN KEY(sso) REFERENCES Person(sso) ON DELETE CASCADE

);

DROP TABLE IF EXISTS Comments;

CREATE TABLE Comments(
	professor integer,
	ta_sso integer,
	comment varchar(1024),
	PRIMARY KEY(professor,ta_sso),
	FOREIGN KEY(professor) REFERENCES is_a_faculty(sso),
	FOREIGN KEY(ta_sso) REFERENCES is_an_applicant(sso) ON DELETE CASCADE

);

DROP TABLE IF EXISTS Course;

CREATE TABLE Course(
	c_id serial,
	name varchar(32),
	numb char(6),
	section char(2),
	professor integer,
	PRIMARY KEY(c_id),
	FOREIGN KEY(professor) REFERENCES is_a_faculty(sso) ON DELETE CASCADE

);

DROP TABLE IF EXISTS has_taught;

CREATE TABLE has_taught(
	ta_sso integer,
	c_id integer,
	PRIMARY KEY(ta_sso,c_id),
	FOREIGN KEY(ta_sso) REFERENCES is_an_applicant(sso) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE

);

DROP TABLE IF EXISTS wants_to_teach;

CREATE TABLE wants_to_teach(
	ta_sso integer,
	c_id integer,
	PRIMARY KEY(ta_sso,c_id),
	FOREIGN KEY(ta_sso) REFERENCES is_an_applicant(sso) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS has_taken;

CREATE TABLE has_taken(
	ta_sso integer,
	c_id integer,
	PRIMARY KEY(ta_sso,c_id),
	FOREIGN KEY(ta_sso) REFERENCES is_an_applicant(sso) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS assigned_to;

CREATE TABLE assigned_to(
	ta_sso integer,
	c_id integer,
	PRIMARY KEY(ta_sso),
	FOREIGN KEY(ta_sso) REFERENCES is_an_applicant(sso) ON DELETE CASCADE,
	FOREIGN KEY(c_id) REFERENCES Course(c_id) ON DELETE CASCADE
);