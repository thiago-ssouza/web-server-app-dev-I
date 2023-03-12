--Create the database
CREATE DATABASE kidsGames; 

--Create the tables and view
CREATE TABLE player( 
    fName VARCHAR(50) NOT NULL, 
    lName VARCHAR(50) NOT NULL, 
    userName VARCHAR(20) NOT NULL UNIQUE,
    registrationTime DATETIME NOT NULL,
    id VARCHAR(200) GENERATED ALWAYS AS (CONCAT(UPPER(LEFT(fName,2)),UPPER(LEFT(lName,2)),UPPER(LEFT(userName,3)),CAST(registrationTime AS SIGNED))),
    registrationOrder INTEGER AUTO_INCREMENT,
    PRIMARY KEY (registrationOrder)
)CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 

CREATE TABLE authenticator(   
    passCode VARCHAR(255) NOT NULL,
    registrationOrder INTEGER, 
    FOREIGN KEY (registrationOrder) REFERENCES player(registrationOrder)
)CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 

CREATE TABLE score( 
    scoreTime DATETIME NOT NULL, 
    result ENUM('success', 'failure', 'incomplete'),
    livesUsed INTEGER NOT NULL,
    registrationOrder INTEGER, 
    FOREIGN KEY (registrationOrder) REFERENCES player(registrationOrder)
)CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 

CREATE VIEW history AS
SELECT s.scoreTime, p.id, p.fName, p.lName, s.result, s.livesUsed 
FROM player p, score s
WHERE p.registrationOrder = s.registrationOrder;

--Insert into the tables (including php variables)

INSERT INTO player(fName, lName, userName, registrationTime)
VALUES($first_name, $last_name, $user_name, $current_dateTime);

INSERT INTO authenticator(passCode,registrationOrder)
VALUES($pass_word, $user_rank);

INSERT INTO authenticator(passCode,registrationOrder)
VALUES($pass_word, $user_rank);

--select from the view
SELECT * FROM history;




--SAMPLE DATA TO TEST INSERT MANUALLY ------------------------
INSERT INTO player(fName, lName, userName, registrationTime)
VALUES('Patrick','Saint-Louis', 'sonic12345', now()); 
INSERT INTO player(fName, lName, userName, registrationTime)
VALUES('Marie','Jourdain', 'asterix2023', now());
INSERT INTO player(fName, lName, userName, registrationTime)
VALUES('Jonathan','David', 'pokemon527', now()); 
--------------------------------------------------

--SAMPLE DATA TO TEST INSERT MANUALLY ------------------------
INSERT INTO authenticator(passCode, registrationOrder)
VALUES('$2y$10$fxMTc4KD4mZlj03wc4grTuVLssP0ZKxeqfcfvxVx2xnrrKF.CKsk.', 1);

INSERT INTO authenticator(passCode, registrationOrder)
VALUES('$2y$10$AH/612QosAUyKIy5s4lEBuGdNAhnw.PbHYfIuLNK2aHQXWRMIF6fi', 2);

INSERT INTO authenticator(passCode, registrationOrder)
VALUES('$2y$10$rSNEZ5wd8YyRRlNCmwfb2uUvkffrAMdmLkcm5s.b7WAgiGy8UoA1i', 3);
--------------------------------------------------

--SAMPLE DATA TO TEST INSERT MANUALLY ------------------------
INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
VALUES(now(), 'success', 4, 1);

INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
VALUES(now(), 'failure', 6, 2);

INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
VALUES(now(), 'incomplete', 5, 3);
--------------------------------------------------

SELECT * FROM history;

/* Output
scoreTime 	            id 	                    fName 	    lName 	        result 	    livesUsed 	
2023-03-05 14:47:13 	PASASON20230305144511 	Patrick 	Saint-Louis 	success 	4
2023-03-05 14:47:46 	MAJOAST20230305144548 	Marie 	    Jourdain 	    failure 	6
2023-03-05 14:48:08 	JODAPOK20230305144617 	Jonathan 	David 	        incomplete 	5
*/