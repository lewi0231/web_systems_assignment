
drop database if exists ecommerce_db;

create database ecommerce_db;

use ecommerce_db;
 
create table product (id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(100) NOT NULL,
                        brand VARCHAR(50) NOT NULL,
                        description VARCHAR(200) NOT NULL,
                        image_path VARCHAR(100) NOT NULL DEFAULT 'images/default.jpg',
                        stock INT NOT NULL DEFAULT 50,
                        colour VARCHAR(25) NOT NULL,
                        size INT NOT NULL,
                        sex CHAR(1) NOT NULL,
                        price FLOAT(5,2) NOT NULL,
                        discount INT(3),
                        category VARCHAR(100) NOT NULL);

create table `address` (id INT AUTO_INCREMENT PRIMARY KEY,
                        street_address VARCHAR(200) NOT NULL,
                        suburb VARCHAR(100) NOT NULL,
                        state CHAR(3) NOT NULL,
                        postcode CHAR(4) NOT NULL);


create table `customer` (id INT AUTO_INCREMENT PRIMARY KEY,
                            username VARCHAR(100) NOT NULL,
                            password VARCHAR(100) NOT NULL,
                            pref_pay_method VARCHAR(100),
                            def_pay_details VARCHAR(100),
                            signup_date DATETIME NOT NULL DEFAULT now(),
                            shipping_id INT,
                            FOREIGN KEY (shipping_id) REFERENCES address(`id`) 
                            ON DELETE CASCADE);

create table `contact` (id INT AUTO_INCREMENT PRIMARY KEY,
                            first_name VARCHAR(100) NOT NULL,
                            last_name VARCHAR(100) NOT NULL,
                            email VARCHAR(100) NOT NULL,
                            phone VARCHAR(100) DEFAULT NULL,
                            customer_id INT,
                            FOREIGN KEY (customer_id) REFERENCES customer(`id`) 
                            ON DELETE CASCADE);


create table `order` (id INT AUTO_INCREMENT PRIMARY KEY,
                        total FLOAT(5,2) NOT NULL,
                        date DATETIME NOT NULL default now(),
                        status TINYINT(1) NOT NULL DEFAULT 1,
                        pay_method VARCHAR(100) NOT NULL,
                        pay_details VARCHAR(100),
                        shipping_id INT,
                        billing_id INT,
                        customer_id INT,
                        contact_id INT,
                        FOREIGN KEY (shipping_id) REFERENCES address(`id`)
                        ON DELETE CASCADE,
                        FOREIGN KEY (billing_id) REFERENCES address(`id`)
                        ON DELETE CASCADE,
                        FOREIGN KEY (customer_id) REFERENCES customer(`id`) 
                        ON DELETE CASCADE,
                        FOREIGN KEY (contact_id) REFERENCES contact(`id`) 
                        ON DELETE CASCADE);
 
create table order_details (id INT AUTO_INCREMENT PRIMARY KEY,
                            cost FLOAT(5,2) NOT NULL,
                            quantity INT NOT NULL default 1,
                            product_id INT NOT NULL,
                            order_id INT NOT NULL,
                            FOREIGN KEY (product_id) REFERENCES product (`id`) 
                            ON DELETE CASCADE,
                            FOREIGN KEY (order_id) REFERENCES `order`(`id`) 
                            ON DELETE CASCADE);


INSERT INTO product (name, brand, description, colour, size, sex, price, discount, category) VALUES %("Chuck 70", 'Converse', 'The Converse All Star Chuck '70 is a re-crafted sneaker that uses modern details to celebrate the original Chuck Taylor All Star from the 1970s. Vintage details include stitching on the sidewall and a heavier-grade canvas upper for comfort and durability.', 'Black', 10, 'U', 130.00, 0, 'High-Top');

insert into product(name, brand, description, colour, size, sex, price, category) values("PUMA", 'RETALIATE', 'molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium', 'Black', 8, 'M', 95.00,  'Running');

insert into `address`(street_address, suburb, state, postcode) values('40 Main St', 'Nairne', 'SA', '5244');
insert into `address`(street_address, suburb, state, postcode) values('5 Serenity Ave', 'Parkside', 'SA', '5144');

insert into customer (username, password, pref_pay_method, def_pay_details, shipping_id) values ("thedude", "password123", "GooglePay", "dudest@gmail.com", 1);

insert into contact(first_name, last_name, email, phone, customer_id) values('John', 'Malborough', 'john@hotmail.com', '77777777', 1);
insert into contact(first_name, last_name, email, phone) values('Bella', 'Graham', 'bella444@gmail.com', '77777777');

insert into `order`(total, pay_method, pay_details, shipping_id, billing_id, contact_id) values(79.90,  'Credit Card', '78367261762', (select id from address 
                                where street_address='5 Serenity Ave' AND
                                suburb='Parkside' AND state='SA' AND postcode='5144'),
                                (select id from address 
                                where street_address='40 Main St' AND
                                suburb='Nairne' AND state='SA' AND postcode='5244'),
                                (select id from contact where first_name='Bella'
                                AND last_name='Graham'));
insert into `order`(total,  pay_method, pay_details, shipping_id, billing_id, contact_id) values(174.90,  'GooglePay', 'john@hotmail.com', (select id from address 
                                where street_address='40 Main St' AND
                                suburb='Nairne' AND state='SA' AND postcode='5244'),
                                (select id from address 
                                where street_address='40 Main St' AND
                                suburb='Nairne' AND state='SA' AND postcode='5244'),
                                (select id from contact where first_name='John'
                                AND last_name='Malborough' AND email='john@hotmail.com'));

insert into order_details(cost, product_id, order_id) values((select price from product
                                where id=1), 1, 1);
insert into order_details(cost, product_id, order_id) values((select price from product
                                where id=1), 1, 2);
insert into order_details(cost, product_id, order_id) values((select price from product
                                where id=2), 1, 2);


