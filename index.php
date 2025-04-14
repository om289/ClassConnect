<?php include('allhead.php'); ?>
<!DOCTYPE html>
<html lang="en" class="apple-theme">
<head>
    <style>
        :root {
            --apple-black: #000;
            --apple-dark: #1d1d1f;
            --apple-blue: #0071e3;
            --apple-light: #f5f5f7;
            --apple-gradient: linear-gradient(45deg, #2c2c2e, #1d1d1f);
        }

        body {
            background-color: var(--apple-black);
            color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* Fixed Hero Section */
        .apple-hero {
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 4rem;
        }

        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            opacity: 0.4;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 2rem;
        }

        .hero-headline {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 2rem;
            background: linear-gradient(90deg, #fff, #888);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInUp 1s ease;
        }

        /* Visible Feature Grid */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
            position: relative;
            z-index: 3;
        }

        .feature-card {
            background: rgba(255,255,255,0.05);
            border-radius: 18px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        /* Clickable Buttons */
        .cta-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .apple-button {
            padding: 1rem 2.5rem;
            background: var(--apple-blue);
            color: #fff;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .apple-button:hover {
            background: transparent;
            border-color: var(--apple-blue);
            transform: scale(1.05);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Visible Technology Grid */
        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            padding: 4rem 2rem;
            background: var(--apple-gradient);
            position: relative;
            z-index: 3;
        }

        .tech-logo {
            width: 100%;
            height: 100px;
            object-fit: contain;
            transition: filter 0.3s;
        }
    </style>
</head>
<body>
    <!-- Hero Section with Clickable Elements -->
    <section class="apple-hero">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="images/hero.mp4" type="video/mp4">
        </video>
        <div class="hero-content">
            <h1 class="hero-headline">Welcome to Cloud Classrooms</h1>
            <div class="cta-buttons">
                <a href="registrationform" class="apple-button">Get Started</a>
                <a href="about" class="apple-button">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Visible Feature Section -->
    <section class="feature-grid">
        <div class="feature-card">
            <h3>Interactive Learning</h3>
            <p>Access course materials and video lectures anytime, anywhere.</p>
        </div>
        <div class="feature-card">
            <h3>Smart Scheduling</h3>
            <p>Automated class schedules and assessment tracking.</p>
        </div>
        <div class="feature-card">
            <h3>Cloud Integration</h3>
            <p>Seamless access across all your devices.</p>
        </div>
    </section>

    <!-- Technology Section -->
    <section class="tech-grid">
        <img src="images/apache.png" alt="PHP" class="tech-logo">
        <img src="images/mysql1.png" alt="MySQL" class="tech-logo">
        <img src="images/bs2.png" alt="Bootstrap" class="tech-logo">
        <img src="images/hcj.png" alt="JavaScript" class="tech-logo">
    </section>

    <script>
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