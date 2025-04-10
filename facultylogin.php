<?php include('allhead.php'); ?> 
<style>
body {
    background: url('images/infra2.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: Arial, sans-serif;
}
.login-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid rgba(183, 32, 46, 0.8); /* InPower Red with transparency */
    border-radius: 10px;
    background-color: rgba(255, 255, 255, 0.8); /* White with transparency */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.login-container h2 {
    text-align: center;
    color: #B7202E; /* InPower Red */
    margin-bottom: 20px;
}
.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #B7202E; /* InPower Red */
    border-radius: 5px;
}
.login-container button {
    width: 100%;
    padding: 10px;
    background-color: #ED1C24; /* Vitality Red */
    color: #FFFFFF; /* White */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
    transition: background-color 0.3s ease;
}
.login-container button:hover {
    background-color: #B7202E; /* InPower Red */
}
</style>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-5 login-container">
            <fieldset>
                <legend>
                    <h3 style="padding-top: 25px;"><span class="glyphicon glyphicon-lock"></span>&nbsp; Faculty Login</h3>
                </legend>
                <form name="facultylogin" action="loginlinkfaculty" method="POST">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Faculty ID:</label>
                            <input type="text" class="form-control" name="fid" required data-validation-required-message="Please enter your Faculty Id.">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="pass" required data-validation-required-message="Please enter your password.">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </center>
                </form>
            </fieldset>
        </div>
    </div>
</div>
<?php include('allfoot.php'); ?>