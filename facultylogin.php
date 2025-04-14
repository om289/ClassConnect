<?php include('allhead.php'); ?>
<style>
body {
    background: url('images/infra1.png') no-repeat center center fixed;
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

<div class="login-container">
    <h2>Faculty Login</h2>
    <form action="loginlinkfaculty.php" method="POST">
    <input type="text" name="fid" placeholder="Faculty ID" required>
    <input type="password" name="pass" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
</div>




<!-- Ensure Bootstrap JS Initialization -->
<script>
$(document).ready(function(){
    // Initialize dropdowns
    $('.dropdown-toggle').dropdown();
    
    // Initialize collapse
    $('#main-nav').collapse({
        toggle: false
    });
});
</script>
</body>
</html>
<?php include('allfoot.php'); ?>