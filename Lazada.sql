CREATE DATABASE lazada;
USE lazada;

CREATE TABLE `Vendor` (
	`Vendor_ID` char(10) UNIQUE NOT NULL,
	`Vendor_Name` varchar(50) NOT NULL, 
	`Address` varchar(255),
	`Latitude` char(50) NOT NULL,
	`Longitude` char(50) NOT NULL,
	`Username` varchar(50) UNIQUE NOT NULL,
	`Password` varchar(50) NOT NULL,
    `Role` varchar(20) NOT NULL,
	PRIMARY KEY (`Vendor_ID`)
) ENGINE=InnoDB;

alter table Vendor add unique Vendor_unique_Latitude_Longitude(Latitude, Longitude);

CREATE TABLE `Customer` (
	`Customer_ID` char(10) UNIQUE NOT NULL,  
	`Customer_Name` varchar(100) NOT NULL,
	`Address` varchar(255),
	`Latitude` char(50) NOT NULL,
	`Longitude` char(50) NOT NULL, 
	`Username` varchar(50) UNIQUE NOT NULL,
	`Password` varchar(50) NOT NULL,
    `Role` varchar(20) NOT NULL,
	PRIMARY KEY (`Customer_ID`)
) ENGINE=InnoDB;

CREATE TABLE `Shipper` (
	`Shipper_ID` char(10) UNIQUE NOT NULL,
	`Username` varchar(50) NOT NULL,
	`Password` varchar(50) NOT NULL,
    `Distribution_hub` varchar (50) UNIQUE NOT NULL,
    `Role` varchar(20) NOT NULL,
	PRIMARY KEY (`Shipper_ID`)
) ENGINE=InnoDB;
    
Create TABLE `Distribution_hub` (
	`Shipper_ID` char(10) UNIQUE NOT NULL,
	`Hub_ID` char(10) UNIQUE NOT NULL,
	`Hub_Name` varchar(50) NOT NULL,
	`Latitude` char(50) NOT NULL,
	`Longitude` char(50) NOT NULL,
	`Username` varchar(50) UNIQUE NOT NULL,
     Primary key (`Hub_ID`),
     Foreign key ( `Shipper_ID`) REFERENCES `Shipper` (`Shipper_ID`)
) ENGINE = InnoDB;

alter table Distribution_hub add unique Distribution_hub_unique_Latitude_Longitude(Latitude, Longitude);

INSERT INTO Customer (Customer_ID, Customer_Name, Address, Latitude, Longitude, Username, Password, Role) VALUES 
('2','Nghia','RMIT SGS','10.7293107', '106.691477', 'NNghia','Nghia123','Customer'),
('3','Trump','New World Hotel','10.7710502', '106.6925586', 'DTrump','Trump111','Customer'),
('4','Khang','Nikko Saigon Hotel','10.7641288', '106.6807345', 'KhangN','Khang222','Customer');

INSERT INTO Shipper (Shipper_ID, Username, Password, Distribution_hub, Role) VALUES 
('3','escanor','222333','3','Shipper'),
('4','ronaldo','444444','4','Shipper');

INSERT INTO Vendor (Vendor_ID, Vendor_Name, Address, Latitude, Longitude, Username, Password, Role) VALUES 
('2','Nescafe','Dong Nai','10.9209998', '106.8741256', 'nescafe','111222','Vendor'),
('3','Heineken','Vung Tau','10.6473694', '107.0346042', 'heineken','222333','Vendor'),
('4','Coca-Cola','Thu Duc','10.8584064', '106.7838086', 'cocavn','333444','Vendor');

INSERT INTO Distribution_hub (Shipper_ID, Hub_ID, Hub_Name, Latitude, Longitude, Username) VALUES 
('3','3','TSN Airport','10.8184631', '106.6566305', 'tsnair'),
('4','4','Ben Xe Mien Dong','10.8146133', '106.7105605', 'benxe');

DROP USER IF EXISTS 'lazadavendor'@'localhost';
DROP USER IF EXISTS 'lazadacustomer'@'localhost';
DROP USER IF EXISTS 'lazadashipper'@'localhost';

CREATE USER 'lazadavendor'@'localhost' IDENTIFIED BY '';
CREATE USER 'lazadacustomer'@'localhost' IDENTIFIED BY '';
CREATE USER 'lazadashipper'@'localhost' IDENTIFIED BY '';

GRANT SELECT ON lazada.Customer TO 'signinnup'@'localhost';
GRANT INSERT ON lazada.Customer TO 'signinnup'@'localhost';
GRANT SELECT ON lazada.Vendor TO 'lazadavendor'@'localhost';
GRANT INSERT ON lazada.Vendor TO 'lazadavendor'@'localhost';
GRANT UPDATE ON lazada.Vendor TO 'lazadavendor'@'localhost';
GRANT SELECT ON lazada.Shipper TO 'lazadashipper'@'localhost';
GRANT ALL ON lazada.Customer TO 'lazadacustomer'@'localhost';