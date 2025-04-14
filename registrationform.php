<?php include('allhead.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        :root {
            --apple-dark: #1d1d1f;
            --apple-light: #f5f5f7;
            --apple-blue: #0066cc;
            --apple-gray: #86868b;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: url('bg2.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--apple-dark);
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .apple-container {
            max-width: 980px;
            margin: 0 auto;
            padding: 100px 200px;
			
        }

        .apple-form {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
        }

        .apple-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .apple-header h3 {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            color: var(--apple-dark);
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--apple-dark);
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d2d2d7;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--apple-blue);
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 125, 250, 0.1);
        }

        .radio-group {
            display: flex;
            gap: 20px;
        }

        .radio-option {
            display: flex;
            align-items: center;
        }

        .radio-option input {
            width: auto;
            margin-right: 8px;
        }

        .apple-button {
            background-color: var(--apple-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .apple-button:hover {
            background-color: #004080;
        }

        .apple-button.secondary {
            background-color: transparent;
            color: var(--apple-blue);
            border: 1px solid var(--apple-blue);
        }

        .apple-button.secondary:hover {
            background-color: rgba(0, 125, 250, 0.1);
        }

        .button-group {
            display: flex;
            gap: 16px;
            margin-top: 32px;
        }

        .required {
            color: #ff3b30;
        }

        .success-message {
            background-color: #34c759;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="apple-container">
        <div class="apple-form">
            <?php
            include("database.php");
            if(isset($_POST['submit'])) {
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $faname = $_POST['faname'];
                $course = $_POST['course'];
                $dob = $_POST['dob'];
                $addrs = $_POST['addrs'];
                $gender = $_POST['gender'];
                $phno = $_POST['phno'];
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $year = $_POST['year'];
                $division = $_POST['division'];
                
                $done = '<div class="success-message">
                    <h3>Registration Successfully Complete</h3>
                    <p>Now You Can Login With Your Email & Password</p>
                </div>';

                $sql = "INSERT INTO `studenttable` (`FName`, `LName`, `FaName`, `DOB`, `Addrs`, `Gender`, `PhNo`, `Eid`, `Pass`, `Course`, `Year`, `Division`) 
                        VALUES ('$fname','$lname','$faname','$dob','$addrs','$gender','$phno','$email','$pass','$course','$year','$division')";
                
                mysqli_query($connect, $sql);
                echo $done;
            }
            ?>

            <div class="apple-header">
                <h3>Student Registration</h3>
            </div>

            <form name="register" action="" method="POST" onsubmit="return validateForm()">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="fname" id="fname" maxlength="30" required>
                    </div>

                    <div class="form-group">
                        <label>Last Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="lname" id="lname" maxlength="30" required>
                    </div>

                    <div class="form-group">
                        <label>Father Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="faname" id="faname" maxlength="30" required>
                    </div>

                    <div class="form-group">
                        <label>Course <span class="required">*</span></label>
                        <input type="text" class="form-control" name="course" id="course" maxlength="10" required>
                    </div>

                    <div class="form-group">
                        <label>Year <span class="required">*</span></label>
                        <select class="form-control" name="year" id="year" required>
                            <option value="">-- Select Year --</option>
                            <option value="FY">First Year (FY)</option>
                            <option value="SY">Second Year (SY)</option>
                            <option value="TY">Third Year (TY)</option>
                            <option value="LY">Final Year (LY)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Division <span class="required">*</span></label>
                        <select class="form-control" name="division" id="division" required>
                            <option value="">-- Select Division --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date of Birth <span class="required">*</span></label>
                        <input type="date" class="form-control" name="dob" id="dob" required>
                    </div>

                    <div class="form-group">
                        <label>Address <span class="required">*</span></label>
                        <textarea class="form-control" name="addrs" id="addrs" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Gender <span class="required">*</span></label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" name="gender" value="Male" id="Gender_0" checked required>
                                <label for="Gender_0">Male</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="gender" value="Female" id="Gender_1" required>
                                <label for="Gender_1">Female</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Contact Number <span class="required">*</span></label>
                        <input type="tel" pattern="^\d{10}$" class="form-control" name="phno" id="phno" maxlength="10" required placeholder="10 digits without country code">
                    </div>

                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" maxlength="50" required>
                    </div>

                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <input type="password" class="form-control" name="pass" id="pass" maxlength="30" required>
                        <small class="text-muted">Max 30 characters</small>
                    </div>

                    <div class="button-group">
                        <button type="submit" name="submit" class="apple-button">Register</button>
                        <button type="reset" name="reset" class="apple-button secondary">Clear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('.dropdown-toggle').dropdown();
            $('#main-nav').collapse({ toggle: false });
        });

        function validateForm() {
            var fname = document.forms["register"]["fname"].value;
            var lname = document.forms["register"]["lname"].value;
            var faname = document.forms["register"]["faname"].value;
            var course = document.forms["register"]["course"].value;
            var dob = document.forms["register"]["dob"].value;
            var addrs = document.forms["register"]["addrs"].value;
            var gender = document.forms["register"]["gender"].value;
            var phno = document.forms["register"]["phno"].value;
            var x = document.forms["register"]["email"].value;
            var atpos = x.indexOf("@");
            var dotpos = x.lastIndexOf(".");
            var pass = document.forms["register"]["pass"].value;
            var year = document.forms["register"]["year"].value;
            var division = document.forms["register"]["division"].value;

            if (fname == "" || lname == "" || faname == "" || course == "" || dob == "" || addrs == "" || gender == "" || phno == "" || pass == "" || year == "" || division == "") {
                alert("All fields marked with * are required.");
                return false;
            }
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
                alert("Not a valid e-mail address");
                return false;
            }
        }
    </script>
</body>
</html>
<?php include('allfoot.php'); ?>
