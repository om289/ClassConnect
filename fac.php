<?php include('allhead.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Classroom - Faculty</title>
    <style>
        :root {
            --maroon-primary: #800000;
            --maroon-secondary: #5a0000;
            --light-bg: #f8f9fa;
            --text-dark: #2c3e50;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                        url('images/fac.jpg') center/cover fixed;
        }

        .maroon-header {
            background: var(--maroon-primary);
            width: 100%;
            padding: 1rem 0;
            position: fixed;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .content-wrapper {
            padding-top: 80px;
            min-height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .dept-selector {
            width: 400px;
            margin: 2rem 0;
            position: relative;
        }

        .dept-selector select {
            width: 100%;
            padding: 1rem;
            font-size: 1.1rem;
            border-radius: 8px;
            border: 2px solid var(--maroon-primary);
            background: rgba(255,255,255,0.9);
            appearance: none;
        }

        .faculty-grid {
            max-width: 1200px;
            width: 100%;
            padding: 2rem;
            display: none;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .faculty-card {
            background: rgba(255,255,255,0.95);
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .faculty-card:hover {
            transform: translateY(-5px);
        }

        .faculty-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--maroon-primary);
        }

        .faculty-name {
            color: var(--maroon-primary);
            margin: 1rem 0 0.5rem;
            font-size: 1.3rem;
        }

        .faculty-dept {
            color: var(--maroon-secondary);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <!-- Header -->
    

    <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Department Selector -->
        <div class="dept-selector">
            <select id="departmentSelect" onchange="showFaculty()">
                <option value="" selected disabled>Select Department</option>
                <option value="computer-science">Computer Science</option>
                <option value="mathematics">Mathematics</option>
                <option value="physics">Physics</option>
            </select>
        </div>

        <!-- Faculty Grid -->
        <div class="faculty-grid" id="facultyGrid">
            <!-- Computer Science -->
            <div class="faculty-card" data-dept="computer-science">
                <img src="https://via.placeholder.com/300x200/800000/ffffff?text=CS+Prof+1" class="faculty-image">
                <h3 class="faculty-name">Dr. Sarah Johnson</h3>
                <p class="faculty-dept">Computer Science</p>
                <p>15+ Years Experience<br>PhD in Computer Science</p>
            </div>

            <div class="faculty-card" data-dept="computer-science">
                <img src="https://via.placeholder.com/300x200/800000/ffffff?text=CS+Prof+2" class="faculty-image">
                <h3 class="faculty-name">Prof. Michael Chen</h3>
                <p class="faculty-dept">Computer Science</p>
                <p>10+ Years Experience<br>Cybersecurity Expert</p>
            </div>

            <!-- Mathematics -->
            <div class="faculty-card" data-dept="mathematics">
                <img src="https://via.placeholder.com/300x200/800000/ffffff?text=Math+Prof+1" class="faculty-image">
                <h3 class="faculty-name">Dr. Emily White</h3>
                <p class="faculty-dept">Mathematics</p>
                <p>8+ Years Experience<br>Calculus Specialist</p>
            </div>

            <div class="faculty-card" data-dept="mathematics">
                <img src="https://via.placeholder.com/300x200/800000/ffffff?text=Math+Prof+2" class="faculty-image">
                <h3 class="faculty-name">Prof. David Brown</h3>
                <p class="faculty-dept">Mathematics</p>
                <p>12+ Years Experience<br>Number Theory Expert</p>
            </div>

            <!-- Physics -->
            <div class="faculty-card" data-dept="physics">
                <img src="https://via.placeholder.com/300x200/800000/ffffff?text=Physics+Prof+1" class="faculty-image">
                <h3 class="faculty-name">Dr. Rachel Green</h3>
                <p class="faculty-dept">Physics</p>
                <p>7+ Years Experience<br>Quantum Physics</p>
            </div>

            <div class="faculty-card" data-dept="physics">
                <img src="https://via.placeholder.com/300x200/800000/ffffff?text=Physics+Prof+2" class="faculty-image">
                <h3 class="faculty-name">Prof. John Smith</h3>
                <p class="faculty-dept">Physics</p>
                <p>9+ Years Experience<br>Astrophysics</p>
            </div>
        </div>
    </div>

    <script>
        function showFaculty() {
            const select = document.getElementById('departmentSelect');
            const grid = document.getElementById('facultyGrid');
            
            grid.style.display = 'grid';
            grid.scrollIntoView({ behavior: 'smooth' });

            document.querySelectorAll('.faculty-card').forEach(card => {
                card.style.display = card.dataset.dept === select.value ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>