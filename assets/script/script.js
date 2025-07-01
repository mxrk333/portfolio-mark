// Project data
const projectData = {
  1: {
    title: "Lead Management Tracker",
    category: "Web Development",
    description:
      "Developed a robust Lead Management System using PHP and MySQL during my OJT internship. Key features include lead tracking, agent assignment, report generation, and role-based access control for admins and agents. Integrated user authentication, data export functionality, and a streamlined UI for efficient lead processing. Optimized backend queries and implemented secure password hashing to ensure performance and data security.",
    technologies: ["PHP", "MySQL", "JavaScript"],
    image: "projects/lms.png",
    link: "#",
  },
  2: {
    title: "Tournament Scheduling System",
    category: "Web Development",
    description:
      "Developed a Web-Based Tournament Scheduling System using PHP and MySQL as part of my capstone project. Key features include automated game scheduling, event and team management, real-time score updates, and role-based access for admins, athletes, and guests. Designed with a responsive interface and optimized for performance and usability.",
    technologies: ["PHP", "MySQL", "JavaScript"],
    image: "projects/tms.png",
    link: "#",
  },
  3: {
    title: "Virtual Assistant Automation",
    category: "Process Automation",
    description:
      "Created automated workflow solutions to streamline administrative tasks including email management, appointment scheduling, data entry, and report generation. Implemented chatbot integration for customer support and developed custom scripts for social media management and content scheduling.",
    technologies: ["Python", "Zapier", "Google Apps Script", "Selenium", "API Integration", "BeautifulSoup"],
    image: "/placeholder.svg?height=400&width=600",
    link: "#",
  },
  4: {
    title: "Network Infrastructure Setup",
    category: "IT Infrastructure",
    description:
      "Designed and implemented secure network infrastructure for a 50-employee company. Configured firewalls, VPN access, wireless networks, and implemented security protocols. Set up monitoring systems, backup solutions, and disaster recovery procedures. Provided ongoing maintenance and support.",
    technologies: ["Cisco", "Windows Server", "VMware", "Firewall", "VPN", "Active Directory"],
    image: "/placeholder.svg?height=400&width=600",
    link: "#",
  },
}

// DOM Elements
const hamburger = document.getElementById("hamburger")
const navMenu = document.getElementById("nav-menu")
const projectCards = document.querySelectorAll(".project-card")
const modal = document.getElementById("project-modal")
const closeModal = document.querySelector(".close")
const backToTopBtn = document.getElementById("back-to-top")

// Mobile Navigation Toggle
hamburger.addEventListener("click", () => {
  hamburger.classList.toggle("active")
  navMenu.classList.toggle("active")
})

// Close mobile menu when clicking on a link
document.querySelectorAll(".nav-link").forEach((link) => {
  link.addEventListener("click", () => {
    hamburger.classList.remove("active")
    navMenu.classList.remove("active")
  })
})

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault()
    const target = document.querySelector(this.getAttribute("href"))
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      })
    }
  })
})

// Project Modal Functionality
projectCards.forEach((card) => {
  card.addEventListener("click", () => {
    const projectId = card.getAttribute("data-project")
    const project = projectData[projectId]

    if (project) {
      // Populate modal with project data
      document.getElementById("modal-title").textContent = project.title
      document.getElementById("modal-category").textContent = project.category
      document.getElementById("modal-description").textContent = project.description
      document.getElementById("modal-img").src = project.image
      document.getElementById("modal-img").alt = project.title

      // Clear and populate technologies
      const techContainer = document.getElementById("modal-tech")
      techContainer.innerHTML = ""
      project.technologies.forEach((tech) => {
        const techTag = document.createElement("span")
        techTag.className = "tech-tag"
        techTag.textContent = tech
        techContainer.appendChild(techTag)
      })

      // Show/hide project link
      const modalLink = document.getElementById("modal-link")
      if (project.link && project.link !== "#") {
        modalLink.href = project.link
        modalLink.style.display = "inline-flex"
      } else {
        modalLink.style.display = "none"
      }

      // Show modal
      modal.style.display = "block"
      document.body.style.overflow = "hidden"
    }
  })
})

// Close modal functionality
closeModal.addEventListener("click", () => {
  modal.style.display = "none"
  document.body.style.overflow = "auto"
})

window.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.style.display = "none"
    document.body.style.overflow = "auto"
  }
})

// Back to Top Button Functionality
window.addEventListener("scroll", () => {
  const navbar = document.querySelector(".navbar")

  // Navbar scroll effect
  if (window.scrollY > 100) {
    navbar.classList.add("scrolled")
  } else {
    navbar.classList.remove("scrolled")
  }

  // Back to top button visibility
  if (window.scrollY > 300) {
    backToTopBtn.style.display = "flex"
  } else {
    backToTopBtn.style.display = "none"
  }
})

// Back to top button click handler
backToTopBtn.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  })
})

// Add parallax effect to profile image
window.addEventListener("scroll", () => {
  const scrolled = window.pageYOffset
  const profileImg = document.querySelector(".profile-image")
  if (profileImg) {
    profileImg.style.transform = `translateY(${scrolled * 0.05}px)`
  }
})

// Intersection Observer for animations
const observerOptions = {
  threshold: 0.1,
  rootMargin: "0px 0px -50px 0px",
}

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = "1"
      entry.target.style.transform = "translateY(0)"
    }
  })
}, observerOptions)

// Observe elements for animation
document.querySelectorAll(".project-card, .experience-item, .certificate-card, .stat-item").forEach((el) => {
  el.style.opacity = "0"
  el.style.transform = "translateY(30px)"
  el.style.transition = "opacity 0.6s ease, transform 0.6s ease"
  observer.observe(el)
})

// Add loading animation to profile picture
const profilePic = document.getElementById("profile-pic")
profilePic.addEventListener("load", () => {
  profilePic.style.opacity = "1"
})

// Typing effect for hero title
function typeWriter(element, text, speed = 100) {
  let i = 0
  element.innerHTML = ""

  function type() {
    if (i < text.length) {
      element.innerHTML += text.charAt(i)
      i++
      setTimeout(type, speed)
    }
  }

  type()
}

// Initialize typing effect on page load
window.addEventListener("load", () => {
  const heroTitle = document.querySelector(".hero-title")
  const originalText = heroTitle.textContent
  typeWriter(heroTitle, originalText, 80)
})
