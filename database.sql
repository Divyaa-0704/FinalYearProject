-- Zoo Management System Deployment Database Schema & Seed Data
-- Compatible with MySQL 5.7+ / 8.0+ / MariaDB / Cloud MySQL (TiDB / Aiven / RDS)

SET FOREIGN_KEY_CHECKS = 0;

-- 1. National Parks Table
CREATE TABLE IF NOT EXISTS `nationalparks` (
    `park_id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `location` VARCHAR(255),
    `area` FLOAT,
    `animal_count` INT DEFAULT 0,
    `daily_finances` DECIMAL(10, 2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `nationalparks` (`park_id`, `name`, `location`, `area`, `animal_count`, `daily_finances`) VALUES 
(1, 'Kanha National Park', 'Madhya Pradesh, India', 22190, 250, 12500.75),
(2, 'Aranya National Park', 'Karnataka, India', 18500, 190, 10200.50)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- 2. Users Table (Super User, Admin, Employee, Visitor)
CREATE TABLE IF NOT EXISTS `users` (
    `User_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100) NOT NULL,
    `Role` ENUM('Super User', 'Admin', 'Employee', 'Visitor') NOT NULL,
    `Contact_Info` VARCHAR(255),
    `Username` VARCHAR(50) UNIQUE NOT NULL,
    `Password` VARCHAR(255) NOT NULL,
    `Park_ID` INT DEFAULT 1,
    `Position` VARCHAR(50),
    `Hire_Date` DATE,
    `Salary` DECIMAL(10, 2),
    `Email` VARCHAR(100) UNIQUE,
    `Phone` VARCHAR(15),
    FOREIGN KEY (`Park_ID`) REFERENCES `nationalparks`(`park_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`User_ID`, `Name`, `Role`, `Contact_Info`, `Username`, `Password`, `Park_ID`, `Position`, `Hire_Date`, `Salary`, `Email`, `Phone`) VALUES  
(1, 'Divya', 'Super User', '9234567890', 'Divya', '$2y$10$sMZ0jf85/3bIiqXFlDoTxOf8tVKbQ28AXmJa8bD95l8qJiYUVyEya', 1, 'Super User', NULL, NULL, 'divya07@gmail.com', '9916935156'), 
(2, 'Trupthi', 'Super User', '9874567891', 'Trupthi', '$2y$10$.ugS3ybn2GbvHtfo72YyXeFG3COX0TcPBCYLRvV6uni9pQcNWDecO', 1, 'Super User', NULL, NULL, 'trupthi12@gmail.com', '7019223327'),
(3, 'DishaD', 'Admin', '9904567890', 'Dishad', '$2y$10$UA8yCP1qvhJRDZfHLUrA1ummwXnPL5qqbG.GjPbAG2QTYX2ogmpum', 1, 'Admin', '2020-01-12', 100000.00, 'dishad@gmail.com', '9075678901'), 
(4, 'DishaA', 'Admin', '9114567891', 'Dishaa', '$2y$10$kUCKob.FESn7AS5yBTF.YuuUlvEYlMsp8AqkSTmBF1P97oFgXc1lO', 2, 'Admin', '2020-05-14', 100000.00, 'dishaa@gmail.com', '9975678901'),
(5, 'Narmadha', 'Employee', '9875678901', 'Narmadha', '$2y$10$7sDNMEf4qFZVkO.j1ZnijeviYER6Y7uP6AQX7bgTqkCXijOxI3YXq', 1, 'Veterinarian', '2022-03-15', 60000.00, 'narmadha@gmail.com', '9875678901'),
(6, 'Bhandavya', 'Employee', '9345678902', 'Bhandavya', '$2y$10$JXOB4B8ZgnhB8b1eOkgz4OShwnrgeW.CzzwsjLs1HoiCTztmZ86L6', 1, 'Park Ranger', '2021-06-10', 45000.00, 'bhandavya@gmail.com', '9345678902'),
(7, 'Ashmitha', 'Employee', '9875678903', 'Ashmitha', '$2y$10$ZGoGvyJg0ByQdEnroIPtteQ3qkWxLCpTmvH6WJfTOjMDcpn1AlFxe', 1, 'Manager', '2020-01-20', 70000.00, 'ashmitha@gmail.com', '9875678903'),
(8, 'Kruthi', 'Employee', '9002678904', 'Kruthi', '$2y$10$Cq81DvZ1nMkBS9Ra7elCdeNzhjdl/3kzal/cdT7eFNFk0nIqSTbES', 1, 'Security Officer', '2023-09-05', 40000.00, 'kruthi@gmail.com', '9002678904'),
(9, 'Diya', 'Employee', '9125678905', 'Diya', '$2y$10$be2fReVJn/1AGGZgYaWaEuzH4VxSdC8j8vi40NSQRUbElTAIf.RNi', 1, 'Researcher', '2021-11-25', 50000.00, 'diya@gmail.com', '9125678905'),
(10, 'Samreen', 'Employee', '9345678901', 'Samreen', '$2y$10$xKmsYpL/mXGF31I.FliUhODzcTvfqrXg7d1DlE6crJU3hS2J5RzzO', 2, 'Veterinarian', '2022-03-15', 60000.00, 'samreen@gmail.com', '9345678901'),
(11, 'Anisha', 'Employee', '9565678902', 'Anisha', '$2y$10$Gu7oRc.WbgCAQfsrUx1W1OlUJs0aJV/98aEyZI27CtApV1XufUG7K', 2, 'Park Ranger', '2021-06-10', 45000.00, 'anisha@gmail.com', '9565678902'),
(12, 'Shabnam', 'Employee', '9095678903', 'Shabnam', '$2y$10$3XYM1oEfVbClho6a57dLw.xkoB8DVA1fO/s1cDsu0Rp//3XBXlzP2', 2, 'Manager', '2020-01-20', 70000.00, 'shabnam@gmail.com', '9095678903')
ON DUPLICATE KEY UPDATE `Name` = VALUES(`Name`);

-- 3. Visitors Table
CREATE TABLE IF NOT EXISTS `visitors` (
    `visitor_id` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100),
    `Email` VARCHAR(100) UNIQUE,
    `Phone` VARCHAR(15),
    `Username` VARCHAR(50) UNIQUE NOT NULL,
    `Password` VARCHAR(255) NOT NULL,
    `park_id` INT DEFAULT 1,
    `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `visitors` (`visitor_id`, `Name`, `Email`, `Phone`, `Username`, `Password`, `park_id`) VALUES
(1, 'Sanju', 'sanju@gmail.com', '9876543201', 'sanju', '$2y$10$l7mq20zM2kMsXHxWZ0XZLelctZh08GNmyuhGwfbk9.T0YcgIpGj3i', 1),
(2, 'Divi', 'kiko@gmail.com', '9876543202', 'Kiko', '$2y$10$NLofX5kpzzLhZ/GQm27LvuzzQrx9wr4Gwj1VDhOgPlfmg9dYny.N2', 1),
(3, 'Kookie', 'jk@gmail.com', '9876543203', 'kookie', '$2y$10$FpFZ8Wznhqqk2M2m.rX7MOGM.9wDfg80H3.pbwamO0FeNrv8b9Tra', 2)
ON DUPLICATE KEY UPDATE `Username` = VALUES(`Username`);

-- 4. Animals Table
CREATE TABLE IF NOT EXISTS `animals` (
    `Animal_ID` INT PRIMARY KEY,
    `Species` VARCHAR(50) NOT NULL,
    `Name` VARCHAR(50),
    `Age` INT,
    `Status` ENUM('Present', 'Rescued', 'Deceased') DEFAULT 'Present',
    `Health_Condition` ENUM('Good', 'Critical', 'Recovering') DEFAULT 'Good',
    `Park_ID` INT DEFAULT 1,
    `Adopter_Name` VARCHAR(100),
    `Adopter_Phone` VARCHAR(15),
    `Adopter_Email` VARCHAR(100),
    `Description` TEXT,
    `animal_type` VARCHAR(50) DEFAULT 'Mammal',
    `category` VARCHAR(50) DEFAULT 'Carnivore',
    FOREIGN KEY (`Park_ID`) REFERENCES `nationalparks`(`park_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `animals` (`Animal_ID`, `Species`, `Name`, `Age`, `Status`, `Health_Condition`, `Park_ID`, `animal_type`, `category`, `Description`) VALUES
(1, 'Tiger', 'Raja', 10, 'Present', 'Good', 1, 'Mammal', 'Carnivore', 'Raja, the fearless tiger, rules the jungle with his majestic stripes.'),
(2, 'Elephant', 'Kavi', 30, 'Rescued', 'Recovering', 1, 'Mammal', 'Herbivore', 'Kavi, the gentle giant, loves splashing in the water.'),
(3, 'Leopard', 'Milo', 6, 'Present', 'Good', 1, 'Mammal', 'Carnivore', 'Milo, the sneaky leopard, moves like a shadow.'),
(4, 'Deer', 'Dear', 3, 'Present', 'Good', 1, 'Mammal', 'Herbivore', 'Dear, the elegant deer, dashes through the forest.'),
(5, 'Bear', 'Luna', 7, 'Deceased', 'Critical', 1, 'Mammal', 'Omnivore', 'Luna, the cuddly bear, enjoys honey and relaxation.'),
(6, 'Lion', 'Simba', 8, 'Present', 'Good', 1, 'Mammal', 'Carnivore', 'Simba, the mighty lion, roars loud enough to shake the savanna.'),
(7, 'Giraffe', 'Gigi', 12, 'Present', 'Good', 1, 'Mammal', 'Herbivore', 'Gigi, the long-necked beauty, reaches the tastiest leaves.'),
(8, 'Zebra', 'Stripe', 6, 'Present', 'Good', 1, 'Mammal', 'Herbivore', 'Stripe, the stylish zebra, stands out with black-and-white fashion.'),
(9, 'Kangaroo', 'Joey', 5, 'Present', 'Good', 1, 'Mammal', 'Herbivore', 'Joey, the bouncy kangaroo, hops all day with joy.'),
(10, 'Panda', 'Po', 4, 'Present', 'Good', 1, 'Mammal', 'Herbivore', 'Po, the bamboo-loving panda, masters the art of relaxation.'),
(11, 'Cheetah', 'Dash', 7, 'Present', 'Good', 1, 'Mammal', 'Carnivore', 'Dash, the speedster cheetah, outruns any sports car.'),
(12, 'Wolf', 'Fang', 9, 'Present', 'Good', 1, 'Mammal', 'Carnivore', 'Fang, the howling wolf, leads the pack.'),
(13, 'Rhino', 'Rocky', 15, 'Present', 'Recovering', 1, 'Mammal', 'Herbivore', 'Rocky, the tough rhino, is a big softie inside.'),
(14, 'Hippopotamus', 'Hippo', 20, 'Present', 'Good', 1, 'Mammal', 'Herbivore', 'Hippo, the water-loving giant, spends days in the pool.'),
(15, 'Crocodile', 'Snap', 25, 'Present', 'Good', 1, 'Reptile', 'Carnivore', 'Snap, the sun-basking reptile of the river banks.'),
(16, 'Gorilla', 'Kong', 18, 'Present', 'Good', 1, 'Mammal', 'Herbivore', 'Kong, the intelligent primate leader.'),
(17, 'Penguin', 'Pingu', 3, 'Present', 'Good', 1, 'Bird', 'Carnivore', 'Pingu, the joyful swimmer of the chilly enclosure.'),
(18, 'Ostrich', 'Speedy', 10, 'Present', 'Good', 1, 'Bird', 'Omnivore', 'Speedy, the tallest bird with high running speeds.'),
(19, 'Tortoise', 'Shelly', 100, 'Present', 'Good', 1, 'Reptile', 'Herbivore', 'Shelly, the century-old gentle giant.'),
(20, 'Peacock', 'Blue', 5, 'Present', 'Good', 1, 'Bird', 'Omnivore', 'Blue, the proud national bird with majestic feathers.'),
(21, 'Koala', 'Cuddles', 7, 'Present', 'Good', 2, 'Mammal', 'Herbivore', 'Cuddles, the sleepy eucalyptus connoisseur.'),
(22, 'Jaguar', 'Shadow', 8, 'Present', 'Good', 2, 'Mammal', 'Carnivore', 'Shadow, the silent rainforest stalker.'),
(23, 'Hyena', 'Laughy', 6, 'Present', 'Good', 2, 'Mammal', 'Carnivore', 'Laughy, the clever and vocal scavenger.'),
(24, 'Eagle', 'Sky', 12, 'Present', 'Good', 2, 'Bird', 'Carnivore', 'Sky, the sharp-eyed king of the air.'),
(25, 'Flamingo', 'Rosy', 6, 'Present', 'Good', 2, 'Bird', 'Omnivore', 'Rosy, the elegant pink wader.')
ON DUPLICATE KEY UPDATE `Name` = VALUES(`Name`);

-- 5. Employee Tasks Table
CREATE TABLE IF NOT EXISTS `employeetasks` (
    `Task_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `Employee_ID` INT,
    `Task` VARCHAR(100) NOT NULL,
    `Time_Slot` ENUM('Morning', 'Evening') NOT NULL,
    FOREIGN KEY (`Employee_ID`) REFERENCES `users`(`User_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `employeetasks` (`Employee_ID`, `Task`, `Time_Slot`) VALUES
(5, 'Feed animals', 'Morning'),
(5, 'Walk animals', 'Evening'),
(6, 'Clean enclosures', 'Morning'),
(6, 'Monitor animal health', 'Evening'),
(7, 'Assist in rescue operations', 'Morning')
ON DUPLICATE KEY UPDATE `Task` = VALUES(`Task`);

-- 6. Rescue Operations Table
CREATE TABLE IF NOT EXISTS `rescueoperations` (
    `Rescue_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `Date` DATE NOT NULL,
    `Animal_ID` INT,
    `Description` TEXT,
    `Status` ENUM('Ongoing', 'Resolved') NOT NULL,
    FOREIGN KEY (`Animal_ID`) REFERENCES `animals`(`Animal_ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rescueoperations` (`Date`, `Animal_ID`, `Description`, `Status`) VALUES
('2024-11-20', 2, 'Rescued from a flood-affected area', 'Ongoing'),
('2024-11-18', 5, 'Medical treatment for injury', 'Resolved'),
('2024-11-10', 4, 'Found stranded in a village', 'Resolved'),
('2024-11-15', 3, 'Captured after wandering into farmland', 'Ongoing'),
('2024-11-12', 1, 'Relocated from an urban area', 'Resolved')
ON DUPLICATE KEY UPDATE `Status` = VALUES(`Status`);

-- 7. Donations Table
CREATE TABLE IF NOT EXISTS `donations` (
    `Donation_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `Donor_Name` VARCHAR(100) NOT NULL,
    `Amount` FLOAT NOT NULL,
    `Date` DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `donations` (`Donor_Name`, `Amount`, `Date`) VALUES
('Green Conservation Society', 5000.0, '2024-11-20'),
('Wildlife Fund', 10000.0, '2024-11-21'),
('Local NGO', 2500.0, '2024-11-22'),
('Anonymous', 3000.0, '2024-11-23'),
('Wildlife Enthusiasts Group', 7000.0, '2024-11-24')
ON DUPLICATE KEY UPDATE `Amount` = VALUES(`Amount`);

-- 8. Expenses Table
CREATE TABLE IF NOT EXISTS `expenses` (
    `expense_id` INT AUTO_INCREMENT PRIMARY KEY,
    `park_id` INT DEFAULT 1,
    `category` VARCHAR(100),
    `amount` DECIMAL(10, 2),
    `date` DATE,
    `description` TEXT,
    FOREIGN KEY (`park_id`) REFERENCES `nationalparks`(`park_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `expenses` (`park_id`, `category`, `amount`, `date`, `description`) VALUES
(1, 'Maintenance', 2500.00, '2024-01-10', 'Trail repairs'),
(1, 'Animal Care', 1800.00, '2024-02-15', 'Veterinary supplies'),
(1, 'Employee Salaries', 3000.00, '2024-03-01', 'Monthly payroll'),
(1, 'Equipment', 1500.00, '2024-04-20', 'Security cameras installation'),
(1, 'Events', 1200.00, '2024-05-30', 'Annual park festival expenses'),
(2, 'Maintenance', 2100.00, '2024-01-15', 'Perimeter fence repairs'),
(2, 'Animal Care', 1600.00, '2024-02-20', 'Routine checkup medicines')
ON DUPLICATE KEY UPDATE `amount` = VALUES(`amount`);

-- 9. Maintenance Table
CREATE TABLE IF NOT EXISTS `maintenance` (
    `maintenance_id` INT AUTO_INCREMENT PRIMARY KEY,
    `park_id` INT DEFAULT 1,
    `maintenance_type` VARCHAR(100),
    `cost` DECIMAL(10, 2),
    `date` DATE,
    `description` TEXT,
    FOREIGN KEY (`park_id`) REFERENCES `nationalparks`(`park_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `maintenance` (`park_id`, `maintenance_type`, `cost`, `date`, `description`) VALUES
(1, 'Trail Repair', 2000.00, '2024-01-05', 'Repaired walking trails damaged by rain.'), 
(1, 'Fence Repair', 1500.00, '2024-02-10', 'Fixed broken fences around the park.'),
(1, 'Shelter Maintenance', 2500.00, '2024-03-15', 'Reinforced animal shelters.'),
(1, 'Pond Cleaning', 1000.00, '2024-04-20', 'Cleaned algae from the pond.'),
(1, 'Parking Lot Repair', 1800.00, '2024-05-25', 'Repaired potholes in the parking lot.'),
(2, 'Solar Light Repair', 1200.00, '2024-01-12', 'Replaced inverter batteries.')
ON DUPLICATE KEY UPDATE `cost` = VALUES(`cost`);

-- 10. Park Events Table
CREATE TABLE IF NOT EXISTS `parkevents` (
    `event_id` INT AUTO_INCREMENT PRIMARY KEY,
    `park_id` INT DEFAULT 1,
    `event_name` VARCHAR(100),
    `event_date` DATE,
    `budget` DECIMAL(10, 2),
    `description` TEXT,
    FOREIGN KEY (`park_id`) REFERENCES `nationalparks`(`park_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `parkevents` (`park_id`, `event_name`, `event_date`, `budget`, `description`) VALUES
(1, 'Wildlife Awareness Day', '2024-03-10', 5000.00, 'A day to promote awareness about wildlife.'),
(1, 'Annual Safari Run', '2024-04-15', 7000.00, 'Marathon through the park to raise funds.'),
(1, 'Eco-Friendly Workshop', '2024-05-20', 3000.00, 'Workshops on sustainability practices.'),
(1, 'Photography Contest', '2024-06-10', 4000.00, 'Photo contest showcasing park wildlife.'),
(1, 'Kids Adventure Day', '2024-07-05', 2000.00, 'Fun-filled activities for children.')
ON DUPLICATE KEY UPDATE `budget` = VALUES(`budget`);

-- 11. Suppliers Table
CREATE TABLE IF NOT EXISTS `suppliers` (
    `supplier_id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `contact_email` VARCHAR(100) UNIQUE NOT NULL,
    `contact_phone` VARCHAR(15),
    `address` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `suppliers` (`name`, `contact_email`, `contact_phone`, `address`) VALUES
('Wildlife Supplies Inc.', 'contact@wildlifesupplies.com', '9234567890', '123 Wildlife Lane, Forest City'),
('EcoPartners', 'sales@ecopartners.com', '9876543210', '456 Green Street, Nature Town'),
('Nature Gear Co.', 'info@naturegear.com', '9551234567', '789 Adventure Ave, Parkland City')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- 12. Procurement Table
CREATE TABLE IF NOT EXISTS `procurement` (
    `procurement_id` INT AUTO_INCREMENT PRIMARY KEY,
    `park_id` INT DEFAULT 1,
    `supplier_id` INT,
    `item_name` VARCHAR(100) NOT NULL,
    `quantity` INT,
    `cost` DECIMAL(10, 2),
    `procurement_date` DATE,
    FOREIGN KEY (`park_id`) REFERENCES `nationalparks`(`park_id`) ON DELETE CASCADE,
    FOREIGN KEY (`supplier_id`) REFERENCES `suppliers`(`supplier_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `procurement` (`park_id`, `supplier_id`, `item_name`, `quantity`, `cost`, `procurement_date`) VALUES
(1, 1, 'Veterinary Supplies', 50, 1200.00, '2024-11-01'),
(1, 2, 'Eco-Friendly Bins', 200, 3000.00, '2024-11-05'),
(1, 3, 'Camping Equipment', 100, 5000.00, '2024-11-10')
ON DUPLICATE KEY UPDATE `cost` = VALUES(`cost`);

-- 13. Bookings Table (Safari)
CREATE TABLE IF NOT EXISTS `bookings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `package` VARCHAR(50) NOT NULL,
    `tickets` INT NOT NULL,
    `datetime` DATETIME NOT NULL,
    `park_id` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bookings` (`name`, `email`, `phone`, `package`, `tickets`, `datetime`, `park_id`) VALUES
('Aditi Sharma', 'aditi@example.com', '9876543210', 'giraffe', 2, '2025-01-15 10:00:00', 1),
('Rahul Verma', 'rahul@example.com', '9876543211', 'safari', 4, '2025-01-16 09:30:00', 1),
('Pooja Patel', 'pooja@example.com', '9876543212', 'bird', 1, '2025-01-17 14:00:00', 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- 14. Hotel Bookings Table
CREATE TABLE IF NOT EXISTS `hotel_bookings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `package_name` VARCHAR(100) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone_number` VARCHAR(20) NOT NULL,
    `num_tickets` INT NOT NULL,
    `booking_datetime` DATETIME NOT NULL,
    `park_id` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 15. Adopt Bookings Table
CREATE TABLE IF NOT EXISTS `adopt_booking` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `animal` VARCHAR(100) NOT NULL,
    `adoption_date` DATETIME NOT NULL,
    `park_id` INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 16. Contact Us Inquiries Table
CREATE TABLE IF NOT EXISTS `contact_us` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `message` TEXT NOT NULL,
    `park_id` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `contact_us` (`name`, `email`, `message`, `park_id`) VALUES
('Kiran Rao', 'kiran@gmail.com', 'What are the visiting hours during public holidays?', 1),
('Sunil Kumar', 'sunil@gmail.com', 'Are wheelchair facilities available at Kanha?', 1),
('Anita Roy', 'anita@gmail.com', 'Interested in school group bookings.', 2)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

SET FOREIGN_KEY_CHECKS = 1;
