
drop database if exists ecommerce_db;

create database ecommerce_db;

use ecommerce_db;
 
create table product (id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(100) NOT NULL,
                        brand VARCHAR(50) NOT NULL,
                        description VARCHAR(500) NOT NULL,
                        filename VARCHAR(100) NOT NULL,
                        category VARCHAR(100) NOT NULL,
                        sex CHAR(1) NOT NULL,
                        price FLOAT(5,2) NOT NULL,
                        discount INT(3) DEFAULT 0                        
                        );
                        
create table product_details (id INT AUTO_INCREMENT PRIMARY KEY,
                        stock INT NOT NULL DEFAULT 50,
                        colour VARCHAR(25) NOT NULL,
                        size INT NOT NULL,
                        product_id INT NOT NULL,
                        FOREIGN KEY (product_id) REFERENCES product(`id`) 
                            ON DELETE CASCADE
                        );

create table `address` (id INT AUTO_INCREMENT PRIMARY KEY,
                        street_address VARCHAR(200) NOT NULL,
                        street_address_2 VARCHAR(200),
                        suburb VARCHAR(100) NOT NULL,
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
                        total FLOAT(11,2) NOT NULL,
                        delivery_cost FLOAT(11,2) NOT NULL,
                        date DATETIME NOT NULL default now(),
                        status TINYINT(1) NOT NULL DEFAULT 1,
                        credit_card_num VARCHAR(200) NOT NULL,
                        expiry VARCHAR(11) NOT NULL,
                        cvv int(4) NOT NULL,
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

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES ('Chuck 70', 'Converse', "The Converse All Star Chuck '70 is a re-crafted sneaker that uses modern details to celebrate the original Chuck Taylor All Star from the 1970s. Vintage details include stitching on the sidewall and a heavier-grade canvas upper for comfort and durability.",'Chuck 70.jpg', 'High-Top', 'U', 130.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) VALUES (2, 'Black', 10, (select id from product where name='Chuck 70'));

INSERT INTO product (name, brand, description, filename, category, sex, price) VALUES ("CONS One Star 70", 'Converse', "In 1974, Converse launched a low-cut, suede version of the Chuck Taylor All Star, featuring a single star logo on one side—the One Star sneaker. Reissued in the early '90s, the design gained traction with the skateboarding community thanks to a performance remodel. Today's One Star Pro provides better boardfeel and impact protection thanks to a CONS traction rubber outsole and molded CX sockliner. The low profile adds total flexibility, while a rubber-backed, suede upper keeps it durable",'CONS One Star.jpg', 'Sneakers', 'U', 130.00);

INSERT INTO product_details (stock, colour, size, product_id) VALUES (1,'Black', 8, (select id from product where name='CONS One Star 70'));

INSERT INTO product (name, brand, description, filename, category, sex, price) VALUES (
    "Run Star Hike", 
    'Converse', 
    "The laidback design of the iconic Chuck Taylor All Star High Top shoe gets a hiking-inspired twist in the Run Star Hike. A leather upper and  heel loop come together with the classic star ankle patch, while a foxing stripe draws attention to the lugged platform sole.",
    'Run Star Hike.jpg', 
    'Hiking', 'U', 150.00);

INSERT INTO product_details (stock, colour, size, product_id) 
                                    VALUES ( 2, 'Black', 11, (select id from product where name='Run Star Hike'));

INSERT INTO product_details (stock, colour, size, product_id) 
                                    VALUES ( 2, 'Black', 10, (select id from product where name='Run Star Hike'));

INSERT INTO product_details (stock, colour, size, product_id) 
                                    VALUES ( 2, 'Black', 9, (select id from product where name='Run Star Hike'));

INSERT INTO product (name, brand, description, filename, category, sex, price) VALUES (
    "All Star BB", 
    'Converse', 
    "For those who play like they're ready to take off running at any given moment, the All Star BB Jet emphasizes responsiveness.A mixed-material upper of synthetic suede and ripstop nylon allows for lightweight, breathable stability. Nike Zoom cushioning in the heel and forefoot make for reactive support, while an additional Converse Speed Plate in the forefoot helps you launch ahead with each step. Accented varsity colors bring flair to the traditional look.",
    'All Star BB.jpg', 
    'Sport', 'U', 150.00);

INSERT INTO product_details (stock, colour, size, product_id) 
                                    VALUES ( 3, 'Black', 7, (select id from product where name='All Star BB'));

INSERT INTO product (name, brand, description, filename, category, sex, price) VALUES (
    "Metcon 7", 
    'Nike', 
    "The Nike Metcon 7 is the gold standard for weight training—even tougher and more stable than previous versions. React foam ups the comfort to keep you ready for high-intensity cardio. Plus, a tab locks down your laces so you can forget about them coming untied when you're focused on your next training session.",
    'Metcon 7.jpg', 
    'Sport', 'U', 150.00);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  4, 'White',  9, (select id from product where name='Metcon 7') );

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  4, 'White',  10, (select id from product where name='Metcon 7') );


INSERT INTO product (name, brand, description, filename, category, sex, price) VALUES (
    "Kyrie 7", 
    'Nike', 
    "Kyrie Irving is a creative force on and off the court. He needs his shoes to keep up with his playmaking, but also sync with his boundary-pushing style and ethos. Tuned for the next generation of energy return, control and speed, the Kyrie 7 helps players at all levels take advantage of their quick first step by optimising the shoe's fit, court feel and banking ability.",
    'Kyrie 7.jpg', 
    'Sport', 'M', 190.00);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  4, 'Green',  12, (select id from product where name='Kyrie 7') );
INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  4, 'Green',  9, (select id from product where name='Kyrie 7') );

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Revolution 5", 
    'Nike', 
    "When the road beckons, answer the call in a lightweight pair that'll keep you moving mile after mile. Soft foam cushions your stride and a reinforced heel delivers a smooth, stable ride. Crafted from knit material for breathable support, while a minimalist design fits in just about anywhere your day takes you.",
    'Revolution 5.jpg', 
    'Running', 'F', 100.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  3, 'Black',  8, (select id from product where name='Revolution 5') );



INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Pegasus Trail 3", 
    'Nike', 
    "Find your wings with an off-road run.The Nike Pegasus Trail 3 has the same comfort you love, with a design that nods to the classic Pegasus look. Nike React foam delivers responsive cushioning while tough traction helps you stay moving through rocky terrain. More support around the midfoot helps you feel secure on your journey.",
    'Pegasus Trail 3.jpg', 
    'Hiking', 'F', 190.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  4, 'Purple',  7, (select id from product where name='Pegasus Trail 3') );
INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  4, 'Purple',  8, (select id from product where name='Pegasus Trail 3') );
INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  4, 'Purple',  9, (select id from product where name='Pegasus Trail 3') );


INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Blazer Mid 77", 
    'Nike', 
    "Styled for the '70s.Loved in the '80s. Classic in the '90s. Ready for the future. The Nike Blazer Mid '77 Next Nature now delivers a timeless design made from at least 20% recycled content by weight. Replaced leather upper, an environmentally intensive material, with an unbelievably crisp, partially recycled synthetic leather.",
    'Blazer Mid 77.jpg', 
    'High-Top', 'F', 140.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  1, 'Black',  9, (select id from product where name='Blazer Mid 77') );

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Judy", 
    'Vagabond', 
    "Platform sneakers Judy adds a muted statement to any look this season. The low-top silhouette is set on 40 mm contrast-coloured rubber cup soles. Designed with a minimalistic upper in smooth beige leather, the sneaker brings an effortless take on a classic style. Details include lace-up fastening and padded collars for great wearability.  ",
    'Judy.jpg', 
    'Sneakers', 'F', 175.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  3, 'Brown',  8, (select id from product where name='Judy') );

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Zoe Platform", 
    'Vagabond', 
    "These croc-embossed Zoe Platform sneakers give an updated look to a classic style. The low-top silhouette features hidden lace-up fastening and padded collars for great wearability. The upper is crafted from black croc-embossed leather and grounded by 40mm chunky platform soles.",
    'Zoe Platform.jpg', 
    'Sneakers', 'F', 175.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  1, 'Black',  7, (select id from product where name='Zoe Platform') );
INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  1, 'Black',  9, (select id from product where name='Zoe Platform') );

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Casey", 
    'Vagabond', 
    "Add a few extra inches to your height with iconic platform sneaker Casey. This sporty off-duty staple is bold and effortless all at the same time. The clean black textile upper is set on a white chunky outsole for a contrasting look",
    'Casey.jpg', 
    'Sneakers', 'F', 135.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  2, 'Black',  10, (select id from product where name='Casey') );

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Pacer Next", 
    'Puma', 
    "From sunrise to senset, the Pacer Next FS unisex shoes featuring mesh upper is touch of classic with modern. The SoftFoam+ sockliner delivers premium cushioning to keep your feet comfortable and fresh.",
    'Pacer Next.jpg', 
    'Sneakers', 'U', 85.00, 20);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  3, 'Blue',  10, (select id from product where name='Pacer Next') );

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Enzo", 
    'Puma', 
    "The Enzo Training Shoe brings running technology into a street-inspired style. This style's exaggerated collar height and clamshell construction offer a snug, yet comfortable fit, and its mesh upper brings a breathable feel in a sleek design. All the while, a TPU midfoot strap gives added support and aggressive looks. This training shoe is ready to take on every day.",
    'Enzo.jpg', 
    'Running', 'M', 95.00, 10);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  3, 'Red',  12, (select id from product where name='Enzo') );

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Smash Suede", 
    'Puma', 
    "Looking for an all-time tennis classic to wear every day? You've just found one. The PUMA Smash Suede is a tennis-inspired shoe that will keep you looking sporty and fresh. With the PUMA Formstrip, a soft full-suede upper and the classic tennis look, this trainer goes well with any style, any time.",
    'Smash Suede.jpg', 
    'Sneakers', 'U', 65.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  3, 'Grey',  11, (select id from product where name='Smash Suede') );


INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Janessa", 
    'Vagabond', 
    "Introducing new joggers Janessa with its clean silhouette and simple design. The sleek upper is combined with a slightly flared outsole for a streamlined shape. They are made from white textile with a tonal backpiece in synthetic leather. Details include front lace-up closure with silver-toned eyelets and padded collars for comfortable wear.",
    'Janessa.jpg', 
    'Sneakers', 'F', 145.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  3, 'White',  8, (select id from product where name='Janessa') );


INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Ocean Sparkle", 
    'Skechers', 
    "Introducing new joggers Janessa with its clean silhouette and simple design. The sleek upper is combined with a slightly flared outsole for a streamlined shape. They are made from white textile with a tonal backpiece in synthetic leather. Details include front lace-up closure with silver-toned eyelets and padded collars for comfortable wear.",
    'Ocean Sparkle.jpg', 
    'Sneakers', 'F', 80.00, 20);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  2, 'Black',  6, (select id from product where name='Ocean Sparkle') );


INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Coco Jazz", 
    'Skechers', 
    "Go the extra mile in long-lasting cushioned comfort with the Skechers GOwalk Stability - Coco Jazz shoe. This slip-on sneaker features a breathable athletic mesh upper with an Air-Cooled Goga Mat(TM) insole and lightweight ULTRA GO(R) cushioned midsole.",
    'Coco Jazz.jpg', 
    'Sneakers', 'F', 80.00, 20);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  3, 'Blue',  6, (select id from product where name='Coco Jazz') );

INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Evenston Fanton", 
    'Skechers', 
    "Add to your versatile looks with easy-wearing comfort in the SKECHERS Evenston - Fanton shoe. Smooth leather upper in a lace up sporty casual comfort sneaker oxford with perforation, stitching and overlay accents. Air Cooled Memory Foam insole, flexible comfort midsole.",
    'Evenston Fanton.jpg', 
    'Sneakers', 'M', 160.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  5, 'Black',  10, (select id from product where name='Evenston Fanton') );



INSERT INTO product (name, brand, description, filename, category, sex, price, discount) VALUES (
    "Gorun Elevate", 
    'Skechers', 
    "Surpass your personal best in comfort and style with Skechers GOrun Elevate™ cushioned midsole.",
    'Gorun Elevate.jpg', 
    'Sneakers', 'M', 120.00, 0);

INSERT INTO product_details (stock, colour, size, product_id) 
                                VALUES (  2, 'White',  9, (select id from product where name='Gorun Elevate') );




