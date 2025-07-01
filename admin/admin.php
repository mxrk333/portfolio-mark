<?php
// Include database connection
require_once 'config/database.php';

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
</body>
</html>
