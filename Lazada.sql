CREATE DATABASE lazada;
USE lazada;

CREATE TABLE `Vendor` (
	`Vendor_ID` INT(11)AUTO_INCREMENT,
	`Vendor_Name` varchar(50) NOT NULL, 
	`Address` varchar(255),
	`Latitude` char(50),
	`Longitude` char(50),
	`Username` varchar(50) UNIQUE,
	`Password` varchar(50) NOT NULL,
    `Role` varchar(20) NOT NULL,
    Primary key (`Vendor_ID`)
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

INSERT INTO lazada.order (Order_ID, Product_Name, Price, Status, Customer_Name, Customer_Phone, Phone, Address) VALUES 
('1','8 can of Coke','150','Ready', 'Nghia', '0111111111','0111111111', 'rmitsgs'),
('2','8 can of beer','200','Shipped', 'Thang', '0111111112','0111111112', 'rmitsgs'),
('3','8 can of Milk','100','Cancelled', 'Khang', '	0111111113','0111111113', 'rmithn'),
('4','Mouse Pad','70','Shipped', 'Trump', '0211111111','0211111111', 'TDTU'),
('5','Keyboard','200','Ready', 'ANguyen', '0211111112','0211111112', '100 NTMK Dist 1'),
('6','15 can of beer','200','Cancelled', 'BTran', '0311111112','0311111112', 'nikko hotel'),
('7','20 can of beer','250','Ready', 'CLe', '0411111112','0411111112', 'saigon zoo'),
('8','30 can of beer','300','Shipped', 'DVu', '0511111112','0511111112', 'starbucks new world'),
('9','40 can of Milk','400','Cancelled', 'HHoang', '0611111113','0611111113', 'phuc long tran quang khai');

INSERT INTO Customer (Customer_ID, Customer_Name, Address, Latitude, Longitude, Username, Password, Role) VALUES 
('1','Thang','Ho Chi Minh','10.762621', '106.660172', 'Thangvo','abcxyz', 'Customer'),
('2','Nghia','RMIT SGS','10.7293107', '106.691477', 'NNghia','Nghia123','Customer'),
('3','Trump','New World Hotel','10.7710502', '106.6925586', 'DTrump','Trump111','Customer'),
('4','Khang','Nikko Saigon Hotel','10.7641288', '106.6807345', 'KhangN','Khang222','Customer'),
('5','Minh','Ho Chi Minh','10.762622', '106.660172', 'Minh','minh123', 'Customer');

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

GRANT SELECT ON lazada.Order TO 'signinnup'@'localhost';
GRANT SELECT ON lazada.Customer TO 'signinnup'@'localhost';
GRANT SELECT ON lazada.Vendor TO 'signinnup'@'localhost';
GRANT SELECT ON lazada.Shipper TO 'signinnup'@'localhost';
GRANT INSERT ON lazada.Customer TO 'signinnup'@'localhost';
GRANT INSERT ON lazada.Vendor TO 'signinnup'@'localhost';
GRANT INSERT ON lazada.Shipper TO 'signinnup'@'localhost';

GRANT ALL ON lazada.Customer TO 'lazadacustomer'@'localhost';
GRANT INSERT ON lazada.Order TO 'lazadacustomer'@'localhost';

GRANT ALL ON lazada.Vendor TO 'lazadavendor'@'localhost';

GRANT ALL ON lazada.Shipper TO 'lazadashipper'@'localhost';
GRANT SELECT ON lazada.Order TO 'lazadashipper'@'localhost';
GRANT UPDATE ON lazada.Order TO 'lazadashipper'@'localhost';

use lazada;
Select * From vendor;
select latitude from vendor where latitude limit 1;

-- DELIMITER $$
-- Create trigger vendor_after_insert
-- After update 
-- on vendor for each row
-- CREATE TRIGGER `add` AFTER INSERT ON `Vendor`
--  FOR EACH ROW UPDATE vendor
--     SET company_id = new.id
--     WHERE id = new.places_id

-- Begin
-- DECLARE vlatitude varchar(50);
-- select latitude from vendor where latitude limit 1;
-- INSERT INTO vendor_nearest_hub (Vendor_id, latitude) values (new.vendor_id, new.latitude);
-- End;
drop table if exists addressChanges;
drop trigger if exists after_address_update;
drop trigger if exists after_address_update;
drop trigger if exists after_customer_address_update;
create table  `addressChanges` (
	id INT auto_increment primary key,
    Vendor_ID INT(11),
    beforeLatitude char(50),
    afterLatitude char(50),
    beforeLongitude char(50),
	afterLongitude char(50)
) engine = InnoDB;

create table  `customer_addressChanges` (
                                   id INT auto_increment primary key,
                                   Customer_ID INT(11),
                                   beforeLatitude char(50),
                                   afterLatitude char(50),
                                   beforeLongitude char(50),
                                   afterLongitude char(50)
) engine = InnoDB;
Delimiter $$

Create trigger after_address_update
after update
on vendor for each row
begin
if old.Latitude <> new.Latitude OR old.Longitude <> new.Longitude then
insert into addressChanges (Vendor_ID, beforeLatitude, afterLatitude, beforeLongitude, afterLongitude)
values (old.Vendor_ID, old.Latitude, new.Latitude, old.Longitude, new.Longitude);
end if;
end;

update vendor
set Latitude = 16 , Longitude = 106.1
where Vendor_ID = 2;

select * from addressChanges;
select * from vendor;

Create trigger after_customer_address_update
after update
on customer for each row
begin
if old.Latitude <> new.Latitude OR old.Longitude <> new.Longitude then
insert into customer_addressChanges (Customer_ID, beforeLatitude, afterLatitude, beforeLongitude, afterLongitude)
values (old.Customer_ID, old.Latitude, new.Latitude, old.Longitude, new.Longitude);
end if;
end;
update customer
set Latitude = 16 , Longitude = 106.1
where Customer_ID = 2;

DELIMITER $$
-- Given the shipper_id and hub_id, find the order count
CREATE PROCEDURE order_in_stock(
   IN  p_Shipper_ID INT,
   IN  p_Hub_ID INT,
   OUT p_Order_count INT)
READS SQL DATA
BEGIN
   SELECT Order_ID
     FROM lazada.Order
     WHERE Shipper_ID = p_Shipper_ID
       AND Hub_ID = p_Hub_ID
       AND order_in_stock(Order_ID);
 
   SELECT COUNT(*) INTO p_Order_count;
END $$
DELIMITER ;

