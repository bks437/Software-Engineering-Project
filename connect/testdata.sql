INSERT INTO Login values ('admin','9125eacc8ca11b06ec8f285a765ed3523dee033e','2985d19a820626e05198d0f475abc17e0762a41b');
INSERT INTO Login values ('app1','9125eacc8ca11b06ec8f285a765ed3523dee033e','2985d19a820626e05198d0f475abc17e0762a41b');
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

INSERT INTO Course(name,numb,section,professor) values ('Software Engineering 1','CS4320','01','fac1');
INSERT INTO Course(name,numb,section,professor) values ('Algorithm Design & Programing 2','CS2050','01','fac2');

INSERT INTO has_taught values ('app2',0);
INSERT INTO has_taught values ('app2',1);
INSERT INTO has_taught values ('app3',0);
INSERT INTO has_taught values ('app1',1);
INSERT INTO has_taught values ('app5',0);

INSERT INTO wants_to_teach values ('app2','A+',0);
INSERT INTO wants_to_teach values ('app3','A-',1);
INSERT INTO wants_to_teach values ('app4','B',0);
INSERT INTO wants_to_teach values ('app5','C+',1);
INSERT INTO wants_to_teach values ('app1','B-',0);

INSERT INTO are_teaching values ('app2',1);
INSERT INTO are_teaching values ('app3',0);

INSERT INTO Semester values ('FS15','04-01-2015','05-25-2015','05-052015','05-25-2015');

INSERT INTO applicant_applies_for_semester(username,semester) values ('app2','FS15');
INSERT INTO applicant_applies_for_semester(username,semester) values ('app1','FS15');
INSERT INTO applicant_applies_for_semester(username,semester) values ('app3','FS15');
INSERT INTO applicant_applies_for_semester(username,semester) values ('app5','FS15');

INSERT INTO semester_has_class values ('FS15',0);
INSERT INTO semester_has_class values ('FS15',1);

INSERT INTO professor_wants_ta values ('app2','fac1',0);
INSERT INTO professor_wants_ta values ('app3','fac1',0);
INSERT INTO professor_wants_ta values ('app2','fac2',1);
INSERT INTO professor_wants_ta values ('app4','fac2',0);

INSERT INTO Comments values ('fac1','app2','Test comment','FS15');





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

\echo Show courses available for the semester
SELECT * FROM Course C JOIN semester_has_class USING(c_id) WHERE semester='FS15';

\echo Select Applicants who have not been ranked for FS15 semester
SELECT P.fname, P.lname FROM Person P JOIN applicant_applies_for_semester aafs Using(username) where aafs.ta_rank IS NULL AND aafs.semester='FS15';

\echo show applicants an the class they want to teach for a certain semester
SELECT P.fname,P.lname,C.name FROM Person P JOIN wants_to_teach wtt ON wtt.ta_username=P.username JOIN Course C USING(c_id) JOIN semester_has_class  shc USING(c_id) WHERE shc.semester='FS15';

\echo show professors and ta they want
SELECT * FROM Person p JOIN is_a_faculty iaf USING(username) JOIN professor_wants_ta  pwt ON pwt.professor=iaf.username JOIN Person P2 ON pwt.ta_username=P2.username;

\echo Show all comments for one student
SELECT C.comment,P.fname,P.lname FROM Comments C JOIN Person P ON P.username=C.ta_username WHERE p.username='app2';