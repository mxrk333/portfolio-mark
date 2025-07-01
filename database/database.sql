CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data (optional)
-- NSERT INTO inquiries (name, email, phone, subject, message, is_read, created_at) VALUES
-- ('John Smith', 'john.smith@email.com', '0912-345-6789', 'Website Development', 'Hi Juan, I need help developing a website for my business. Can we discuss the details?', FALSE, '2024-01-15 10:30:00'),
-- ('Maria Garcia', 'maria.garcia@email.com', '0923-456-7890', 'Virtual Assistant Services', 'I am looking for a virtual assistant to help with my administrative tasks. Are you available?', TRUE, '2024-01-14 14:20:00'),
-- ('Robert Johnson', 'robert.j@email.com', NULL, 'IT Support', 'Our company needs IT support for network setup. What are your rates?', FALSE, '2024-01-13 09:15:00');
