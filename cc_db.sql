-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 03:59 PM
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
-- Database: `cc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Aid` varchar(35) NOT NULL,
  `Apass` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Aid`, `Apass`) VALUES
('admin@somaiya.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `Aid` int(11) NOT NULL,
  `Qid` int(11) NOT NULL,
  `Eid` varchar(35) NOT NULL,
  `Answer` text NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examans`
--

CREATE TABLE `examans` (
  `EAnsID` int(50) NOT NULL,
  `ExamID` int(10) NOT NULL,
  `Senrl` varchar(50) NOT NULL,
  `Sname` varchar(50) NOT NULL,
  `Ans1` mediumtext NOT NULL,
  `Ans2` mediumtext NOT NULL,
  `Ans3` mediumtext NOT NULL,
  `Ans4` mediumtext NOT NULL,
  `Ans5` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `examans`
--

INSERT INTO `examans` (`EAnsID`, `ExamID`, `Senrl`, `Sname`, `Ans1`, `Ans2`, `Ans3`, `Ans4`, `Ans5`) VALUES
(11, 4, '146891664', 'om metha', 'cs', 'cs', 'cs', 'cs', 'cs'),
(12, 4, '146891664', 'om metha', 'cs', 'cs', 'cs', 'cs', 'cs'),
(13, 4, '146891664', 'om metha', 'dc', 'cd', 'cd', 'dc', 'dcd'),
(14, 4, '146891664', 'om metha', 'dc', 'csd', 'dcds', 'dscs', 'dcds'),
(15, 4, '146891664', 'om metha', '2', '\r\n\r\n65', 'nn', 'jj', 'll'),
(16, 4, '146891665', 'om metha', '\r\n\r\n1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `examdetails`
--

CREATE TABLE `examdetails` (
  `ExamID` int(50) NOT NULL,
  `ExamName` varchar(50) NOT NULL,
  `Q1` varchar(10000) NOT NULL,
  `Q2` varchar(10000) NOT NULL,
  `Q3` varchar(10000) NOT NULL,
  `Q4` varchar(10000) NOT NULL,
  `Q5` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `examdetails`
--

INSERT INTO `examdetails` (`ExamID`, `ExamName`, `Q1`, `Q2`, `Q3`, `Q4`, `Q5`) VALUES
(4, 'HTML', 'What is the previous version of HTML, prior to HTML5?', ' What does HTML stand for?', 'Who is making the Web standards?', 'Choose the correct HTML element for the largest heading:', 'What is the correct HTML element for inserting a line break?'),
(5, ' PHP', ' What does PHP stand for?', 'PHP server scripts are surrounded by delimiters, which?', 'How do you write \"Hello World\" in PHP', ' All variables in PHP start with which symbol?', 'What is the correct way to end a PHP statement?'),
(6, 'SQL', 'What does SQL stand for?', 'Which SQL statement is used to extract data from a database?', 'Which SQL statement is used to update data in a database?', 'Which SQL statement is used to delete data from a database?', 'Which SQL statement is used to insert new data in a database?'),
(9, 'JavaScript', 'Inside which HTML element do we put the JavaScript?', 'What is the correct JavaScript syntax to change the content of the HTML element below?\r\n\r\n\r\n<p id=\"demo\">This is a demonstration.</p>', 'Where is the correct place to insert a JavaScript?', 'What is the correct syntax for referring to an external script called \"xxx.js\"?', 'The external JavaScript file must contain the <script> tag. True or False?'),
(10, 'Bootstrap ', 'Bootstrap 3 is mobile-first. False or  True?', 'Which class provides a responsive fixed width container?', ' Which class provides a full width container, spanning the entire width of the viewport?', 'The Bootstrap grid system is based on how many columns?', 'Which class adds zebra-stripes to a table?'),
(11, 'jQuery', ' jQuery uses CSS selectors to select elements?  True or False?', 'Which sign does jQuery use as a shortcut for jQuery?', 'Look at the following selector: $(\"div\"). What does it select?', 'Is jQuery a library for client scripting or server scripting?', 'Is it possible to use jQuery together with AJAX?');

-- --------------------------------------------------------

--
-- Table structure for table `facutlytable`
--

CREATE TABLE `facutlytable` (
  `FID` int(10) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `FaName` varchar(30) NOT NULL,
  `Addrs` text NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `JDate` date NOT NULL,
  `City` varchar(10) NOT NULL,
  `Pass` varchar(10) NOT NULL,
  `PhNo` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `facutlytable`
--

INSERT INTO `facutlytable` (`FID`, `FName`, `FaName`, `Addrs`, `Gender`, `JDate`, `City`, `Pass`, `PhNo`) VALUES
(101, 'NO NAME', 'NO NAME', 'add', 'male', '1999-02-03', 'mumbai', '1234', 12345678);

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `GuEid` varchar(35) NOT NULL,
  `Gname` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`GuEid`, `Gname`) VALUES
('g10093k@gmail.com', 'sacxa');

-- --------------------------------------------------------

--
-- Stand-in structure for view `leaderboard`
-- (See below for the actual view)
--
CREATE TABLE `leaderboard` (
`student_id` bigint(20)
,`student_name` varchar(61)
,`total_assessments` bigint(21)
,`latest_activity` date
);

-- --------------------------------------------------------

--
-- Table structure for table `query`
--

CREATE TABLE `query` (
  `Query` text NOT NULL,
  `Ans` text NOT NULL,
  `Eid` varchar(35) NOT NULL,
  `FacultyID` int(11) NOT NULL,
  `Qid` int(11) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `query`
--

INSERT INTO `query` (`Query`, `Ans`, `Eid`, `FacultyID`, `Qid`, `CreatedAt`) VALUES
('														b  ', 'cdnliw					b																', 'hello@CC.com', 1, 11, '2025-04-01 18:44:35'),
('							c ', '			c										', 'hello@CC.com', 1, 12, '2025-04-01 18:44:35'),
('Dear Sir,\r\nCan I do M.SC. ?\r\nPlease Answer Soon..\r\nThanks ', 'Yes, First you complete M.tech.							', 'harsh@cc.com', 1, 13, '2025-04-01 18:44:35'),
('bjgvjb', '', 'ommetha13@gmail.com', 1, 14, '2025-04-01 18:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `Qid` int(11) NOT NULL,
  `Question` text NOT NULL,
  `Eid` varchar(35) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `RsID` int(11) NOT NULL,
  `Eno` varchar(20) NOT NULL,
  `Ex_ID` int(10) NOT NULL,
  `Marks` int(11) NOT NULL,
  `EvaluationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`RsID`, `Eno`, `Ex_ID`, `Marks`, `EvaluationDate`) VALUES
(2387, '146891664', 4, 20, '2025-04-01 19:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `activity` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `year` varchar(10) NOT NULL,
  `division` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `faculty_id`, `day`, `start_time`, `end_time`, `activity`, `created_at`, `year`, `division`) VALUES
(4, 101, 'Wednesday', '16:11:00', '16:55:00', 'j', '2025-04-09 08:49:43', '', ''),
(6, 101, 'Monday', '10:40:00', '11:40:00', 'sdad', '2025-04-09 09:15:18', 'SY', 'A'),
(7, 101, 'Monday', '08:30:00', '09:30:00', 'data', '2025-04-09 09:17:13', 'SY', 'A'),
(8, 101, 'Tuesday', '08:07:00', '20:05:00', 'data', '2025-04-09 10:14:03', 'SY', 'A'),
(9, 101, 'Monday', '02:40:00', '11:40:00', 'SDA', '2025-04-09 10:14:33', 'SY', 'Array');

-- --------------------------------------------------------

--
-- Table structure for table `studenttable`
--

CREATE TABLE `studenttable` (
  `Eno` bigint(20) NOT NULL,
  `FName` varchar(30) NOT NULL,
  `LName` varchar(30) NOT NULL,
  `FaName` varchar(30) NOT NULL,
  `Addrs` text NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `Course` varchar(20) NOT NULL,
  `Year` varchar(2) NOT NULL,
  `Division` varchar(1) NOT NULL,
  `DOB` date NOT NULL,
  `PhNo` bigint(10) NOT NULL,
  `Pass` varchar(20) NOT NULL,
  `Eid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `studenttable`
--

INSERT INTO `studenttable` (`Eno`, `FName`, `LName`, `FaName`, `Addrs`, `Gender`, `Course`, `Year`, `Division`, `DOB`, `PhNo`, `Pass`, `Eid`) VALUES
(146891662, 'om', 'metha', 'anilkumer', 'address', 'Male', 'btech', '', '', '2025-03-10', 7058171554, 'ommetha@12', 'ommetha123@gmail.com'),
(146891664, 'om', 'metha', 'anilkumer', 'address', 'Male', 'btech', '', '', '2023-02-18', 7058171254, 'ommetha@!2', 'ommetha13@gmail.com'),
(146891665, 'om', 'metha', 'anilkumer', '202- first floor, sairaj complex,Chavdar Tale,Mahad-Raigad', 'Male', 'btech', 'SY', 'A', '2025-04-01', 7058171254, 'ommetha@!2', 'ommetha3@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `student_progress`
--

CREATE TABLE `student_progress` (
  `id` int(11) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `activity_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_progress`
--

INSERT INTO `student_progress` (`id`, `student_id`, `activity`, `activity_date`) VALUES
(5, 146891650, 'Test Entry', '2025-03-11'),
(10, 146891664, 'Assessment Completed: Sample Test', '2025-03-11'),
(11, 146891664, 'Assessment Completed: Sample Test', '2025-03-11'),
(12, 146891664, 'Assessment Completed: Sample Test', '2025-03-11'),
(13, 146891664, 'Assessment Completed: Sample Test', '2025-03-26'),
(14, 146891665, 'Assessment Completed: Sample Test', '2025-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `V_id` int(10) NOT NULL,
  `V_Title` varchar(50) NOT NULL,
  `V_Url` longtext NOT NULL,
  `V_Remarks` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='This table is used to store videos info.';

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`V_id`, `V_Title`, `V_Url`, `V_Remarks`) VALUES
(4, 'CSS Grid ', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/HgwCeNVPlo0?rel=0&amp;showinfo=0\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>', 'How to create website layouts using CSS grid'),
(5, 'JQuery', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/BWXggB-T1jQ\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>', 'JQuery Tutorial:\r\nQuery is a cross-platform JavaScript library designed to simplify the client-side scripting of HTML. It is free, open-source software using the permissive MIT License.'),
(6, 'JSON ', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/JuFdz8f-cT4\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>', 'JavaScript Object Notation or JSON is an open-standard file format that uses human-readable text to transmit data objects consisting of attributeâ€“value pairs and array data types (or any other serializable value).\r\nIt is a very common data format used for asynchronous browserâ€“server communication, including as a replacement for XML in some AJAX-style systems.\r\nJSON is a language-independent data format.\r\nIt was derived from JavaScript, ');

-- --------------------------------------------------------

--
-- Table structure for table `class_notes`
--

CREATE TABLE `class_notes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `faculty_id` INT(11) NOT NULL,
  `course` VARCHAR(50) NOT NULL,
  `year` VARCHAR(10) NOT NULL,
  `division` VARCHAR(10) NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `uploaded_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`faculty_id`) REFERENCES `facutlytable`(`FID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Example data insertion
-- INSERT INTO `class_notes` (`faculty_id`, `course`, `year`, `division`, `file_name`, `file_path`) VALUES
-- (101, 'B.Tech', 'SY', 'A', 'Lecture1.pdf', '/uploads/Lecture1.pdf');

-- --------------------------------------------------------

--
-- Table for classrooms
--
CREATE TABLE classrooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    unique_code VARCHAR(10) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (faculty_id) REFERENCES facutlytable(FID)
);

-- --------------------------------------------------------

--
-- Table for classroom members
--
CREATE TABLE classroom_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    classroom_id INT NOT NULL,
    student_id INT NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (classroom_id) REFERENCES classrooms(id),
    FOREIGN KEY (student_id) REFERENCES studenttable(Eno)
);

-- --------------------------------------------------------

--
-- Table for classroom materials
--
CREATE TABLE classroom_materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    classroom_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (classroom_id) REFERENCES classrooms(id)
);

-- --------------------------------------------------------

--
-- Table for classroom announcements
--
CREATE TABLE classroom_announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    classroom_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (classroom_id) REFERENCES classrooms(id)
);

-- --------------------------------------------------------

--
-- Structure for view `leaderboard`
--
DROP TABLE IF EXISTS `leaderboard`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `leaderboard`  AS SELECT `sp`.`student_id` AS `student_id`, concat(`st`.`FName`,' ',`st`.`LName`) AS `student_name`, count(`sp`.`activity`) AS `total_assessments`, max(`sp`.`activity_date`) AS `latest_activity` FROM (`student_progress` `sp` join `studenttable` `st` on(`sp`.`student_id` = `st`.`Eno`)) WHERE `sp`.`activity` like '%Assessment Completed%' GROUP BY `sp`.`student_id` ORDER BY count(`sp`.`activity`) DESC, max(`sp`.`activity_date`) DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Aid`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`Aid`),
  ADD KEY `Qid` (`Qid`);

--
-- Indexes for table `examans`
--
ALTER TABLE `examans`
  ADD PRIMARY KEY (`EAnsID`);

--
-- Indexes for table `examdetails`
--
ALTER TABLE `examdetails`
  ADD PRIMARY KEY (`ExamID`),
  ADD UNIQUE KEY `ExamName` (`ExamName`);

--
-- Indexes for table `facutlytable`
--
ALTER TABLE `facutlytable`
  ADD PRIMARY KEY (`FID`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`Gname`);

--
-- Indexes for table `query`
--
ALTER TABLE `query`
  ADD PRIMARY KEY (`Qid`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`Qid`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`RsID`),
  ADD KEY `idx_enrollment` (`Eno`),
  ADD KEY `idx_exam` (`Ex_ID`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studenttable`
--
ALTER TABLE `studenttable`
  ADD PRIMARY KEY (`Eno`),
  ADD KEY `idx_class` (`Year`,`Division`);

--
-- Indexes for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`V_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `Aid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examans`
--
ALTER TABLE `examans`
  MODIFY `EAnsID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `examdetails`
--
ALTER TABLE `examdetails`
  MODIFY `ExamID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `facutlytable`
--
ALTER TABLE `facutlytable`
  MODIFY `FID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `query`
--
ALTER TABLE `query`
  MODIFY `Qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `Qid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `RsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2388;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `studenttable`
--
ALTER TABLE `studenttable`
  MODIFY `Eno` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146891666;

--
-- AUTO_INCREMENT for table `student_progress`
--
ALTER TABLE `student_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `V_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`Qid`) REFERENCES `questions` (`Qid`);

--
-- Constraints for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD CONSTRAINT `student_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `studenttable` (`Eno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
