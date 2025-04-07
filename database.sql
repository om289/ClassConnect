-- Table: `facutlytable`
CREATE TABLE `facutlytable` (
    `FID` INT AUTO_INCREMENT PRIMARY KEY,
    `FName` VARCHAR(255),
    `FaName` VARCHAR(255),
    `Addrs` TEXT,
    `Gender` VARCHAR(10),
    `City` VARCHAR(100),
    `Pass` VARCHAR(255),
    `PhNo` VARCHAR(15),
    `JoiningDate` DATE,
    `Email` VARCHAR(255) UNIQUE
);

INSERT INTO `facutlytable` (`FName`, `FaName`, `Addrs`, `Gender`, `City`, `Pass`, `PhNo`, `JoiningDate`, `Email`) 
VALUES ('John Doe', 'Michael Doe', '123 Street Name', 'Male', 'New York', 'password123', '1234567890', '2025-01-01', 'johndoe@example.com');

INSERT INTO `facutlytable` (`FName`, `FaName`, `Addrs`, `Gender`, `City`, `Pass`, `PhNo`, `JoiningDate`, `Email`) 
VALUES ('Jane Smith', 'Robert Smith', '456 Avenue Name', 'Female', 'Los Angeles', 'password456', '0987654321', '2025-02-01', 'janesmith@example.com');

-- Table: `studenttable`
CREATE TABLE `studenttable` (
    `RollNumber` INT PRIMARY KEY,
    `FName` VARCHAR(255),
    `LName` VARCHAR(255),
    `FaName` VARCHAR(255),
    `Addrs` TEXT,
    `Gender` VARCHAR(10),
    `Course` VARCHAR(100),
    `DOB` DATE,
    `PhNo` VARCHAR(15),
    `Email` VARCHAR(255) UNIQUE,
    `Pass` VARCHAR(255)
);

INSERT INTO `studenttable` (`RollNumber`, `FName`, `LName`, `FaName`, `Addrs`, `Gender`, `Course`, `DOB`, `PhNo`, `Email`, `Pass`) 
VALUES (101, 'Nikunj', 'Maru', 'Hemant Maru', 'Main St', 'Male', 'Computer Engineering', '2000-04-26', '1231231234', 'nikunjmaru996@gmail.com', 'password123');

INSERT INTO `studenttable` (`RollNumber`, `FName`, `LName`, `FaName`, `Addrs`, `Gender`, `Course`, `DOB`, `PhNo`, `Email`, `Pass`) 
VALUES (102, 'Bob', 'Williams', 'David Williams', '101 Highway Name', 'Male', 'Mathematics', '1999-08-20', '3213214321', 'bobwilliams@example.com', 'password456');

-- Table: `examdetails`
CREATE TABLE `examdetails` (
    `ExamID` INT AUTO_INCREMENT PRIMARY KEY,
    `ExamName` VARCHAR(255),
    `Q1` TEXT,
    `Q2` TEXT,
    `Q3` TEXT,
    `Q4` TEXT,
    `Q5` TEXT
);

INSERT INTO `examdetails` (`ExamName`, `Q1`, `Q2`, `Q3`, `Q4`, `Q5`) 
VALUES ('Math Test', 'What is 2+2?', 'What is 5*5?', 'What is 10/2?', 'What is 7-3?', 'What is 9+1?');

INSERT INTO `examdetails` (`ExamName`, `Q1`, `Q2`, `Q3`, `Q4`, `Q5`) 
VALUES ('Science Test', 'What is H2O?', 'What is the speed of light?', 'What is gravity?', 'What is photosynthesis?', 'What is DNA?');

-- Table: `result`
CREATE TABLE `result` (
    `RsID` INT AUTO_INCREMENT PRIMARY KEY,
    `RollNumber` INT,
    `Ex_ID` INT,
    `Marks` INT,
    `Status` VARCHAR(10),
    FOREIGN KEY (`RollNumber`) REFERENCES `studenttable`(`RollNumber`),
    FOREIGN KEY (`Ex_ID`) REFERENCES `examdetails`(`ExamID`)
);

-- Sample data for `result`
INSERT INTO `result` (`RollNumber`, `Ex_ID`, `Marks`, `Status`) 
VALUES (101, 1, 85, 'Pass');

INSERT INTO `result` (`RollNumber`, `Ex_ID`, `Marks`, `Status`) 
VALUES (102, 2, 40, 'Fail');

-- Table: `query`
CREATE TABLE `query` (
    `Qid` INT AUTO_INCREMENT PRIMARY KEY,
    `RollNumber` INT,
    `Query` TEXT,
    `Ans` TEXT,
    FOREIGN KEY (`RollNumber`) REFERENCES `studenttable`(`RollNumber`)
);

INSERT INTO `query` (`RollNumber`, `Query`, `Ans`) 
VALUES (101, 'What is the syllabus for the Math Test?', 'Refer to the course material.');

INSERT INTO `query` (`RollNumber`, `Query`, `Ans`) 
VALUES (102, 'When is the Science Test scheduled?', 'It is scheduled for next Monday.');

-- Table: `video`
CREATE TABLE `video` (
    `ID` INT AUTO_INCREMENT PRIMARY KEY,
    `VideoTitle` VARCHAR(255),
    `VideoURL` TEXT,
    `Description` TEXT
);

INSERT INTO `video` (`VideoTitle`, `VideoURL`, `Description`) 
VALUES ('Introduction to Algebra', 'https://example.com/algebra', 'A basic introduction to algebra.');

INSERT INTO `video` (`VideoTitle`, `VideoURL`, `Description`) 
VALUES ('Physics Basics', 'https://example.com/physics', 'An overview of basic physics concepts.');

-- Table: `student_progress`
CREATE TABLE `student_progress` (
    `ProgressID` INT AUTO_INCREMENT PRIMARY KEY,
    `RollNumber` INT,
    `activity` TEXT,
    `activity_date` DATE,
    FOREIGN KEY (`RollNumber`) REFERENCES `studenttable`(`RollNumber`)
);

INSERT INTO `student_progress` (`RollNumber`, `activity`, `activity_date`) 
VALUES (101, 'Completed Math Test', '2025-04-01');

INSERT INTO `student_progress` (`RollNumber`, `activity`, `activity_date`) 
VALUES (102, 'Watched Physics Basics Video', '2025-04-03');

-- Table: `leaderboard`
CREATE TABLE `leaderboard` (
    `LeaderboardID` INT AUTO_INCREMENT PRIMARY KEY,
    `student_name` VARCHAR(255),
    `total_assessments` INT,
    `latest_activity` DATE
);

INSERT INTO `leaderboard` (`student_name`, `total_assessments`, `latest_activity`) 
VALUES ('Nikunj Maru', 5, '2025-04-01');

INSERT INTO `leaderboard` (`student_name`, `total_assessments`, `latest_activity`) 
VALUES ('Bob Williams', 3, '2025-04-03');

-- Table: `examans`
CREATE TABLE `examans` (
    `AnsID` INT AUTO_INCREMENT PRIMARY KEY,
    `RollNumber` INT,
    `ExamID` INT,
    `Answer` TEXT,
    `MarksObtained` INT,
    FOREIGN KEY (`RollNumber`) REFERENCES `studenttable`(`RollNumber`),
    FOREIGN KEY (`ExamID`) REFERENCES `examdetails`(`ExamID`)
);

-- Sample data for `examans`
INSERT INTO `examans` (`RollNumber`, `ExamID`, `Answer`, `MarksObtained`) 
VALUES (101, 1, 'Answer to Q1, Q2, Q3...', 85);

INSERT INTO `examans` (`RollNumber`, `ExamID`, `Answer`, `MarksObtained`) 
VALUES (102, 2, 'Answer to Q1, Q2, Q3...', 90);