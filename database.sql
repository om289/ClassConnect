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
    `Year` VARCHAR(20) NOT NULL,
    `Division` VARCHAR(10) NOT NULL,
    `DOB` DATE,
    `PhNo` VARCHAR(15),
    `Email` VARCHAR(255) UNIQUE,
    `Pass` VARCHAR(255),
    UNIQUE KEY unique_rollnumber_course_year (RollNumber, Course, Year)
);

INSERT INTO `studenttable` (`RollNumber`, `FName`, `LName`, `FaName`, `Addrs`, `Gender`, `Course`, `Year`, `Division`, `DOB`, `PhNo`, `Email`, `Pass`) 
VALUES (101, 'Nikunj', 'Maru', 'Hemant Maru', 'Main St', 'Male', 'Computer Engineering', 'First Year', 'A', '2000-04-26', '1231231234', 'nikunjmaru996@gmail.com', 'password123');

INSERT INTO `studenttable` (`RollNumber`, `FName`, `LName`, `FaName`, `Addrs`, `Gender`, `Course`, `Year`, `Division`, `DOB`, `PhNo`, `Email`, `Pass`) 
VALUES (102, 'Bob', 'Williams', 'David Williams', '101 Highway Name', 'Male', 'Mathematics', 'Second Year', 'B', '1999-08-20', '3213214321', 'bobwilliams@example.com', 'password456');

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
    `FacultyAssignedMarks` INT DEFAULT NULL,
    FOREIGN KEY (`RollNumber`) REFERENCES `studenttable`(`RollNumber`),
    FOREIGN KEY (`Ex_ID`) REFERENCES `examdetails`(`ExamID`)
);

-- Sample data for `result`
INSERT INTO `result` (`RollNumber`, `Ex_ID`, `Marks`, `Status`, `FacultyAssignedMarks`) 
VALUES (101, 1, 85, 'Pass', NULL);

INSERT INTO `result` (`RollNumber`, `Ex_ID`, `Marks`, `Status`, `FacultyAssignedMarks`) 
VALUES (102, 2, 40, 'Fail', NULL);

-- Table: `query`
CREATE TABLE `query` (
    `Qid` INT AUTO_INCREMENT PRIMARY KEY,
    `RollNumber` INT,
    `Query` TEXT,
    `Ans` TEXT,
    `FacultyID` INT NOT NULL,
    `StudentID` INT NOT NULL,
    `StudentName` VARCHAR(255) NOT NULL,
    `Answer` TEXT DEFAULT NULL,
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
    `Description` TEXT,
    `Course` VARCHAR(100) NOT NULL,
    `Year` VARCHAR(20) NOT NULL
);

INSERT INTO `video` (`VideoTitle`, `VideoURL`, `Description`, `Course`, `Year`) 
VALUES ('Introduction to Algebra', 'https://example.com/algebra', 'A basic introduction to algebra.', 'Mathematics', 'First Year');

INSERT INTO `video` (`VideoTitle`, `VideoURL`, `Description`, `Course`, `Year`) 
VALUES ('Physics Basics', 'https://example.com/physics', 'An overview of basic physics concepts.', 'Physics', 'Second Year');

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

-- Table: `mcq_questions`
CREATE TABLE `mcq_questions` (
    `QuestionID` INT AUTO_INCREMENT PRIMARY KEY,
    `ExamID` INT,
    `Question` TEXT,
    `OptionA` TEXT,
    `OptionB` TEXT,
    `OptionC` TEXT,
    `OptionD` TEXT,
    `CorrectOption` CHAR(1),
    FOREIGN KEY (`ExamID`) REFERENCES `examdetails`(`ExamID`)
);

-- Table: `mcq_results`
CREATE TABLE `mcq_results` (
    `ResultID` INT AUTO_INCREMENT PRIMARY KEY,
    `RollNumber` INT,
    `ExamID` INT,
    `Score` INT,
    `Total` INT,
    FOREIGN KEY (`RollNumber`) REFERENCES `studenttable`(`RollNumber`),
    FOREIGN KEY (`ExamID`) REFERENCES `examdetails`(`ExamID`)
);

-- Create a new table to store schedules
CREATE TABLE schedule (
    ScheduleID INT AUTO_INCREMENT PRIMARY KEY,
    Course VARCHAR(100) NOT NULL,
    Year VARCHAR(20) NOT NULL,
    Date DATE NOT NULL,
    Time TIME NOT NULL,
    Description TEXT NOT NULL
);

-- Add Division column to the studenttable
ALTER TABLE studenttable ADD COLUMN Division VARCHAR(10) NOT NULL AFTER Year;

-- Add Course, Year, and Division columns to the assessment table
ALTER TABLE assessment ADD COLUMN Course VARCHAR(100) NOT NULL AFTER AssessmentName;
ALTER TABLE assessment ADD COLUMN Year VARCHAR(20) NOT NULL AFTER Course;
ALTER TABLE assessment ADD COLUMN Division VARCHAR(10) NOT NULL AFTER Year;

-- Create a new table to store MCQ questions for assessments
CREATE TABLE mcq_questions (
    QuestionID INT AUTO_INCREMENT PRIMARY KEY,
    AssessmentID INT NOT NULL,
    Question TEXT NOT NULL,
    OptionA TEXT NOT NULL,
    OptionB TEXT NOT NULL,
    OptionC TEXT NOT NULL,
    OptionD TEXT NOT NULL,
    CorrectOption CHAR(1) NOT NULL,
    FOREIGN KEY (AssessmentID) REFERENCES assessment(AssessmentID)
);

-- Update the result table to allow faculty to assign marks directly
ALTER TABLE result ADD COLUMN FacultyAssignedMarks INT DEFAULT NULL;

-- Add a column to specify the type of assessment (MCQ or Text)
ALTER TABLE assessment ADD COLUMN AssessmentType ENUM('MCQ', 'Text') NOT NULL DEFAULT 'MCQ';

-- Create a new table to store text-based questions for assessments
CREATE TABLE text_assessments (
    QuestionID INT AUTO_INCREMENT PRIMARY KEY,
    AssessmentID INT NOT NULL,
    Question TEXT NOT NULL,
    FOREIGN KEY (AssessmentID) REFERENCES assessment(AssessmentID)
);

-- Create a new table to store text-based answers submitted by students
CREATE TABLE text_answers (
    AnswerID INT AUTO_INCREMENT PRIMARY KEY,
    AssessmentID INT NOT NULL,
    RollNumber INT NOT NULL,
    Answer TEXT NOT NULL,
    Marks INT DEFAULT NULL,
    FOREIGN KEY (AssessmentID) REFERENCES assessment(AssessmentID),
    FOREIGN KEY (RollNumber) REFERENCES studenttable(RollNumber)
);

-- Add a column to store the faculty ID in the query table
ALTER TABLE `query` ADD COLUMN `FacultyID` INT NOT NULL;

-- Ensure the query table has the necessary columns
ALTER TABLE `query` 
    ADD COLUMN `StudentID` INT NOT NULL AFTER `Query`,
    ADD COLUMN `StudentName` VARCHAR(255) NOT NULL AFTER `StudentID`,
    ADD COLUMN `Answer` TEXT DEFAULT NULL AFTER `FacultyID`;

-- Add admin table to the database
CREATE TABLE `admin` (
    `Aid` INT AUTO_INCREMENT PRIMARY KEY,
    `AdminName` VARCHAR(255) NOT NULL,
    `Apass` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) UNIQUE NOT NULL
);

-- Insert sample admin data
INSERT INTO `admin` (`AdminName`, `Apass`, `Email`) 
VALUES ('Admin User', 'admin123', 'admin@example.com');

-- Add foreign key constraints (if applicable)
-- FOREIGN KEY (FacultyID) REFERENCES facutlytable(FID),
-- FOREIGN KEY (StudentID) REFERENCES studenttable(RollNumber);