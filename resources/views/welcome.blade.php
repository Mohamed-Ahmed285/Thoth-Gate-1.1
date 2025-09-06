<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Th𝕆th Gate - Unlock Your Potential</title>
    <link rel="icon" href="imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="landing.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="landing-page">
    <div id="loader">
        <!-- You can add an image, a CSS spinner, or text here -->
        <div class="spinner"></div>
        <p>Loading...</p>
    </div>
    <header class="main-header">
        <div class="header-content">
            <div class="logo-container">
                <img src="imgs/logo.png" alt="Th𝕆th Gate Logo" class="logo-image">
                <h1 class="site-logo">Th𝕆th Gate</h1>
            </div>


            <div class="big">
                <div class="log-reg">
                    <a href="/login" class="btn-login">Login</a>
                    <a href="/register" class="btn-signup">Sign Up</a>
                </div>




                <div class="switchers-container">
                    <button class="theme-switcher" id="themeSwitcher" title="Toggle Dark Mode">
                        <span class="theme-icon">🌙</span>
                    </button>
                    <button class="language-switcher" id="languageSwitcher" title="Switch Language">
                        <span class="language-text">EN</span>
                    </button>
                </div>
            </div>

        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <h2 class="hero-title">Gateway to Ancient Wisdom.</h2>
                <p class="hero-subtitle">Join thousands of learners discovering knowledge, guided by timeless heritage
                    and expert mentors.</p>
                <div class="hero-buttons">
                    <a href="/register" class="btn primary">Get Started</a>
                </div>
            </div>
            <div class="hero-decoration">
                <div class="ancient-symbol"></div>
                <div class="egyptian-patterns">
                    <div class="pattern-1"></div>
                    <div class="pattern-2"></div>
                    <div class="pattern-3"></div>
                </div>
            </div>
        </section>
        <section class="courses-section">
            <div class="container">
                <h2 class="section-title">Subjects</h2>
                <div class="courses-filter" style="margin-bottom:2rem; text-align:center;">
                    <label for="gradeFilter" style="font-weight:600; color:#243a6b; margin-right:10px;">Filter by
                        Grade:</label>
                    <select id="gradeFilter"
                        style="padding:8px 16px; border-radius:8px; border:2px solid #d4af37; font-size:1rem;">
                        <option value="Third Preparatory">Third Preparatory</option>

                        <option value="First Secondary">First Secondary</option>
                    </select>
                </div>
                <div class="courses-grid" id="coursesGrid">
                    @foreach ($courses1 as $course)
                        <div class="course-card">
                            <div class="course-image">
                                <img src="{{ $course->image }}" alt="{{ $course->subject }}">
                            </div>
                            <div class="course-content">
                                <div class="course-header">
                                    <h3>{{ $course->subject }}</h3>
                                </div>
                                <div class="course-meta">
                                    <span class="instructor">{{ $course->teacher }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="width: 100%; display: flex; justify-content: center;">
                    <button id="loadMoreBtn"
                        style="padding:8px 16px; border-radius:8px; border:2px solid #d4af37; font-size:1rem; background: #1a2a4a; color: #f5deb3; margin-top: 2rem; text-align: center; cursor:pointer">Load
                        More&nbsp;&nbsp;↓</button>
                </div>
            </div>
        </section>
        <!-- Features / Why Choose Us Section -->
        <section class="egyptian-heritage-section">
            <div class="container">
                <h2 class="section-title">Why Choose Us?</h2>
                <div class="heritage-grid">
                    <div class="heritage-item">
                        <img src="imgs/office.jpg" alt="Great Community" class="heritage-image">
                        <h3>Great Community</h3>
                        <p>Connect with passionate learners and expert mentors in a supportive environment.</p>
                    </div>
                    <div class="heritage-item">
                        <img src="imgs/self.jpg" alt="Flexible Self-Learning" class="heritage-image">
                        <h3>Flexible Self-Learning</h3>
                        <p>Learn at your own pace, anytime and anywhere, with resources tailored for you.</p>
                    </div>
                    <div class="heritage-item">
                        <img src="imgs/2.jpg" alt="Diverse Course Library" class="heritage-image">
                        <h3>Diverse Course Library</h3>
                        <p>Access a wide variety of courses covering different subjects and skills.</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="comb">
            <section class="egyptian-wisdom-section about-section">
                <div class="container">
                    <h2 class="section-title">About Us</h2>
                    <div class="wisdom-content">
                        <div class="wisdom-text">
                            <p class="hero-subtitle">
                                Th𝕆th Gate blends the legacy of ancient Egyptian scholarship with modern pedagogical
                                practice — delivering rigorous courses, expert mentorship, and a nurturing learning
                                environment for the students of today.
                            </p>
                            <p class="wisdom-author">Our mission: preserve wisdom — inspire learning.</p>
                        </div>
                        <div class="wisdom-image">
                            <img src="imgs/1.jpg" alt="About Th𝕆th Gate" class="egyptian-image">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="cta-section">
                <div class="container egyptian-heritage-section">
                    <h2>Begin Your Journey with Th𝕆th Gate</h2>
                    <p>Join a community of learners inspired by ancient wisdom and empowered by modern knowledge.</p>
                    <div class="hero-buttons">
                        <a href="/register" class="btn primary">Join Now</a>
                    </div>
                </div>
            </section>
        </div>


    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Th𝕆th Gate</h3>
                    <p>Gateway to Ancient Wisdom, Modern Learning</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>

                        <li><a href="#">About</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Contact</a></li>

                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email: info@thothgate.edu.eg</p>
                    <p>Phone: +20 123 456 789</p>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-icons">
                        <a href="#" class="social-icon">📘</a>
                        <a href="#" class="social-icon">📷</a>
                        <a href="#" class="social-icon">🐦</a>
                        <a href="#" class="social-icon">💼</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Th𝕆th Gate Learning Center. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        const coursesByGrade = {
            'Third Preparatory': @json($courses1),
            'First Secondary': @json($courses2)
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Configuration & State ---
            const COURSES_PER_LOAD = 3; // MODIFIED: Set how many courses to load at a time
            let coursesCurrentlyVisible = COURSES_PER_LOAD;

            // --- Element Selectors ---
            const gradeFilter = document.getElementById('gradeFilter');
            const coursesGrid = document.getElementById('coursesGrid');
            const loadMoreBtn = document.getElementById('loadMoreBtn');

            // --- Main Render Function ---
            function renderCourses(selectedGrade) {
                const allCoursesForGrade = coursesByGrade[selectedGrade] || [];

                // Clear the existing courses
                coursesGrid.innerHTML = '';

                // Get the portion of courses to display
                const coursesToDisplay = allCoursesForGrade.slice(0, coursesCurrentlyVisible);

                // If no courses exist for the grade, show a message and hide the button
                if (allCoursesForGrade.length === 0) {
                    coursesGrid.innerHTML = '<p style="color: #243a6b;">No courses available for this grade.</p>';
                    loadMoreBtn.style.display = 'none';
                    return;
                }

                // Create and append HTML for each course card
                coursesToDisplay.forEach(course => {
                    const courseCard = `
                    <div class="course-card">
                        <div class="course-image">
                            <img src="${course.image}" alt="${course.subject}">
                        </div>
                        <div class="course-content">
                            <div class="course-header">
                                <h3>${course.subject}</h3>
                            </div>
                            <div class="course-meta">
                                <span class="instructor">${course.teacher}</span>
                            </div>
                        </div>
                    </div>
                `;
                    coursesGrid.insertAdjacentHTML('beforeend', courseCard);
                });

                // --- Manage "Load More" Button Visibility ---
                if (coursesCurrentlyVisible >= allCoursesForGrade.length) {
                    loadMoreBtn.style.display = 'none'; // Hide button if all courses are shown
                } else {
                    loadMoreBtn.style.display = 'block'; // Show button if there are more to load
                }
            }

            // --- Event Listeners ---

            // 1. When the grade filter is changed
            gradeFilter.addEventListener('change', function() {
                // Reset the count for the new category
                coursesCurrentlyVisible = COURSES_PER_LOAD;
                renderCourses(this.value);
            });

            // 2. When the "Load More" button is clicked
            loadMoreBtn.addEventListener('click', function() {
                // Increase the number of visible courses
                coursesCurrentlyVisible += COURSES_PER_LOAD;
                const selectedGrade = gradeFilter.value;
                renderCourses(selectedGrade);
            });

            // --- Initial Page Load ---
            // Render the initial set of courses for the default selected grade
            renderCourses(gradeFilter.value);
        });
    </script>

    <script src="script.js"></script>
</body>

</html>
