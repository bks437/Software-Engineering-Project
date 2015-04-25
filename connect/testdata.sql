INSERT INTO Login values ('admin','9125eacc8ca11b06ec8f285a765ed3523dee033e','2985d19a820626e05198d0f475abc17e0762a41b');
INSERT INTO Login values ('app1','password','salt');
INSERT INTO Login values ('app2','password','salt');
INSERT INTO Login values ('app3','password','salt');
INSERT INTO Login values ('app4','password','salt');
INSERT INTO Login values ('app5','password','salt');
INSERT INTO Login values ('fac1','9125eacc8ca11b06ec8f285a765ed3523dee033e','2985d19a820626e05198d0f475abc17e0762a41b');
INSERT INTO Login values ('fac2','password','salt');

INSERT INTO Person(username,fname,lname) values('admin','Steve','Rodgers');
INSERT INTO Person(username,fname,lname) values('app1','Steve','Rodgers');
INSERT INTO Person(username,fname,lname) values('app2','Tony','Stark');
INSERT INTO Person(username,fname,lname) values('app3','Bruce','Banner');
INSERT INTO Person(username,fname,lname) values('app4','Natasha','Romanoff');
INSERT INTO Person(username,fname,lname) values('app5','Clint','Barton');
INSERT INTO Person(username,fname,lname) values('fac1','Grant','Scott');
INSERT INTO Person(username,fname,lname) values('fac2','Nick','Fury');

INSERT INTO is_a_faculty values ('admin','y');
INSERT INTO is_a_faculty(username) values ('fac1');
INSERT INTO is_a_faculty(username) values ('fac2');

INSERT INTO is_an_applicant values ('app1',2,3.2,'5/20/16','thecapt@gmail.com','5732637422','y','SHIELD');
INSERT INTO is_an_applicant values ('app2',3,4.0,'5/20/16','ironman@jarvis.com','5735559837','y','Stark Ind');
INSERT INTO is_an_applicant values ('app3',4,3.2,'5/20/16','hulk@greengiant.com','5735559372','y',' ');
INSERT INTO is_an_applicant values ('app4',5,3.2,'5/20/16','blackwidow@shield.gov','5735556281','y','SHIELD');
INSERT INTO is_an_applicant values ('app5',6,3.2,'5/20/16','hawkeye@shield.gov','6365550395','y','SHIELD');

INSERT INTO is_a_grad values ('app1','md','Shang');
INSERT INTO is_a_grad values ('app2','phd','Shang');
INSERT INTO is_a_grad values ('app3','phd','Shang');

INSERT INTO is_an_undergrad values('app4','Computer Science','Junior');
INSERT INTO is_an_undergrad values('app5','Information Technology','Senior');

INSERT INTO is_international values('app4',76,'y','4/16/13','y');

INSERT INTO Course values (0,'Software Engineering 1','CS4320','01','fac1');
INSERT INTO Course values (1,'Algorithm Design & Programing 2','CS2050','01','fac2');

\echo
\echo Select all undergrads
SELECT * FROM Person P JOIN is_an_applicant iaa USING(username) JOIN is_an_undergrad iau USING(username);

\echo Select all grads
SELECT * FROM Person P JOIN is_an_applicant iaa USING(username) JOIN is_a_grad iag USING(username);

\echo Select all international grads
SELECT * FROM Person P JOIN is_an_applicant iaa USING(username) JOIN is_a_grad iag USING(username) JOIN is_international ii USING(username);

\echo Select all international undergrads
SELECT * FROM Person P JOIN is_an_applicant iaa USING(username) JOIN is_an_undergrad iau USING(username) JOIN is_international ii USING(username);
\echo
\echo Select all facutly
SELECT * FROM Person P JOIN is_a_faculty iaf USING(username);

\echo Select classes
SELECT * FROM Course C JOIN PERSON P ON C.professor = P.username;
