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
<nav>
    <ul class="pagination">
        <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">&laquo;</a>
            </li>
        <?php endif; ?>

        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">&raquo;</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>


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

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
// Search functionality
$('#searchBtn').click(function(){
    let query = $('#searchInput').val();
    window.location.href = "?search=" + encodeURIComponent(query);
});
$('#searchInput').keypress(function(e){
    if(e.which == 13){ $('#searchBtn').click(); }
});

// Reply Button Function
$(document).on('click', '.replyBtn', function(){
    let id = $(this).data('id');
    let email = $(this).data('email');
    let userMessage = $(this).data('message').toLowerCase();

    $('#reply_id').val(id);
    $('#reply_email').val(email);

    let botReply = "";

    const intents = [
        { keywords: ["price","cost","how much","charge"], response: `Hello ${email.split('@')[0]},\n\nThank you for your inquiry about pricing. Our team will provide detailed prices shortly.\n\nBest regards,\nSupport Team` },
        { keywords: ["order","delivery","ship","nationwide","shipment"], response: `Hello ${email.split('@')[0]},\n\nYes, we provide delivery across the entire country. Your order will be shipped as per our policy.\n\nBest regards,\nSupport Team` },
        { keywords: ["refund","return","cancel","replace"], response: `Hello ${email.split('@')[0]},\n\nWe have received your request about refund/return. Our support team will contact you with the next steps.\n\nBest regards,\nSupport Team` },
        { keywords: ["support","help","problem","issue","trouble"], response: `Hello ${email.split('@')[0]},\n\nThank you for contacting us. Our support team will assist you shortly.\n\nBest regards,\nSupport Team` }
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
/* Table styling */
.table {
  border-collapse: collapse !important;
  width: 100%;
}

.table th,
.table td {
  border: 1px solid #e0e0e0 !important;
  vertical-align: middle;
}

.table thead th {
  background-color: #e8f5e9 !important;
  font-weight: 600;
  text-align: center;
}

.table-hover tbody tr:hover {
  background-color: #f1f8f4 !important;
  transition: 0.3s;
}

.table-responsive {
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  overflow: hidden;
}

.shadow-sm {
  box-shadow: 0 1px 3px rgba(0,0,0,0.08) !important;
}

.pagination {
  justify-content: center;
  list-style: none;
  padding: 0;
  margin-top: 20px;
}
.pagination .page-item { display: inline-block; margin: 0 5px; }
.pagination .page-link { color: #000; text-decoration: none; padding: 0; border: none; background: none; font-weight: 500; }
.pagination .page-item.active .page-link { color: #28a745; font-weight: 700; }
.pagination .page-link:hover { color: #28a745; }
</style>
