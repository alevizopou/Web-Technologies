<?php
$db_server["host"] = "localhost"; //database server
$db_server["username"] = "root"; // DB username
$db_server["password"] = ""; // DB password
$db_server["database"] = "my_db"; // database name

/* Open a connection */
$link = mysql_connect($db_server["host"], $db_server["username"], $db_server["password"]);

/* Check connection */
if (!$link) {
    die('Failed to connect: ' . mysqli_connect_error());
}
echo "Connected successfully!" . "<br />";

/* Drop database my_db if already exists */
mysql_query("DROP DATABASE IF EXISTS my_db", $link);

/* Create database */
$sql = "CREATE DATABASE my_db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if (mysql_query($sql, $link)) {
	echo "Database created successfully." . "<br />";
} else {
	echo "Error creating database: " . mysqli_error($link) . "<br />";
}

//mysql_query("ENGINE=innoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci", $link);

/* Select a database to use */
if (!mysql_select_db($db_server["database"], $link)) {
	die("Couldn't select database");
}

mysql_query("SET NAMES 'utf8'", $link);
mysql_query("SET CHARACTER SET 'utf8'", $link);

/* Return name of current default database */
if ($result = mysql_query("SELECT DATABASE()", $link)) {
    $row = mysql_fetch_row($result);
    printf("Default database is %s." . "<br />", $row[0]);
    mysql_free_result($result);
}

/* Create table manager */
$sql = "CREATE TABLE manager(
username VARCHAR(20) NOT NULL,
password CHAR(128) NOT NULL,
PRIMARY KEY(username)
)ENGINE=innoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci";

/* Execute query */
if (mysql_query($sql, $link)) {
	echo "Table manager created successfully." . "<br />";
} else {
	echo "Error creating table: " . mysqli_error($link) . "<br />";
}

$sql = "INSERT INTO manager (username, password) 
	VALUES ('manager', 'manager')";
if (!mysql_query($sql, $link))
	die('Error: ' . mysql_error());
	
/* Create table waiter */
$sql = "CREATE TABLE waiter(
username VARCHAR(20) NOT NULL,
password CHAR(128) NOT NULL,
firstname VARCHAR(20) NOT NULL,
lastname VARCHAR(20) NOT NULL,
pic_url VARCHAR(200) NOT NULL,
unique key (pic_url),
PRIMARY KEY (username)
)ENGINE=innoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci";

/* Execute query */
if (mysql_query($sql, $link)) {
	echo "Table waiter created successfully." . "<br />";
} else {
	echo "Error creating table: " . mysqli_error($link) . "<br />";
}

$sql = "INSERT INTO waiter (username, password, firstname, lastname, pic_url) 
	VALUES ('afroditi', 'afro', 'Αφροδίτη', 'Αλεβιζοπούλου', 'images/afroditi.jpg')";
if (!mysql_query($sql, $link))
	die('Error: ' . mysql_error());
	
$sql = "INSERT INTO waiter (username, password, firstName, lastName, pic_url) 
	VALUES ('john', 'john', 'Ιωάννης', 'Παπαδόπουλος', 'images/john2.jpg')";
if (!mysql_query($sql, $link))
	die('Error: ' . mysql_error());
	
$sql = "INSERT INTO waiter (username, password, firstName, lastName, pic_url) 
	VALUES ('maria', 'maria', 'Μαρία', 'Δημητρίου', 'images/maria.jpg')";
if (!mysql_query($sql, $link))
	die('Error: ' . mysql_error());
	
/* Create table category */
$sql = "CREATE TABLE category(
category_id SMALLINT(3) AUTO_INCREMENT,
title VARCHAR(20) NOT NULL,
UNIQUE (category_id),
PRIMARY KEY (title)
)ENGINE=innoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci";

/* Execute query */
if (mysql_query($sql, $link)) {
	echo "Table category created successfully." . "<br />";
} else {
	echo "Error creating table: " . mysql_error($link) . "<br />";
}

$sql = "INSERT INTO category (title) VALUES
	('Ροφήματα'),
	('Αναψυκτικά'),
	('Χυμοί'),
	('Ποτά'),
	('Γλυκά'),
	('Σνακ')";

if (!mysql_query($sql, $link))
	die('Error: ' . mysql_error());

/* Create table product */
$sql = "CREATE TABLE product(
title VARCHAR(30) NOT NULL,
description VARCHAR(35),
price decimal(4,2) NOT NULL,
popularity INT(10) DEFAULT 0,
in_category VARCHAR(20) NOT NULL,
PRIMARY KEY (title),
CONSTRAINT PRDCTCAT
FOREIGN KEY (in_category) REFERENCES category(title)
ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=innoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci";

/* Execute query */
if (mysql_query($sql, $link)) {
	echo "Table product created successfully." . "<br />";
} else {
	echo "Error creating table: " . mysql_error($link) . "<br />";
}

$sql = "INSERT INTO product(title, description, price, in_category) VALUES 
	('Καφές', ' ', '1.5', 'Ροφήματα'),
	('Σοκολάτα', 'Σαντιγύ +0.3', '2', 'Αναψυκτικά'),
	('Τσάι', 'Μαύρο, Πράσινο', '1.5', 'Ροφήματα'),
	('Πορτοκαλάδα', ' ', '2', 'Αναψυκτικά'),
	('Λεμονάδα', ' ', '2', 'Χυμοί'),
	('Μπύρα', 'Weiss, Lager, Ale', '3', 'Ποτά'),
	('Τζιν', ' ', '4', 'Ποτά'),
	('Cheesecake', 'Φράουλα, Κεράσι', '2.5', 'Γλυκά'),
	('Σοκολατόπιτα', ' ', '2.5', 'Γλυκά'),
	('Τοστ', ' ', '2.5', 'Σνακ')";
if (!mysql_query($sql, $link))
	die('Error: ' . mysql_error());

/* Create table property */
$sql = "CREATE TABLE property(
name VARCHAR(40) NOT NULL,
into_category VARCHAR(20) NOT NULL,
product VARCHAR(30) NOT NULL,
extraPrice decimal(4,2),
PRIMARY KEY (name),
CONSTRAINT PROCAT
FOREIGN KEY (product) REFERENCES product(title)
ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=innoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci";

/* Execute query */
if (mysql_query($sql, $link)) {
	echo "Table property created successfully." . "<br />";
} else {
	echo "Error creating table: " . "<br />";
}

$sql = "INSERT INTO property(name, into_category, product, extraPrice) VALUES 
	('γλυκός', 'Ροφήματα', 'Καφές', '0'),
	('μέτριος', 'Ροφήματα', 'Καφές', '0'),
	('σκέτος', 'Ροφήματα', 'Καφές', '0'),
	('με ζαχαρίνη', 'Ροφήματα', 'Καφές', '0'),
	('φουντούκι', 'Ροφήματα', 'Καφές', '0'),
	('καραμέλα', 'Ροφήματα', 'Καφές', '0'),
	('ρούμι', 'Ροφήματα', 'Καφές', '0.5'),
	('μέλι', 'Ροφήματα', 'Τσάι', '0.5'),
	('λεμόνι', 'Ροφήματα', 'Τσάι', '0'),
	('χωρίς ανθρακικό', 'Αναψυκτικά', 'Πορτοκαλάδα', '0'),
	('σαντιγύ', 'Ροφήματα', 'Σοκολάτα', '0.3'),
	('πικρή', 'Ποτά', 'Μπύρα', '0'),
	('κόκκινη', 'Ποτά', 'Μπύρα', '0'),
	('φρέσκια', 'Ποτά', 'Μπύρα', '0'),
	('πατατάκια', 'Σνακ', 'Τοστ', '0.5'),
	('σόδα', 'Ποτά', 'Τζιν', '0.5'),
	('κεράσι', 'Γλυκά', 'Cheesecake', '0'),
	('φράουλα', 'Γλυκά', 'Cheesecake', '0')";
if (!mysql_query($sql, $link))
	die('Error: ' . mysql_error());

/* Create table orders */
$sql = "CREATE TABLE orders(
order_id int(100) NOT NULL AUTO_INCREMENT,
id int(100),
waiter_name VARCHAR(20) NOT NULL, 
the_date DATE,
price decimal(4,2),
num_items int(50),
PRIMARY KEY (order_id)
)ENGINE=innoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci";

/* Execute query */
if (mysql_query($sql, $link)) {
	echo "Table orders created successfully." . "<br />";
} else {
	echo "Error creating table: " . mysql_error($link) . "<br />";
}

/* Create table item_in_orders */
$sql = "CREATE TABLE item_in_order(
id int(100) auto_increment,
order_id int(100),
waiter_name VARCHAR(20) NOT NULL,
product_name VARCHAR(20) NOT NULL, 
property_name varchar(20),
order_date DATE,
PRIMARY KEY (id)
)ENGINE=innoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci";

/* Execute query */
if (mysql_query($sql, $link)) {
	echo "Table item_in_order created successfully." . "<br />";
} else {
	echo "Error creating table: " . mysql_error($link) . "<br />";
}

/* Close connection */
mysql_close($link);
?>
