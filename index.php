<?php
// Include database connection
require_once 'config/database.php';

// Handle form submission
$message = '';
if ($_POST && isset($_POST['submit_inquiry'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $subject = trim($_POST['subject']);
    $inquiry_message = trim($_POST['message']);
    
    if (!empty($name) && !empty($email) && !empty($inquiry_message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO inquiries (name, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $phone, $subject, $inquiry_message]);
            $message = '<div class="alert alert-success">Thank you! Your inquiry has been sent successfully.</div>';
        } catch(PDOException $e) {
            $message = '<div class="alert alert-error">Error: Unable to send your inquiry. Please try again.</div>';
        }
    } else {
        $message = '<div class="alert alert-error">Please fill in all required fields.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Christian Patigayon - IT Specialist & Virtual Assistant</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">Mark Christian Patigayon</div>
            <div class="nav-menu" id="nav-menu">
                <a href="#home" class="nav-link">Home</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#projects" class="nav-link">Projects</a>
                <a href="#experience" class="nav-link">Experience</a>
                <a href="#education" class="nav-link">Education</a>
                <a href="#certificates" class="nav-link">Certificates</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>
            <div class="hamburger" id="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <section id="home" class="hero">
        <div class="hero-container">
            <div class="profile-image">
                <img src="assets/images/markchristianpatigayon.jpg" alt="Mark Christian Patigayon" id="profile-pic">
            </div>
            <h1 class="hero-name">Mark Christian Patigayon</h1>
            <p class="hero-title">it specialist | virtual assistant</p>
            <div class="hero-buttons">
                <a href="#contact" class="btn btn-primary">Get In Touch</a>
                <a href="#projects" class="btn btn-secondary">View Projects</a>
            </div>
        </div>
    </section>

    <!-- About Me Section -->
    <section id="about" class="about">
        <div class="container">
            <h2 class="section-title">About Me</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>I am a dedicated IT Specialist and Virtual Assistant with over 5 years of experience in providing comprehensive technical solutions and administrative support. My expertise spans across network infrastructure, system administration, process automation, and virtual assistance services.</p>
                    <p>I specialize in helping businesses streamline their operations through technology solutions and efficient administrative processes. Whether it's setting up secure network infrastructure, automating repetitive tasks, or providing reliable virtual assistance, I'm committed to delivering high-quality results that drive business success.</p>
                    <div class="skills">
                        <div class="skill-item">
                            <i class="fas fa-server"></i>
                            <span>IT Infrastructure</span>
                        </div>
                        <div class="skill-item">
                            <i class="fas fa-headset"></i>
                            <span>Virtual Assistance</span>
                        </div>
                    </div>
                </div>
                <div class="about-stats">
                    <div class="stat-item">
                        <h3>2</h3>
                        <p>Projects Completed</p>
                    </div>
                    <div class="stat-item">
                        <h3>2</h3>
                        <p>Happy Clients</p>
                    </div>
                    <div class="stat-item">
                        <h3>2+</h3>
                        <p>Years Experience</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="projects">
        <div class="container">
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle">Click on any project to see more details</p>
            <div class="projects-grid">
                <div class="project-card" data-project="1">
                    <div class="project-image">
                        <img src="projects/lms.png" alt="Lead Management System">
                    </div>
                    <div class="project-content">
                        <h3>Lead Management System</h3>
                        <p class="project-category">Web Development</p>
                        <p class="project-description">Built a Lead Management System during my OJT using PHP & MySQL — with lead tracking, role-based access, and report generation.</p>
                        <div class="project-tech">
                            <span class="tech-tag">PHP</span>
                            <span class="tech-tag">MySQL</span>
                            <span class="tech-tag">JavaScript</span>
                        </div>
                    </div>
                </div>

                <div class="project-card" data-project="2">
                    <div class="project-image">
                        <img src="projects/tms.png" alt="Tournament Scheduling System">
                    </div>
                    <div class="project-content">
                        <h3>Tournament Scheduling System</h3>
                        <p class="project-category">Web Development</p>
                        <p class="project-description">Capstone project: Built a Tournament Scheduling System with PHP & MySQL — featuring automated scheduling, team management, and live scores.</p>
                        <div class="project-tech">
                            <span class="tech-tag">PHP</span>
                            <span class="tech-tag">MySQL</span>
                            <span class="tech-tag">JavaScript</span>
                        </div>
                    </div>
                </div>

             <!--  <div class="project-card" data-project="3">
                    <div class="project-image">
                        <img src="/placeholder.svg?height=250&width=400" alt="VA Automation">
                    </div>
                    <div class="project-content">
                        <h3>Virtual Assistant Automation</h3>
                        <p class="project-category">Process Automation</p>
                        <p class="project-description">Automated workflow solutions for administrative tasks</p>
                        <div class="project-tech">
                            <span class="tech-tag">Python</span>
                            <span class="tech-tag">Zapier</span>
                            <span class="tech-tag">APIs</span>
                        </div>
                    </div>
                </div> -->

              <!--  <div class="project-card" data-project="4">
                    <div class="project-image">
                        <img src="/placeholder.svg?height=250&width=400" alt="Network Setup">
                    </div>
                    <div class="project-content">
                        <h3>Network Infrastructure Setup</h3>
                        <p class="project-category">IT Infrastructure</p>
                        <p class="project-description">Complete network setup and security implementation</p>
                        <div class="project-tech">
                            <span class="tech-tag">Cisco</span>
                            <span class="tech-tag">Windows Server</span>
                            <span class="tech-tag">VMware</span>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="experience">
        <div class="container">
            <h2 class="section-title">Work Experience</h2>
            <div class="experience-timeline">
                <div class="experience-item">
                    <div class="experience-date">2022 - Present</div>
                    <div class="experience-content">
                        <h3>Senior IT Specialist</h3>
                        <h4>Tech Solutions Inc.</h4>
                        <p>Lead IT infrastructure projects, manage network security, and provide technical support for 100+ users. Implemented cloud migration strategies and automated system monitoring.</p>
                    </div>
                </div>
                <div class="experience-item">
                    <div class="experience-date">2020 - Present</div>
                    <div class="experience-content">
                        <h3>Virtual Assistant</h3>
                        <h4>Freelance</h4>
                        <p>Provide administrative support, manage social media accounts, and automate business processes for various clients. Specialized in email management, appointment scheduling, and data entry automation.</p>
                    </div>
                </div>
                <div class="experience-item">
                    <div class="experience-date">2019 - 2022</div>
                    <div class="experience-content">
                        <h3>IT Support Technician</h3>
                        <h4>Digital Corp</h4>
                        <p>Provided technical support, maintained computer systems, and assisted with software installations and troubleshooting. Managed help desk operations and user training programs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Educational Attainment Section -->
    <section id="education" class="education">
        <div class="container">
            <h2 class="section-title">Educational Attainment</h2>
            <div class="education-grid">
                <div class="education-card">
                    <div class="education-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="education-content">
                        <h3>Bachelor of Science in Information Technology</h3>
                        <h4>University of Technology</h4>
                        <p class="education-year">2015 - 2019</p>
                        <p class="education-description">Graduated Magna Cum Laude with specialization in Network Administration and Database Management. Completed capstone project on automated network monitoring systems.</p>
                    </div>
                </div>
                <div class="education-card">
                    <div class="education-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="education-content">
                        <h3>Diploma in Computer Systems Technology</h3>
                        <h4>Technical Institute of Excellence</h4>
                        <p class="education-year">2013 - 2015</p>
                        <p class="education-description">Focused on hardware troubleshooting, system administration, and basic programming. Achieved Dean's List recognition for academic excellence.</p>
                    </div>
                </div>
                <div class="education-card">
                    <div class="education-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="education-content">
                        <h3>High School Diploma</h3>
                        <h4>Science and Technology High School</h4>
                        <p class="education-year">2009 - 2013</p>
                        <p class="education-description">Graduated as Valedictorian with focus on Mathematics, Science, and Technology. Active member of Computer Club and Robotics Team.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Certificates Section -->
    <section id="certificates" class="certificates">
        <div class="container">
            <h2 class="section-title">Certifications</h2>
            <div class="certificates-grid">
                <a href="https://www.comptia.org/certifications/a" target="_blank" class="certificate-card">
                    <div class="certificate-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>CompTIA A+ Certification</h3>
                    <p>Hardware and Software Fundamentals</p>
                    <div class="certificate-link">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Certificate</span>
                    </div>
                </a>
                <a href="https://docs.microsoft.com/en-us/learn/certifications/azure-fundamentals/" target="_blank" class="certificate-card">
                    <div class="certificate-icon">
                        <i class="fab fa-microsoft"></i>
                    </div>
                    <h3>Microsoft Azure Fundamentals</h3>
                    <p>Cloud Computing Basics</p>
                    <div class="certificate-link">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Certificate</span>
                    </div>
                </a>
                <a href="https://www.cisco.com/c/en/us/training-events/training-certifications/certifications/associate/ccna.html" target="_blank" class="certificate-card">
                    <div class="certificate-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Cisco Certified Network Associate</h3>
                    <p>Network Infrastructure</p>
                    <div class="certificate-link">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Certificate</span>
                    </div>
                </a>
                <a href="https://workspace.google.com/training/" target="_blank" class="certificate-card">
                    <div class="certificate-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <h3>Google Workspace Administrator</h3>
                    <p>Workspace Management</p>
                    <div class="certificate-link">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Certificate</span>
                    </div>
                </a>
                <a href="https://www.pmi.org/certifications/project-management-pmp" target="_blank" class="certificate-card">
                    <div class="certificate-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3>Project Management Professional</h3>
                    <p>PMP Certification</p>
                    <div class="certificate-link">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Certificate</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">Contact Me</h2>
            <p class="section-subtitle">Ready to work together? Let's discuss your project!</p>
            
            <?php echo $message; ?>
            
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Email</h3>
                            <p>markpatigayon440@gmail.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Phone</h3>
                            <p>0919-462-0030</p>
                            <p>0994-480-0720</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Location</h3>
                            <p>Available Worldwide</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <form method="POST" action="#contact">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Your Name *" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Your Email *" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Your Phone Number">
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Your Message *" rows="5" required></textarea>
                        </div>
                        <button type="submit" name="submit_inquiry" class="btn btn-primary">Send Inquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Mark Christian Patigayon. All rights reserved.</p>
            <div class="social-links">
                <a href="https://www.linkedin.com/in/mark-christian-patigayon-332709252/" target="_blank" class="social-link">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="https://github.com/mxrk333" target="_blank" class="social-link">
                    <i class="fab fa-github"></i>
                </a>
                <a href="https://web.facebook.com/xmmxrk" target="_blank" class="social-link">
                    <i class="fab fa-facebook"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Project Modal -->
    <div id="project-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-body">
                <div class="modal-image">
                    <img id="modal-img" src="/placeholder.svg" alt="">
                </div>
                <div class="modal-info">
                    <h2 id="modal-title"></h2>
                    <p id="modal-category"></p>
                    <p id="modal-description"></p>
                    <div id="modal-tech" class="project-tech"></div>
                    <a href="#" id="modal-link" class="btn btn-primary" style="display: none;">
                        <i class="fas fa-external-link-alt"></i> View Project
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/script/script.js"></script>
</body>
</html>
