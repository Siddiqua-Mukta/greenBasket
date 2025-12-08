<?php
include '../db_connect.php';
include 'session.php';
include 'includes/header.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search query
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Count total messages
if($search != ''){
    $total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM contact_messages 
        WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR message LIKE '%$search%'");
    $total_row = mysqli_fetch_assoc($total_result);
    $total_messages = $total_row['total'];

    $result = mysqli_query($conn, "SELECT * FROM contact_messages 
        WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR message LIKE '%$search%' 
        ORDER BY id DESC LIMIT $offset, $limit");
} else {
    $total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM contact_messages");
    $total_row = mysqli_fetch_assoc($total_result);
    $total_messages = $total_row['total'];

    $result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC LIMIT $offset, $limit");
}

$total_pages = ceil($total_messages / $limit);
?>

<div class="container mt-4">
  <h3 class="text-success fw-bold mb-3">Contact Messages</h3>

  <!-- Search Bar -->
  <div class="input-group mb-3">
    <input type="text" id="searchInput" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by name, email or message...">
    <button class="btn btn-success" id="searchBtn" type="button"><i class="bi bi-search"></i></button>
  </div>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-success">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td class='text-start ps-3'>{$row['name']}</td>
                        <td class='text-start ps-3'>{$row['email']}</td>
                        <td class='text-start ps-3'>{$row['message']}</td>
                        <td>
                          <button class='btn btn-primary btn-sm replyBtn'
                              data-id='{$row['id']}'
                              data-email='{$row['email']}'
                              data-message='{$row['message']}'>
                              Reply
                          </button>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-muted'>No messages found!</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <nav class="mt-3 text-center">
    <?php if($page > 1): ?>
      <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>" class="btn btn-outline-success mx-1">&lt;</a>
    <?php endif; ?>

    <span>Page <?= $page ?> of <?= $total_pages ?></span>

    <?php if($page < $total_pages): ?>
      <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>" class="btn btn-outline-success mx-1">&gt;</a>
    <?php endif; ?>
  </nav>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="replyForm" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Reply to Message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="id" id="reply_id">
        <div class="mb-3">
          <label class="form-label">To</label>
          <input type="email" id="reply_email" class="form-control" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">Message</label>
          <textarea name="reply_message" id="reply_message" class="form-control" rows="6" required></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Send Reply</button>
      </div>
    </form>
  </div>
</div>

<?php //include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Search button and Enter key
$('#searchBtn').click(function(){
    let query = $('#searchInput').val();
    window.location.href = "?search=" + encodeURIComponent(query);
});
$('#searchInput').keypress(function(e){
    if(e.which == 13){ $('#searchBtn').click(); }
});

// Smart Auto-Bot Reply
$(document).on('click', '.replyBtn', function(){
    let id = $(this).data('id');
    let email = $(this).data('email');
    let userMessage = $(this).data('message').toLowerCase();

    $('#reply_id').val(id);
    $('#reply_email').val(email);

    let botReply = "";

    const intents = [
        { keywords: ["price", "cost", "how much", "charge"], response: `Hello ${email.split('@')[0]},\n\nThank you for your inquiry about pricing. Our team will provide detailed prices shortly.\n\nBest regards,\nSupport Team` },
        { keywords: ["order", "delivery", "ship", "nationwide", "shipment"], response: `Hello ${email.split('@')[0]},\n\nYes, we provide delivery across the entire country. Your order will be shipped to your location as per our delivery policy.\n\nBest regards,\nSupport Team` },
        { keywords: ["refund", "return", "cancel", "replace"], response: `Hello ${email.split('@')[0]},\n\nWe have received your request about refund/return. Our support team will contact you with the next steps.\n\nBest regards,\nSupport Team` },
        { keywords: ["support", "help", "problem", "issue", "trouble"], response: `Hello ${email.split('@')[0]},\n\nThank you for contacting us. Our support team will assist you with your issue shortly.\n\nBest regards,\nSupport Team` }
    ];

    let found = false;
    for(let i=0;i<intents.length;i++){
        for(let j=0;j<intents[i].keywords.length;j++){
            if(userMessage.includes(intents[i].keywords[j])){
                botReply = intents[i].response;
                found = true;
                break;
            }
        }
        if(found) break;
    }

    if(!found){
        botReply = `Hello ${email.split('@')[0]},\n\nThank you for reaching out. We have received your message:\n"${userMessage}"\nOur team will get back to you shortly.\n\nBest regards,\nSupport Team`;
    }

    $('#reply_message').val(botReply);
    new bootstrap.Modal(document.getElementById('replyModal')).show();
});

// AJAX submit reply
$('#replyForm').submit(function(e){
    e.preventDefault();
    let id = $('#reply_id').val();
    let reply_message = $('#reply_message').val();

    $.ajax({
        url: 'send_reply.php',
        method: 'POST',
        data: { id: id, message: reply_message },
        success: function(){
            alert('Reply sent successfully!');
            $('#replyModal').modal('hide');
        },
        error: function(){
            alert('Error sending reply.');
        }
    });
});
</script>

<style>
.table-hover tbody tr:hover { background-color: #d4edda; transition: 0.3s; }
.table-responsive { border-radius: 12px; overflow: hidden; }
</style>
