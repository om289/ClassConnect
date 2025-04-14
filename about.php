<?php include('allhead.php'); ?>
<!DOCTYPE html>
<html lang="en" class="apple-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Apple Style Variables */
        :root {
            --apple-black: #000000;
            --apple-dark-gray: #1d1d1f;
            --apple-blue: #0071e3;
            --apple-white: #ffffff;
            --apple-font: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: var(--apple-black);
            color: var(--apple-white);
            font-family: var(--apple-font);
            line-height: 1.46667;
        }

        /* Navigation Bar */
        .apple-nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1rem 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            z-index: 1000;
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
            color: var(--apple-white);
            text-decoration: none;
            font-size: 0.875rem;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.7;
        }

        /* Hero Section */
        .apple-hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('images/class.jpg') center/cover;
        }

        .hero-headline {
            font-size: 6rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            background: linear-gradient(90deg, #fff, #aaa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subhead {
            font-size: 2rem;
            color: #86868b;
            margin-bottom: 2.5rem;
        }

        /* Rounded Blue Buttons */
        .apple-button {
            display: inline-flex;
            padding: 1rem 2rem;
            background: var(--apple-blue);
            color: var(--apple-white);
            border-radius: 2rem;
            text-decoration: none;
            font-size: 1.5rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            align-items: center;
            gap: 0.5rem;
        }

        .apple-button:hover {
            background: #0077ED;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 113, 227, 0.3);
        }

        /* Alumni Grid */
        .apple-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            max-width: 1000px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .profile-card {
            background: var(--apple-dark-gray);
            border-radius: 1.5rem;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s;
        }

        .profile-card:hover {
            transform: translateY(-5px);
        }

        .profile-image {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1.5rem;
            border: 3px solid var(--apple-blue);
        }

        /* Modal Styles */
        .apple-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            z-index: 9999;
        }

        .modal-content {
            background: var(--apple-dark-gray);
            max-width: 600px;
            margin: 2rem auto;
            border-radius: 1.5rem;
            padding: 2.5rem;
            position: relative;
        }

        @media (max-width: 768px) {
            .hero-headline {
                font-size: 2.5rem;
            }
            
            .hero-subhead {
                font-size: 1.2rem;
            }
            
            .apple-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="apple-nav">
        <div class="nav-container">
            <div class="nav-links">
                <a href="index">Home</a>
                <a href="registration">Register</a>
                <a href="login">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="apple-hero">
        <div class="hero-content">
            <h1 class="hero-headline">Cloud Classroom</h1>
            <p class="hero-subhead">The future of education, reimagined.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                <a href="#alumni" class="apple-button">Explore Alumni</a>
                <a href="fac" class="apple-button">Meet Faculty</a>
            </div>
            
        </div>
    </section>

    <!-- Alumni Grid -->
    <section id="alumni" class="apple-section">
        <div class="apple-grid">
            <!-- Siddharth Koul -->
            <div class="profile-card" onclick="showProfile('Siddharth Koul [1Cr]', '2018', 'Senior Engineer at Apple', 'sid.png')">
                <img src="images/sid.png" alt="Siddharth Koul" class="profile-image">
                <h3 class="profile-name">Siddharth Koul</h3>
                <p class="profile-role">Computer Science</p>
                <p class="profile-details">Batch of 2018</p>
            </div>

            <!-- Om Metha -->
            <div class="profile-card" onclick="showProfile('Om Metha [1Cr]', '2023', 'Data Scientist at Google', 'om.png')">
                <img src="images/om.png" alt="Om Metha" class="profile-image">
                <h3 class="profile-name">Om Metha</h3>
                <p class="profile-role">Artificial Intelligence</p>
                <p class="profile-details">Batch of 2023</p>
            </div>

            <!-- Nikunj Maru -->
            <div class="profile-card" onclick="showProfile('Nikunj Maru [1Cr]', '2023', 'Product Manager at Microsoft', 'nikunj.png')">
                <img src="images/nikunj.png" alt="Nikunj Maru" class="profile-image">
                <h3 class="profile-name">Nikunj Maru</h3>
                <p class="profile-role">Business Technology</p>
                <p class="profile-details">Batch of 2023</p>
            </div>
             <!-- Lakshay Lakhnotra -->
             <div class="profile-card" onclick="showProfile('Lakshay Lakhnotra [1Cr]', '2023', 'Product Manager at Microsoft', 'lakshay.png')">
                <img src="images/lakshay.png" alt="Lakshay Lakhnotra" class="profile-image">
                <h3 class="profile-name">Lakshay Lakhnotra</h3>
                <p class="profile-role">Business Technology</p>
                <p class="profile-details">Batch of 2023</p>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="apple-modal" id="profileModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeProfile()">&times;</span>
            <img src="" alt="Profile" class="profile-image" id="modalImage">
            <h2 class="profile-name" id="modalName"></h2>
            <p class="profile-role" id="modalRole"></p>
            <div class="profile-details">
                <p><strong>Batch:</strong> <span id="modalBatch"></span></p>
                <p><strong>Position:</strong> <span id="modalPosition"></span></p>
                <p><strong>Achievements:</strong> Developed 10+ educational apps with 1M+ downloads</p>
            </div>
        </div>
    </div>

    <script>
        function showProfile(name, batch, position, image) {
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalBatch').textContent = batch;
            document.getElementById('modalPosition').textContent = position;
            document.getElementById('modalImage').src = 'images/' + image;
            document.getElementById('profileModal').style.display = 'block';
        }

        function closeProfile() {
            document.getElementById('profileModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target === document.getElementById('profileModal')) {
                closeProfile();
            }
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Ensure elements are clickable
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize any required components
            const buttons = document.querySelectorAll('.apple-button');
            buttons.forEach(button => {
                button.style.pointerEvents = 'auto';
            });
        });

        // Initialize dropdowns
        $(document).ready(function(){
            $('.dropdown-toggle').dropdown();
        });
    
    </script>
</body>
</html>
<?php include('allfoot.php'); ?>