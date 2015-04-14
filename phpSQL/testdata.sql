INSERT INTO Login values ('admin','9125eacc8ca11b06ec8f285a765ed3523dee033e','2985d19a820626e05198d0f475abc17e0762a41b');
INSERT INTO Login values ('app1','password','salt');
INSERT INTO Login values ('app2','password','salt');
INSERT INTO Login values ('app3','password','salt');
INSERT INTO Login values ('app4','password','salt');
INSERT INTO Login values ('app5','password','salt');
INSERT INTO Login values ('fac1','password','salt');
INSERT INTO Login values ('fac2','password','salt');


INSERT INTO Person(username,fname,lname) values('app1','Steve','Rodgers');
INSERT INTO Person(username,fname,lname) values('app2','Tony','Stark');
INSERT INTO Person(username,fname,lname) values('app3','Bruce','Banner');
INSERT INTO Person(username,fname,lname) values('app4','Natasha','Romanoff');
INSERT INTO Person(username,fname,lname) values('app5','Clint','Barton');
INSERT INTO Person(username,fname,lname) values('fac1','Grant','Scott');
INSERT INTO Person(username,fname,lname) values('fac2','Nick','Fury');

INSERT INTO is_a_faculty values (6);
INSERT INTO is_a_faculty values (7);

INSERT INTO is_an_applicant values (1,1,3.2,'5/20/16','thecapt@gmail.com','5732637422','y','SHIELD');
INSERT INTO is_an_applicant values (2,2,4.0,'5/20/16','ironman@jarvis.com','5735559837','y','Stark Ind');
INSERT INTO is_an_applicant values (3,3,3.2,'5/20/16','hulk@greengiant.com','5735559372','y',' ');
INSERT INTO is_an_applicant values (4,4,3.2,'5/20/16','blackwidow@shield.com','5735556281','y','SHIELD');
INSERT INTO is_an_applicant values (5,5,3.2,'5/20/16','hawkeye@shield.com','6365550395','y','SHIELD');

INSERT INTO is_a_grad values (1,'md','Shang');
INSERT INTO is_a_grad values (2,'phd','Shang');
INSERT INTO is_a_grad values (3,'phd','Shang');

INSERT INTO is_an_undergrad values(4,'Computer Science','Junior');
INSERT INTO is_an_undergrad values(5,'Information Technology','Senior');

INSERT INTO is_international values(4,76,'y','4/16/13','y');

INSERT INTO Course values (0,'Software Engineering 1','CS4320','01',6);
INSERT INTO Course values (1,'Algorithm Design & Programing 2','CS2050','01',7);

\echo
\echo Select all undergrads
SELECT * FROM Person P JOIN is_an_applicant iaa USING(sso) JOIN is_an_undergrad iau USING(sso);

\echo Select all grads
SELECT * FROM Person P JOIN is_an_applicant iaa USING(sso) JOIN is_a_grad iag USING(sso);

\echo Select all international grads
SELECT * FROM Person P JOIN is_an_applicant iaa USING(sso) JOIN is_a_grad iag USING(sso) JOIN is_international ii USING(sso);

\echo Select all international undergrads
SELECT * FROM Person P JOIN is_an_applicant iaa USING(sso) JOIN is_an_undergrad iau USING(sso) JOIN is_international ii USING(sso);
\echo
\echo Select all facutly
SELECT * FROM Person P JOIN is_a_faculty iaf USING(sso);

\echo Select classes
SELECT * FROM Course C JOIN PERSON P ON C.professor = P.sso;