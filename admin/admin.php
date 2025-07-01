<?php
// Include database connection
require_once '../config/database.php';

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
        $stmt->execute([$id]);
        $success_message = "Inquiry deleted successfully.";
    } catch(PDOException $e) {
        $error_message = "Error deleting inquiry: " . $e->getMessage();
    }
}

// Handle mark as read action
if (isset($_GET['mark_read']) && is_numeric($_GET['mark_read'])) {
    $id = $_GET['mark_read'];
    try {
        $stmt = $pdo->prepare("UPDATE inquiries SET is_read = 1 WHERE id = ?");
        $stmt->execute([$id]);
        $success_message = "Inquiry marked as read.";
    } catch(PDOException $e) {
        $error_message = "Error updating inquiry: " . $e->getMessage();
    }
}

// Fetch all inquiries
try {
    $stmt = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC");
    $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error_message = "Error fetching inquiries: " . $e->getMessage();
    $inquiries = [];
}

// Get statistics
try {
    $total_stmt = $pdo->query("SELECT COUNT(*) as total FROM inquiries");
    $total_inquiries = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $unread_stmt = $pdo->query("SELECT COUNT(*) as unread FROM inquiries WHERE is_read = 0");
    $unread_inquiries = $unread_stmt->fetch(PDO::FETCH_ASSOC)['unread'];
    
    $today_stmt = $pdo->query("SELECT COUNT(*) as today FROM inquiries WHERE DATE(created_at) = CURDATE()");
    $today_inquiries = $today_stmt->fetch(PDO::FETCH_ASSOC)['today'];
} catch(PDOException $e) {
    $total_inquiries = $unread_inquiries = $today_inquiries = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Portfolio Inquiries</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="assets/styles/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1 class="admin-title">
                <i class="fas fa-cogs"></i> Admin Panel - Portfolio Inquiries
            </h1>
            <a href="index.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Portfolio
            </a>
        </div>
    </header>

    <div class="container">
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?php echo $total_inquiries; ?></h3>
                <p><i class="fas fa-envelope"></i> Total Inquiries</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $unread_inquiries; ?></h3>
                <p><i class="fas fa-envelope-open"></i> Unread Inquiries</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $today_inquiries; ?></h3>
                <p><i class="fas fa-calendar-day"></i> Today's Inquiries</p>
            </div>
        </div>

        <!-- Inquiries Table -->
        <div class="inquiries-table">
            <div class="table-header">
                <h2><i class="fas fa-list"></i> All Inquiries</h2>
            </div>
            
            <?php if (empty($inquiries)): ?>
                <div class="no-inquiries">
                    <i class="fas fa-inbox"></i>
                    <h3>No inquiries yet</h3>
                    <p>When people submit inquiries through your portfolio, they will appear here.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inquiries as $inquiry): ?>
                                <tr class="<?php echo $inquiry['is_read'] ? '' : 'unread'; ?>">
                                    <td><?php echo htmlspecialchars($inquiry['name']); ?></td>
                                    <td><?php echo htmlspecialchars($inquiry['email']); ?></td>
                                    <td><?php echo htmlspecialchars($inquiry['phone'] ?: 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($inquiry['subject'] ?: 'No Subject'); ?></td>
                                    <td class="message-preview" title="<?php echo htmlspecialchars($inquiry['message']); ?>">
                                        <?php echo htmlspecialchars($inquiry['message']); ?>
                                    </td>
                                    <td><?php echo date('M j, Y g:i A', strtotime($inquiry['created_at'])); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $inquiry['is_read'] ? 'status-read' : 'status-unread'; ?>">
                                            <?php echo $inquiry['is_read'] ? 'Read' : 'Unread'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-view" onclick="viewInquiry(<?php echo htmlspecialchars(json_encode($inquiry)); ?>)" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if (!$inquiry['is_read']): ?>
                                                <a href="?mark_read=<?php echo $inquiry['id']; ?>" class="btn btn-read" title="Mark as Read">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="?delete=<?php echo $inquiry['id']; ?>" class="btn btn-delete" 
                                               onclick="return confirm('Are you sure you want to delete this inquiry?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- View Inquiry Modal -->
    <div id="inquiry-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-inquiry-title">Inquiry Details</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="inquiry-details">
                    <div class="detail-row">
                        <strong>Name:</strong>
                        <span id="modal-name"></span>
                    </div>
                    <div class="detail-row">
                        <strong>Email:</strong>
                        <span id="modal-email"></span>
                    </div>
                    <div class="detail-row">
                        <strong>Phone:</strong>
                        <span id="modal-phone"></span>
                    </div>
                    <div class="detail-row">
                        <strong>Subject:</strong>
                        <span id="modal-subject"></span>
                    </div>
                    <div class="detail-row">
                        <strong>Date:</strong>
                        <span id="modal-date"></span>
                    </div>
                    <div class="detail-row">
                        <strong>Status:</strong>
                        <span id="modal-status"></span>
                    </div>
                    <div class="detail-row message-row">
                        <strong>Message:</strong>
                        <div id="modal-message"></div>
                    </div>
                </div>
                <div class="modal-actions">
                    <button id="modal-mark-read" class="btn btn-read">Mark as Read</button>
                    <button id="modal-delete" class="btn btn-delete">Delete Inquiry</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Modal functionality
        const modal = document.getElementById('inquiry-modal');
        const closeModal = document.querySelector('.close-modal');

        // View inquiry function
        function viewInquiry(inquiry) {
            document.getElementById('modal-name').textContent = inquiry.name;
            document.getElementById('modal-email').textContent = inquiry.email;
            document.getElementById('modal-phone').textContent = inquiry.phone || 'N/A';
            document.getElementById('modal-subject').textContent = inquiry.subject || 'No Subject';
            document.getElementById('modal-date').textContent = formatDate(inquiry.created_at);
            document.getElementById('modal-message').textContent = inquiry.message;
            
            // Set status
            const statusSpan = document.getElementById('modal-status');
            statusSpan.textContent = inquiry.is_read == '1' ? 'Read' : 'Unread';
            statusSpan.className = inquiry.is_read == '1' ? 'status-read' : 'status-unread';
            
            // Set up action buttons
            const markReadBtn = document.getElementById('modal-mark-read');
            const deleteBtn = document.getElementById('modal-delete');
            
            if (inquiry.is_read == '1') {
                markReadBtn.style.display = 'none';
            } else {
                markReadBtn.style.display = 'inline-block';
                markReadBtn.onclick = () => {
                    window.location.href = `?mark_read=${inquiry.id}`;
                };
            }
            
            deleteBtn.onclick = () => {
                if (confirm('Are you sure you want to delete this inquiry?')) {
                    window.location.href = `?delete=${inquiry.id}`;
                }
            };
            
            // Show modal
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Close modal functionality
        closeModal.onclick = () => {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        };

        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        };

        // Format date function
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Close modal with Escape key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>
</html>