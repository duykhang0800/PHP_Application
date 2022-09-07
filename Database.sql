CREATE DATABASE auction;
USE auction;

CREATE TABLE `Branch` (
  `Branch_Code` char(2),
  `Branch_Name` varchar(50),
  `Address` varchar(255),
  `Hotline` varchar(50),
  PRIMARY KEY (`Branch_Code`),
  KEY `UN` (`Branch_Name`)
) ENGINE=InnoDB;

CREATE TABLE `Customer` (
  `Customer_Email` varchar(100),
  `Branch_Code` char(2),
  `Password` char(60),
  `Phone` char(10) UNIQUE NOT NULL,
  `First_Name` varchar(20),
  `Last_Name` varchar(20),
  `Customer_ID` char(12),
  `Address` varchar(255),
  `City` varchar(20),
  `Country` varchar(20),
  `Balance` decimal(11, 0),
  `Profile_Picture` BLOB,
  PRIMARY KEY (`Customer_Email`),
  FOREIGN KEY (`Branch_Code`) REFERENCES `Branch`(`Branch_Code`),
  KEY `UN` (`Phone`, `Customer_ID`)
) ENGINE=InnoDB;

CREATE TABLE `Bid` (
  `Customer_Email` varchar(100),
  `Auction_ID` varchar(25),
  `Bid` decimal(9, 0),
  PRIMARY KEY (`Customer_Email`, `Auction_ID`),
  FOREIGN KEY (`Customer_Email`) REFERENCES `Customer`(`Customer_Email`)
) ENGINE=InnoDB;

CREATE INDEX Auction_ID_idx ON Bid (Auction_ID);

INSERT INTO Branch (Branch_Code, Branch_Name, Address, Hotline) VALUES ('as','Asia','Vietnam','+84 1900 1234');
INSERT INTO Branch (Branch_Code, Branch_Name, Address, Hotline) VALUES ('eu','Europe','Italy','+39 1700 4321');
INSERT INTO Branch (Branch_Code, Branch_Name, Address, Hotline) VALUES ('na','North America','The United States','+1 1800 5678');
INSERT INTO Branch (Branch_Code, Branch_Name, Address, Hotline) VALUES ('sa','South America','Brazil','+55 1600 8765');
INSERT INTO Branch (Branch_Code, Branch_Name, Address, Hotline) VALUES ('oc','Oceania','Australia','+61 1500 1458');

CREATE USER 'auctionguest'@'localhost' IDENTIFIED BY '';
CREATE USER 'signinnup'@'localhost' IDENTIFIED BY '';
CREATE USER 'auctionadmin'@'localhost' IDENTIFIED BY '';

GRANT SELECT ON auction.Customer TO 'signinnup'@'localhost';
GRANT INSERT ON auction.Customer TO 'signinnup'@'localhost';
GRANT SELECT ON auction.Bid TO 'auctionguest'@'localhost';
GRANT INSERT ON auction.Bid TO 'auctionguest'@'localhost';
GRANT UPDATE ON auction.Bid TO 'auctionguest'@'localhost';
GRANT SELECT ON auction.Customer TO 'auctionguest'@'localhost';
GRANT ALL ON auction.Customer TO 'auctionadmin'@'localhost';
GRANT ALL ON auction.Bid TO 'auctionadmin'@'localhost';



DELIMITER $$

CREATE TRIGGER bidding_rule
BEFORE INSERT ON Bid
FOR EACH ROW
BEGIN
  DECLARE current_max decimal(9, 0);
  DECLARE user_balance decimal(11, 0);

  SELECT MAX(Bid) INTO current_max FROM Bid WHERE Auction_ID = NEW.Auction_ID;

  IF NEW.Bid <= current_max THEN
    SIGNAL SQLSTATE '45000' set message_text = "The Bid amount is too tow";
  END IF;

  SELECT Balance INTO user_balance FROM Customer WHERE Customer_Email = NEW.Customer_Email;

  IF NEW.Bid > user_balance THEN
    SIGNAL SQLSTATE '45000' set message_text = "Your Balance is to low to place this amount of bid";
  END IF;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE sp_tranfer_money(IN a_id varchar(25), IN seller varchar(100))
BEGIN
	declare amount decimal(9, 0);
    declare buyer varchar(100);
    declare after_bal decimal(11, 0);

    SELECT MAX(Bid) INTO amount FROM Bid WHERE Auction_ID = a_id;
	select Customer_Email into buyer from Bid where Auction_ID = a_id and Bid = amount;

    start transaction;

    update Customer set Balance = Balance + amount where Customer_Email = seller;
    update Customer set Balance = Balance - amount where Customer_Email = buyer;

    select Balance into after_bal from customer where Customer_Email = buyer;

    if after_bal < 0 then
		rollback;
        SIGNAL SQLSTATE '45000' set message_text = "The Balance is to low for this tranfer";
    else
		commit;
    end if;

END $$

DELIMITER ;



INSERT INTO Customer (Customer_Email, Branch_Code, Password, Phone, First_Name, Last_Name, Customer_ID, Balance)
VALUES ('user1@test.com', 'as', '$2y$10$v0X89tS16B8v/EJQHjQsH.GA.58KbrhPuXl9zPc7/s/b1oLfsLTtq', '12345678', 'Jane', 'Doe', '12345678', '14000');

INSERT INTO Customer (Customer_Email, Branch_Code, Password, Phone, First_Name, Last_Name, Customer_ID, Balance)
VALUES ('user2@test.com', 'as', '$2y$10$WpOO.Nh8ncwcFvphT5aUv.S39XqzpYbIg36cfgLawPKIViOOdVHTK', '87654321', 'Bobby', 'Brown', '87654321', '22000');
