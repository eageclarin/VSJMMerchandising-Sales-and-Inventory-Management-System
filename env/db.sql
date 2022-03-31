CREATE DATABASE IF NOT EXISTS VSJM;


CREATE TABLE item  (
item_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
item_Name varchar(75) NOT NULL,
item_unit varchar(50) NOT NULL,
item_Brand varchar(50) NOT NULL 
);



CREATE TABLE supplier (
supplier_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
supplier_Name varchar(75) NOT NULL,
supplier_ContactPerson varchar(75) NOT NULL,
supplier_ContactNum varchar(11) NOT NULL,
supplier_Address varchar(100) NOT NULL
); 


CREATE TABLE supplier_Transactions(
transaction_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
supplier_ID int NOT NULL,
transaction_Date datetime NOT NULL,
transaction_Status TINYINT,
transaction_TotalPrice float(53) NOT NULL,
FOREIGN KEY(supplier_ID) REFERENCES supplier(supplier_ID) ON UPDATE CASCADE
);


CREATE TABLE supplier_item(
	supplier_ID int NOT NULL,
	item_ID int NOT NULL,
	supplierItem_CostPrice int NOT NULL,
PRIMARY KEY(supplier_ID, item_ID)
FOREIGN KEY (supplier_ID) REFERENCES supplier(supplier_ID) ON UPDATE CASCADE,
FOREIGN KEY (item_ID) REFERENCES item(item_ID) ON UPDATE CASCADE
);


CREATE TABLE transaction_items(
	transaction_ID int NOT NULL , 
	item_ID int NOT NULL,
	transactionItems_Quantity int NOT NULL,
	transactionItems_CostPrice float(53) NOT NULL,
transactionItems_TotalPrice float(53) NOT NULL,
PRIMARY KEY(transaction_ID,item_ID),
FOREIGN KEY (transaction_ID) REFERENCES supplier_Transactions(transaction_ID) ON UPDATE CASCADE,
FOREIGN KEY (item_ID) REFERENCES item(item_ID) ON UPDATE CASCADE
);


CREATE TABLE branch(
	branch_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
branch_Name varchar(75) NOT NULL,
branch_Address varchar(100) NOT NULL
);


CREATE TABLE inventory (
	branch_ID int NOT NULL,
	item_ID int NOT NULL,
	item_Stock int NOT NULL,
	item_RetailPrice float(53) NOT NULL,
	item_category varchar(50) NOT NULL,
	Item_markup float(53) NOT NULL,
	in_pending TINYINT,
	PRIMARY KEY (branch_ID,item_ID),
	FOREIGN KEY(branch_ID) REFERENCES branch(branch_ID) ON UPDATE CASCADE,
	FOREIGN KEY(item_ID) REFERENCES item(item_ID) ON UPDATE CASCADE
);


CREATE TABLE orders(
order_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
order_Date datetime NOT NULL,
order_Total float(53) NOT NULL
);


CREATE TABLE order_items(
	item_ID int NOT NULL,
order_ID int NOT NULL PRIMARY KEY,
orderItems_Quantity int NOT NULL,
orderItems_TotalPrice float(53) NOT NULL,
FOREIGN KEY(item_ID) REFERENCES item(item_ID) ON UPDATE CASCADE,
FOREIGN KEY(order_ID) REFERENCES orders(order_ID) ON UPDATE CASCADE
);

CREATE TABLE cart (
	cart_ID int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	itemID int(11) NOT NULL,
	itemName varchar(100) NOT NULL,
	itemPrice varchar(50) NOT NULL,
	quantity varchar(10) NOT NULL,
	itemTotalP varchar(100) NOT NULL
);

INSERT INTO branch (
	branch_Name, branch_Address
) VALUES (
	'VICAS', ' Block 6 Lot 1 Congressional Road, Raibow Village 5 Bagumbong Caloocan'
);


INSERT INTO `item` ( `item_Name`, `item_unit`, `item_Brand`) 
VALUES 	('item-01', 'pc', 'brand-01'), 
	( 'item-02', 'pc', 'brand-02'),
	('item-03', 'bot', 'brand-02'), 
	( 'item-04', 'pack', 'brand-01'),
	('item-05', 'kg', 'brand-02'), 
	( 'item-06', 'bot', 'brand-03'),
	('item-07', 'can', 'brand-02'), 
	( 'item-08', 'can', 'brand-02'),
	('item-09', 'doz', 'brand-03'), 
	( 'item-10', 'roll', 'brand-03');

INSERT INTO `inventory` ( `branch_ID`, `item_ID`, `item_Stock`, `item_RetailPrice`, `item_category`, `item_markup`, `in_pending`) 
VALUES	(1,1,5,25,'Tools',1.28,0),
	(1,2,4,30,"Architectural",1.5,0),
	(1,3,10,20,"Electrical",1.2,0),
	(1,5,100,10,'Bolts',1.15,0),
	(1,8,12,1,"Architectural",0.5,0),
	(1,10,20,200,'Plumbing',3,0);

INSERT INTO `supplier` (`supplier_ID`, `supplier_Name`, `supplier_ContactPerson`, `supplier_ContactNum`, `supplier_Address`) VALUES (NULL, 'supplier-01', 'contact-01', '0123456789`', 'address-01'), (NULL, 'supplier-02', 'contact-02', '0123456789', 'address-02'), (NULL, 'supplier-03', 'contact-03', '0123456789', 'address-03');


INSERT INTO `supplier_item` ( `Supplier_ID`, `item_ID`, `supplierItem_CostPrice`) 
VALUES	(1,1,3),
		(1,2,4),
		(1,3,12),
		(1,4,3),
		(2,5,9),
		(2,6,8),
		(2,7,3),
		(3,8,25),
		(3,9,3),
		(3,10,3),
		(2,1,5),
		(2,2,3),
		(2,3,10),
		(1,9,15),
		(1,10,10);
