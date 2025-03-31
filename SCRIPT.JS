// Sidebar Toggle (Optional if collapsible)
document.querySelectorAll('.sidebar ul li').forEach(item => {
    item.addEventListener('click', function () {
        document.querySelectorAll('.sidebar ul li').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
    });
});

// Search Bar Focus Effect
const searchInput = document.querySelector("header input");
searchInput.addEventListener("focus", () => {
    searchInput.style.boxShadow = "0px 0px 10px rgba(0, 0, 0, 0.2)";
});
searchInput.addEventListener("blur", () => {
    searchInput.style.boxShadow = "none";
});

// Add New Button Click Effect
document.querySelector(".add-btn").addEventListener("click", () => {
    alert("Feature coming soon!");
});

// Calendar Date Selection
document.querySelectorAll(".dates span").forEach(date => {
    date.addEventListener("click", function () {
        document.querySelectorAll(".dates span").forEach(d => d.classList.remove("active"));
        this.classList.add("active");
    });
});

// Progress Bar Animation
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".progress-bar").forEach(bar => {
        bar.style.width = bar.getAttribute("data-progress") + "%";
    });
});

// Hover Effect on Course Cards
document.querySelectorAll(".course-card").forEach(card => {
    card.addEventListener("mouseenter", function () {
        this.style.transform = "scale(1.05)";
        this.style.transition = "0.3s";
    });

    card.addEventListener("mouseleave", function () {
        this.style.transform = "scale(1)";
    });
});

// Interactive Leaderboard Highlight
document.querySelectorAll(".leaderboard tbody tr").forEach(row => {
    row.addEventListener("mouseenter", function () {
        this.style.backgroundColor = "#f4f4f4";
    });
    row.addEventListener("mouseleave", function () {
        this.style.backgroundColor = "white";
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('progressChart').getContext('2d');

    const dates = <?php echo json_encode($dates); ?>;
    const activities = <?php echo json_encode($activities); ?>;

    const progressChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Tasks Completed',
                data: activities,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
});
