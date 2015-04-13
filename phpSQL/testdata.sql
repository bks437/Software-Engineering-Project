INSERT INTO Login values (0,'admin','password','salt');
INSERT INTO Login values (1,'app1','password','salt');
INSERT INTO Login values (2,'app2','password','salt');
INSERT INTO Login values (3,'app3','password','salt');
INSERT INTO Login values (4,'app4','password','salt');
INSERT INTO Login values (5,'app5','password','salt');
INSERT INTO Login values (6,'fac1','password','salt');
INSERT INTO Login values (7,'fac2','password','salt');


INSERT INTO Person values(1,'Steve','Rodgers');
INSERT INTO Person values(2,'Tony','Stark');
INSERT INTO Person values(3,'Bruce','Banner');
INSERT INTO Person values(4,'Natasha','Romanoff');
INSERT INTO Person values(5,'Clint','Barton');
INSERT INTO Person values(6,'Grant','Scott');
INSERT INTO Person values(7,'Nick','Fury');

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