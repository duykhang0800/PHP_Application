CREATE DATABASE lazada;
USE lazada;

CREATE TABLE `Vendor` (
	`Vendor_ID` char(10) UNIQUE,
	`Vendor_Name` varchar(50) NOT NULL, 
	`Address` varchar(255),
	`Latitude` char(50),
	`Longitude` char(50),
	`Username` varchar(50) UNIQUE,
	`Password` varchar(50) NOT NULL,
    `Role` varchar(20) NOT NULL,
	PRIMARY KEY (`Vendor_ID`)
) ENGINE=InnoDB;

alter table Vendor add unique Vendor_unique_Latitude_Longitude(Latitude, Longitude);

CREATE TABLE `Customer` (
	`Customer_ID` char(10) UNIQUE,  
	`Customer_Name` varchar(100),
	`Address` varchar(255),
	`Latitude` char(50),
	`Longitude` char(50), 
	`Username` varchar(50) UNIQUE,
	`Password` varchar(50) NOT NULL,
    `Role` varchar(20) NOT NULL,
	PRIMARY KEY (`Customer_ID`)
) ENGINE=InnoDB;

CREATE TABLE `Shipper` (
	`Shipper_ID` char(10) UNIQUE,
	`Username` varchar(50),
	`Password` varchar(50),
    `Distribution_hub` varchar (50),
    `Role` varchar(20) NOT NULL,
	PRIMARY KEY (`Shipper_ID`)
) ENGINE=InnoDB;
    
Create TABLE `Distribution_hub` (
	`Shipper_ID` char(10) UNIQUE,
	`Hub_ID` char(10) UNIQUE,
	`Hub_Name` varchar(50),
	`Latitude` char(50),
	`Longitude` char(50),
	`Username` varchar(50) UNIQUE,
     Primary key (`Hub_ID`),
     Foreign key ( `Shipper_ID`) REFERENCES `Shipper` (`Shipper_ID`)
) ENGINE = InnoDB;

alter table Distribution_hub add unique Distribution_hub_unique_Latitude_Longitude(Latitude, Longitude);

Create table `Order`(
	`Order_ID` char(10) unique,
    `Product_name` varchar (50),
    `Price` varchar (50),
    `Status` varchar(10),
    `Customer_Name` varchar(100) NOT NULL,
    `Customer_Phone` varchar(100) NOT NULL,
    `Phone` varchar(100) NOT NULL,
    `Address`varchar(100) NOT NULL,
	Primary key (`Order_ID`)
) ENGINE = InnoDB;

INSERT INTO Customer (Customer_ID, Customer_Name, Address, Latitude, Longitude, Username, Password, Role) VALUES 
('1','Thang', '0123456789','Ho Chi Minh','10.762621', '106.660172', 'Thangvo','abcxyz', 'Customer'),
('2','Nghia','RMIT SGS','10.7293107', '106.691477', 'NNghia','Nghia123','Customer'),
('3','Trump','New World Hotel','10.7710502', '106.6925586', 'DTrump','Trump111','Customer'),
('4','Khang','Nikko Saigon Hotel','10.7641288', '106.6807345', 'KhangN','Khang222','Customer'),
('5','Minh', '987654321','Ho Chi Minh','10.762622', '106.660172', 'Minh','minh123', 'Customer');

INSERT INTO Shipper (Shipper_ID, Username, Password, Distribution_hub, Role) VALUES 
('1','ship1','abcxyz','1st','Shipper'),
('2','ship2','123456','2nd','Shipper'),
('3','escanor','222333','3','Shipper'),
('4','ronaldo','444444','4','Shipper'),
('5','ship5','ship789','5th','Shipper');

INSERT INTO Vendor (Vendor_ID, Vendor_Name, Address, Latitude, Longitude, Username, Password, Role) VALUES 
('1','Vinamilk','Ho Chi Minh','10.762623', '106.660172', 'Vinamilk','123456', 'Vendor'),
('2','Nescafe','Dong Nai','10.9209998', '106.8741256', 'nescafe','111222','Vendor'),
('3','Heineken','Vung Tau','10.6473694', '107.0346042', 'heineken','222333','Vendor'),
('4','Coca-Cola','Thu Duc','10.8584064', '106.7838086', 'cocavn','333444','Vendor'),
('5','AFC','Ho Chi Minh','10.762625', '106.660178', 'afc123','123456', 'Vendor');


INSERT INTO Distribution_hub (Shipper_ID, Hub_ID, Hub_Name, Latitude, Longitude, Username) VALUES 
('1','1','Ben Xe Mien Tay','10.762628', '106.660174', 'benxemientay'),
('2','2','2nd','10.762629', '106.660172', 'second'),
('3','3','TSN Airport','10.8184631', '106.6566305', 'tsnair'),
('4','4','Ben Xe Mien Dong','10.8146133', '106.7105605', 'benxe'),
('5','5','5th','10.762621', '106.660172', 'fifth');

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

