<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cloud Classrooms</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/ 5shiv/3.7.0/ 5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <style>
        body {
            margin: 0; /* Remove white space above the page */
            padding: 0;
        }
        .navbar {
            background-color: #B7202E; /* InPower Red */
            color: #FFFFFF; /* White */
            margin: 0; /* Align navbar to the top */
            padding: 30px 30px; /* Increased padding for a wider header */
            border-bottom: 3px solid #FFFFFF; /* Add visible border at the bottom */
        }
        .navbar a {
            color: #FFFFFF; /* White */
            font-weight: bold;
            padding: 12px 20px; /* Ensure consistent size with header */
            text-decoration: none;
            border: 2px solid #FFFFFF; /* Add visible border */
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease, border-color 0.3s ease; /* Smooth hover effect */
            margin-left: 10px; /* Add spacing between buttons */
        }
        .navbar a:hover {
            background-color: #ED1C24; /* Vitality Red */
            border-color: #FFFFFF; /* White border on hover */
            transform: scale(1.1); /* Slight pop effect */
        }
        .navbar-brand {
            font-size: 20px;
            font-weight: bold;
        }
        .navbar-brand img {
            height: 100px; /* Adjusted height for better fit */
            width: auto;
            margin: 0; /* Align with navbar */
            display: inline-block; /* Ensure proper alignment */
            transition: none !important; /* Forcefully remove hover effects */
        }
        .navbar-nav {
            margin-left: auto; /* Align buttons to the right */
        }
        .dropdown {
            position: relative;
        }
        .dropdown-toggle {
            background-color: #B7202E; /* InPower Red */
            color: #FFFFFF; /* White */
            font-weight: bold;
            padding: 12px 20px; /* Match other buttons */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .dropdown-toggle:hover {
            background-color: #ED1C24; /* Vitality Red */
        }
        .dropdown-menu {
            background-color: #B7202E; /* InPower Red */
            border: 1px solid #B7202E; /* InPower Red */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none; /* Initially hidden */
            flex-direction: column; /* Vertical alignment */
            padding: 0;
            margin: 0;
            z-index: 1000;
        }
        .dropdown:hover .dropdown-menu {
            display: flex; /* Show on hover */
        }
        .dropdown-item {
            padding: 10px 20px;
            color: #FFFFFF; /* White */
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .dropdown-item:hover {
            background-color: #ED1C24; /* Vitality Red */
            color: #FFFFFF; /* White */
        }
    </style>
</head>

<body style="overflow-x: hidden;">
<header>
<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#" style="border: none;">
            <img src="images/somaiyalogo.png" alt="Somaiya Logo" style="height: 90px; width: auto;">
        </a>
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="about.php">About</a>
            <a class="nav-item nav-link" href="registrationform.php">Registration</a>
            <a class="nav-item nav-link" href="takeassessment.php">Take Assessment</a>
            <a class="nav-item nav-link" href="viewresult.php?seno=<?php echo isset($_SESSION['seno']) ? $_SESSION['seno'] : ''; ?>">Result</a>
            <a class="nav-item nav-link" href="postquerypublic.php" style="border: 2px solid #FFFFFF; border-radius: 5px;">Post Query</a>
            <div class="dropdown" style="display: inline-block; border: 2px solid #FFFFFF; border-radius: 5px;">
                <button class="dropdown-toggle" type="button">
                    Login
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="studentlogin.php">Student Login</a>
                    <a class="dropdown-item" href="facultylogin.php">Faculty Login</a>
                    <a class="dropdown-item" href="adminlogin.php">Admin Login</a>
                </div>
            </div>
        </div>
    </nav>
</header>
</body>
</html>