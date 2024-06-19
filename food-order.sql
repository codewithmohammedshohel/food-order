-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 10:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food-order`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(251, 'Mohammed Shohel', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(252, 'Mehjabin Sultana', 'backend-admin', '4b53bf341cbb6ce8d6288714372bd181'),
(254, 'Aribah', 'web-admin', '0a0e966eee7b229f711ffd96296e4b1d');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `featured` varchar(10) DEFAULT NULL,
  `active` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(20, 'MOMO', 'Food_Category_995.png', 'Yes', 'Yes'),
(21, 'BURGER', 'Food_Category_647.jpg', 'Yes', 'Yes'),
(22, 'PIZZA', 'Food_Category_493.png', 'Yes', 'Yes'),
(25, 'PASTA', 'air fryer baked pasta - no boil baked pasta.png', 'Yes', 'Yes'),
(26, 'RICE-BASED DISHES', 'Food_Category_749.png', 'Yes', 'Yes'),
(27, 'DESSERT', 'TIRAMISU.png', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_food`
--

CREATE TABLE `tbl_food` (
  `id` int(10) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `category_id` int(10) NOT NULL,
  `featured` varchar(10) DEFAULT NULL,
  `active` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_food`
--

INSERT INTO `tbl_food` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(5, 'MOMO', 'Experience the authentic taste of our momos, delicately steamed to perfection. These Himalayan-style dumplings are filled with a savory mixture of finely seasoned meats or vegetables, wrapped in a thin, tender dough. Served with our special dipping sauce, each bite is a delightful burst of flavor and texture. Whether you choose chicken, beef, or veggie, our momos promise a satisfying and delicious journey to the heart of traditional Asian cuisine.', 9.03, 'Food_66718d83cc453.jpg', 20, 'Yes', 'Yes'),
(6, 'BURGER', 'Our burgers are a symphony of flavors, crafted with premium, juicy beef patties, and nestled in a soft, toasted bun. Each burger is topped with fresh, crisp lettuce, ripe tomatoes, and tangy pickles, all enhanced by our signature sauces. Whether you prefer classic cheese, bacon, or a gourmet twist, every bite promises a deliciously satisfying experience. Indulge in the perfect combination of savory, juicy, and crunchy in every bite.', 12.00, 'Food_6671876acc42d.jpg', 21, 'Yes', 'Yes'),
(7, 'PIZZA', 'Our pizzas are crafted with the finest ingredients, featuring hand-tossed dough, rich tomato sauce, and premium mozzarella cheese. Baked to perfection, each slice offers a harmonious blend of flavors, ensuring a delightful dining experience. Enjoy a variety of toppings to suit every taste, from classic Margherita to bold Pepperoni and beyond. Savor the taste of authentic, oven-baked goodness in every bite.', 12.00, 'Food_66718e1a09d7d.jpg', 22, 'Yes', 'Yes'),
(8, 'Classic Smashed Cheeseburger', 'Experience the irresistible flavor of our Classic Smashed Cheeseburger. This burger features a perfectly smashed beef patty, seared to crispy perfection, and topped with melted American cheese. Nestled in a soft, toasted bun and garnished with crisp lettuce, juicy tomato, tangy pickles, and our special house sauce, every bite offers a delightful blend of textures and tastes. This burger is a nostalgic nod to classic diner-style burgers, bringing you the ultimate comfort food experience.', 10.17, 'Food_6671919dd8f27.png', 21, 'Yes', 'Yes'),
(9, 'Cars Inspired BBQ Bacon Cowboy Burger', 'Enjoy the bold flavors of our Cowboy Burger. Featuring a juicy beef patty topped with crispy bacon, tangy BBQ sauce, and crunchy onion rings, this burger is a hearty and comforting delight. Perfect for a fun dinner and movie night, it’s an easy-to-make treat that brings the taste of your drive-thru favorite right to your home.', 13.00, 'Food_6671936fd79b5.png', 21, 'Yes', 'Yes'),
(10, 'Mushroom Swiss Smash Burgers with Truffle Sauce', 'Indulge in the gourmet flavors of our Mushroom Swiss Smash Burger with Truffle Sauce. This decadent burger features a perfectly smashed beef patty, topped with sautéed cremini mushrooms, melted Swiss cheese, and a luxurious homemade truffle mayonnaise. Served on a toasted Kaiser roll, every bite is a sophisticated blend of rich, earthy, and savory notes, making it the perfect choice for a refined burger experience. Ideal for those looking to elevate their burger game with a touch of elegance.', 15.00, 'Food_667196b68d4b6.png', 21, 'Yes', 'Yes'),
(11, 'New York Style Pepperoni Pizza', 'Experience the classic taste of New York with our New York Style Pepperoni Pizza. Inspired by Joe\\\'s, this pizza features an easy overnight dough that develops an incredible depth of flavor. Topped with fresh mozzarella, rich pizza sauce, and generous slices of pepperoni, each bite delivers a perfect balance of crispy crust and savory toppings. Ideal for a quick and delicious meal, this pizza is ready in just 36 minutes, making it the perfect choice for pizza lovers.', 14.00, 'Food_66719d6b54dd0.png', 22, 'Yes', 'Yes'),
(12, 'Slapilicious BBQ Chicken Pizza', 'Relive the nostalgia of family pizza parties with our Slapilicious BBQ Chicken Pizza. This delicious creation features a perfect blend of flavors, starting with a crispy crust and topped with tender, BBQ-rubbed chicken, our signature SYD BBQ Sauce, and melted mozzarella cheese. Finished with slices of red onion and a sprinkle of fresh cilantro, this pizza is baked to perfection, offering a sweet and tangy taste that will transport you back to simpler times. Try it today and experience why this pizza is a standout favorite!', 15.00, 'Food_66719ed8aae34.png', 22, 'Yes', 'Yes'),
(13, 'Veggie Supreme Pizza', 'A fresher, tastier take on your favorite veggie pizza. Topped with green bell pepper, red onion, mushrooms, tomato, and olives, all on a bed of no-cook marinara sauce and low-moisture mozzarella cheese. Customize with your choice of vegetables and cheeses.', 12.00, 'Food_66719fe412c7d.png', 22, 'Yes', 'Yes'),
(14, 'Vegetable Air-fried Momo Manchurian', 'A perfect fusion dish featuring crispy air-fried vegetable momos tossed in a hot and spicy vegetable gravy. Made with a mix of fresh veggies and flavorful sauces, this healthier alternative to fried momos is perfect for health-conscious food lovers. Enjoy the crunch and taste of traditional momos with a modern, air-fried twist.', 13.00, 'Food_6671a149677a9.png', 20, 'Yes', 'Yes'),
(15, 'TANDOORI MOMOS', 'Elevate your appetizer game with our Tandoori Momos. These classic dumplings are given a flavorful twist, coated in our signature tandoori paste and chargrilled to perfection. Served with a refreshing mint chutney and a spiced onion and carrot salad, these momos are bursting with vibrant colors and rich, smoky flavors. Perfect for any gathering, they are a delightful treat that will impress your guests. Dive into this delicious adventure and enjoy the irresistible taste of Tandoori Momos!', 15.00, 'Food_6671a5d496413.png', 20, 'Yes', 'Yes'),
(16, 'Chicken Chile Momo', 'Indulge in the exquisite taste of Chicken Chile Momo, a recipe courtesy of Calgary Momo House, that brings together the best of Nepali cuisine with a spicy twist. This intermediate-level dish takes a total of 2 hours and 20 minutes to prepare, including resting and cooling time, with 1 hour and 15 minutes of active cooking. Yielding six servings, it’s perfect for sharing with friends and family.', 14.07, 'Food_6671a6b81b32f.png', 20, 'Yes', 'Yes'),
(17, 'Air Fryer Baked Pasta', 'Enjoy the convenience of our Air Fryer Baked Pasta, a delicious one-pot meal that requires no boiling of pasta separately. This recipe simplifies your cooking process by combining raw fusilli pasta with a flavorful mix of red pasta sauce, vegetables, and seasonings, all cooked to perfection in your air fryer. Topped with melted mozzarella cheese and fresh basil, this dish promises a saucy, cheesy delight that\\\'s perfect for any meal. Whether you\\\'re looking for a quick lunch option or a hassle-free dinner idea, our Air Fryer Baked Pasta delivers on taste and convenience.', 10.00, 'Food_6671ac70019e1.png', 25, 'Yes', 'Yes'),
(18, 'Lemon Chicken Pasta', 'Savor the taste of Lemon Chicken Pasta, where the zest of lemon meets the creaminess of whole-milk ricotta! A perfect joining of flavors, this easy pasta recipe promises a delightful meal in just 30 minutes.', 11.00, 'Food_6671ade5b889b.png', 25, 'Yes', 'Yes'),
(19, 'Air Fryer Chicken Biryani', 'Delicious and fragrant biryani made with tender chicken and aromatic rice, cooked in an air fryer for a healthier version. This recipe combines basmati rice, chicken thighs, biryani masala powder, and a blend of spices like turmeric, cumin seeds, cinnamon, cardamom pods, cloves, and bay leaf. Garnished with chopped coriander leaves, it\\\'s a delightful dish ready in just 50 minutes.', 25.00, 'Food_6671b0a808f69.png', 26, 'Yes', 'Yes'),
(20, 'CHICKEN TIKKA BIRYANI', 'Spicy and flavorful Indian biryani made with marinated chicken thighs, basmati rice, and a blend of aromatic spices including turmeric, cumin seeds, cloves, cardamom, and bay leaf. This dish is cooked in layers to infuse flavors, topped with fresh coriander and mint leaves for a delightful finish.', 20.00, 'Food_6671b23282b67.png', 26, 'Yes', 'Yes'),
(21, 'Arroz Con Pollo', 'Arroz Con Pollo, meaning \\\"Rice with Chicken,\\\" is a traditional Latin American dish with roots likely stemming from Spanish Paella. This hearty one-pot meal combines crispy pan-fried chicken thighs and drumsticks with basmati rice, flavored with a homemade tomato puree and chicken stock. The dish is enriched with Gran Luchito Chipotle Paste and olive oil, adding smoky chipotle flavors to the chicken and a vibrant color to the rice. It\\\'s garnished with fresh coriander and served with lemon wedges for a zesty finish.', 30.00, 'Food_6671b344bace5.png', 26, 'Yes', 'Yes'),
(22, 'Thai Pineapple Fried Rice', 'Thai PineapEnjoy a delightful blend of sweet and spicy flavors in our Thai-style pineapple fried rice. This vegetarian dish features caramelized pineapple, red bell pepper, and crunchy cashews, tossed with aromatic jasmine rice and seasoned with tamari and chili garlic sauce. Garnished with fresh cilantro and served with lime wedges, it\\\'s a quick and healthy choice for any weeknight dinner.ple Fried Rice', 35.00, 'Food_6671b45c047cc.png', 26, 'Yes', 'Yes'),
(23, 'Tiramisu', 'Indulge in our delightful Tiramisu, a classic Italian dessert meaning \\\"pick me up,\\\" featuring espresso-soaked ladyfingers layered with a velvety mascarpone custard and dusted with cocoa powder. Perfectly balanced flavors of coffee and creamy sweetness in every bite. Ideal for any occasion, from casual gatherings to special celebrations.', 12.00, 'Food_6671b6582c574.png', 27, 'Yes', 'Yes'),
(24, 'Chocolate Molten Lava Cake', 'Indulge in the irresistible decadence of homemade chocolate molten lava cakes from Mel\\\'s Kitchen Cafe. These exquisite desserts are a delight to prepare and even more delightful to savor. Each cake boasts a light, airy chocolate exterior that conceals a rich, molten fudge center, creating a symphony of flavors and textures with every bite. Made with premium Ghirardelli bittersweet chocolate and a touch of vanilla, these cakes are baked to perfection in generously buttered ramekins, ensuring they release effortlessly onto your plate. Whether enjoyed plain, with a scoop of ice cream, or drizzled with hot fudge sauce, these lava cakes promise to be a memorable finale to any meal, perfect for both special occasions and spontaneous cravings alike.', 8.00, 'Food_6671ce79b1bc2.png', 27, 'Yes', 'Yes'),
(25, 'Strawberry Panna Cotta', 'Indulge in our Strawberry Panna Cotta, a creamy Italian dessert infused with vanilla and set with gelatine. \"Panna cotta,\" translating to \"cooked cream\" in Italian, offers a velvety texture that melts in your mouth. Topped with your choice of fresh berries or homemade strawberry coulis, this delightful treat offers a perfect balance of smooth creaminess and fruity sweetness. Ideal for any season, it\'s best enjoyed chilled after a minimum of 5 hours in the fridge.', 6.97, 'Food_6671cfa1c9cef.png', 27, 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) NOT NULL,
  `food` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(10) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `food`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`) VALUES
(3, 'Vegan Salad', 7.25, 1, 7.25, '2024-06-17 17:49:46', 'Delivered', 'Alice Brown', '1122334455', 'alice.brown@example.com', '789 Pine Lane, Village, Country'),
(4, 'memo 343', 500.00, 1, 500.00, '2024-06-17 17:49:46', 'Cancelled', 'Mohammed Shohel', '01676252572', 'e@y.com', 'sdfd'),
(5, 'memo 343', 500.00, 1, 500.00, '2024-06-17 17:49:46', 'Cancelled', 'Mohammed Shohel', '01676252572', 'e@y.com', 'sdfd'),
(6, 'memo 343', 500.00, 1, 500.00, '2024-06-17 17:49:46', 'Ordered', 'Mohammed Shohel', '01676252572', 'd@t.com', 'asfdsf'),
(7, 'Burger', 100.00, 1, 100.00, '2024-06-17 17:49:46', 'Delivered', 'Mohammed Shohel-99999999999', '01676252572', 'shohel.7@yahoo.com', 'oii'),
(8, 'memo 343', 500.00, 12, 6000.00, '2024-06-17 17:49:46', 'Delivered', 'abcdef', '01828989898', 'e@l.com', 'dhaka'),
(9, 'memo 343', 500.00, 1, 500.00, '2024-06-17 17:49:46', 'Delivered', 'efgh', '01787252525', 'd@l.com', 'hello'),
(10, 'memo 343', 500.00, 1, 500.00, '2024-06-17 17:49:46', 'Processing', 'zod', '01828989898', 'shohel.7@yahoo.com', 'md'),
(11, 'Burger', 100.00, 5, 300.00, '2024-06-17 17:49:46', 'Processing', 'MOFIZ', '01676252781', 'mafiz@mail.com', 'BOROPOLE'),
(12, 'Burger', 100.00, 1, 100.00, '2024-06-17 17:49:46', 'Ordered', 'Mohammed Shohel', '1676252572', 'shohel.7@yahoo.com', 'fsf'),
(13, 'Burger', 100.00, 1, 100.00, '2024-06-17 17:49:46', 'Delivered', 'Warisha ', '01781909090', 'warisha@mail.com', 'Rashid Bhaban, Flat#A1, infront of Lucky plaza, Badamtoli Mor, Agrabad, Ctg.'),
(14, 'Burger', 100.00, 1, 100.00, '2024-06-17 22:36:21', 'Delivered', 'Rashed', '01676252572', 'shafik@gmail.com', 'Shafik Store, Nimtola Mor, PC Road, Chattogram.'),
(15, 'Burger', 100.00, 1, 100.00, '2024-06-17 23:22:12', 'Delivered', 'Zinia', '01676252589', 'zinia@mail.com', 'Zinia Mansion (2nd Floor), Panir Kol, Halishahar Road, Chattogram.'),
(16, 'Burger', 100.00, 1, 100.00, '2024-06-17 23:30:34', 'Delivered', 'Arifa', '01676252572', 'shohel.7@yahoo.com', 'West Nasirabad, DT Road,  Pahartali, Chattogram.'),
(17, 'Burger', 100.00, 4, 400.00, '2024-06-18 00:17:42', 'Delivered', 'Aribah', '1676252572', 'shohel.7@yahoo.com', 'Boropole More, Halishahar, Chattogram.'),
(18, 'Burger', 100.00, 7, 700.00, '2024-06-18 00:25:57', 'Delivered', 'Mohammed Shohel', '01676252572', 'shohel.7@yahoo.com', 'West Nasirabad, DT Road,  Pahartali, Chattogram.'),
(19, 'Burger', 100.00, 1, 100.00, '2024-06-18 15:55:55', 'Delivered', 'KHALID ', '01818232323', 'khalil@mail.com', 'Noyabazar, Biswa Road, Ctg.'),
(20, 'Momo', 50.00, 5, 250.00, '2024-06-18 17:10:24', 'Delivered', 'Rahim', '01721212122', 'rahim@mail.com', 'Flat#23, House#3, Road#3, Lane#6, Block#B, Halishahar H/S, Chattogram'),
(21, 'Mushroom Swiss Smash Burgers with Truffle Sauce', 15.00, 2, 15.00, '2024-06-18 21:10:03', 'Cancelled', 'Nigar Sultana Nishat', '01968101068', 'megharalo7@gmail.com', 'Moinna Para, Boropole, Halishahar, Chattogram.'),
(22, 'Lemon Chicken Pasta', 11.00, 1, 11.00, '2024-06-19 03:01:18', 'Ordered', 'Osman', '01812232323', 'osma@mail.com', 'Abdul Latif Road, Halishahar Road, Ctg'),
(23, 'PIZZA', 12.00, 3, 36.00, '2024-06-19 03:05:08', 'Ordered', 'Abdur Razzak', '01823535353', 'abdurrazzak@mail.com', 'Boubazar, Halishahar Road, Ctg.'),
(24, 'Veggie Supreme Pizza', 12.00, 1, 12.00, '2024-06-19 03:08:32', 'Ordered', 'shohel', '1676252572', 'd@l.com', 'West Nasirabad, DT Road,  Pahartali, Chattogram.'),
(25, 'Veggie Supreme Pizza', 12.00, 1, 12.00, '2024-06-19 03:11:06', 'Ordered', 'Mohammed Shohel', '01828989898', 'e@y.com', 'West Nasirabad, DT Road,  Pahartali, Chattogram.'),
(26, 'Classic Smashed Cheeseburger', 10.17, 1, 10.17, '2024-06-19 03:20:43', 'Delivered', 'Mohammed Faruque', '01823232323', 'faruque@mail.com', 'DT Road, Ctg.'),
(27, 'Vegetable Air-fried Momo Manchurian', 13.00, 9, 117.00, '2024-06-19 03:47:16', 'Delivered', 'NISHAT', '01909090909', 'nigar@mail.com', 'City Gate, Chattogram.'),
(28, 'Air Fryer Chicken Biryani', 25.00, 1, 25.00, '2024-06-19 11:54:16', 'Delivered', 'Mohammed Shohel', '01676252572', 'D@M.COM', 'SFSDF'),
(29, 'Strawberry Panna Cotta', 6.97, 1, 6.97, '2024-06-19 12:07:03', 'Delivered', 'Sajid', '01892929292', 'sajid@example.com', 'Feni, Bangladesh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_food`
--
ALTER TABLE `tbl_food`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD CONSTRAINT `tbl_food_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
