<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
require 'insert.php';
require 'update.php';
require 'delete.php';
require 'select.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Manager</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: #f5f5f5;
      color: #1a1a1a;
      font-size: 14px;
      padding: 40px 20px;
    }

    .wrapper {
      max-width: 860px;
      margin: 0 auto;
    }

    h1 {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 24px;
      color: #111;
    }

    .card {
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 24px;
      margin-bottom: 24px;
    }

    .card h2 {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      color: #888;
      margin-bottom: 18px;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    label {
      font-size: 12px;
      font-weight: 500;
      color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"] {
      padding: 8px 10px;
      border: 1px solid #d0d0d0;
      border-radius: 5px;
      font-size: 13px;
      font-family: inherit;
      color: #1a1a1a;
      background: #fafafa;
      outline: none;
      transition: border-color 0.15s;
    }

    input:focus {
      border-color: #2563eb;
      background: #fff;
    }

    .form-actions {
      display: flex;
      gap: 8px;
      margin-top: 4px;
      grid-column: 1 / -1;
    }

    .btn {
      padding: 8px 18px;
      border-radius: 5px;
      font-size: 13px;
      font-weight: 500;
      font-family: inherit;
      cursor: pointer;
      border: none;
      text-decoration: none;
      display: inline-block;
      transition: opacity 0.15s;
    }
    .btn:hover { opacity: 0.85; }
    .btn-primary { background: #2563eb; color: #fff; }
    .btn-secondary { background: #e5e7eb; color: #374151; }

    table { width: 100%; border-collapse: collapse; }

    th {
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #999;
      padding: 8px 12px;
      border-bottom: 1px solid #e0e0e0;
    }

    td {
      padding: 10px 12px;
      border-bottom: 1px solid #f0f0f0;
      color: #333;
      font-size: 13px;
    }

    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #fafafa; }

    .td-muted { color: #bbb; font-size: 12px; }

    .action-edit { color: #2563eb; text-decoration: none; font-weight: 500; font-size: 12px; }
    .action-edit:hover { text-decoration: underline; }
    .action-delete { color: #dc2626; text-decoration: none; font-weight: 500; font-size: 12px; }
    .action-delete:hover { text-decoration: underline; }
    .sep { color: #d0d0d0; margin: 0 4px; }

    .empty { text-align: center; padding: 30px; color: #bbb; font-size: 13px; }

    @media (max-width: 580px) {
      .form-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
<div class="wrapper">

  <h1>User Manager</h1>

  <?php
  $editUser = null;
  if (isset($_GET['edit'])) {
    $user_id = $_GET['edit'];
    // Fetch user AND their order data for pre-filling the form
    $stmt = $pdo->prepare("
      SELECT u.user_id, u.name, u.email, o.product, o.amount
      FROM users u
      LEFT JOIN orders o ON u.user_id = o.user_id
      WHERE u.user_id = ?
      LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  ?>

  <!-- FORM -->
  <div class="card">
    <h2><?= $editUser ? 'Edit User' : 'Add User' ?></h2>
    <form method="POST">
      <?php if (!empty($editUser)): ?>
        <input type="hidden" name="user_id" value="<?= $editUser['user_id'] ?>">
      <?php endif; ?>
      <div class="form-grid">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" value="<?= !empty($editUser) ? htmlspecialchars($editUser['name']) : '' ?>" placeholder="Full name" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="<?= !empty($editUser) ? htmlspecialchars($editUser['email']) : '' ?>" placeholder="email@example.com" required>
        </div>
        <div class="form-group">
          <label>Product</label>
          <input type="text" name="product" value="<?= !empty($editUser) ? htmlspecialchars($editUser['product'] ?? '') : '' ?>" placeholder="Product name" required>
        </div>
        <div class="form-group">
          <label>Amount</label>
          <input type="number" step="0.01" name="amount" value="<?= !empty($editUser) ? htmlspecialchars($editUser['amount'] ?? '') : '' ?>" placeholder="0.00" required>
        </div>
        <div class="form-actions">
          <?php if (!empty($editUser)): ?>
            <button class="btn btn-primary" type="submit" name="update">Save Changes</button>
            <a class="btn btn-secondary" href="landing.php">Cancel</a>
          <?php else: ?>
            <button class="btn btn-primary" type="submit" name="add">Add User</button>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </div>

  <!-- TABLE -->
  <div class="card">
    <h2>All Users &amp; Orders</h2>
    <?php if (empty($users)): ?>
      <div class="empty">No users yet.</div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Product</th>
          <th>Amount</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
          <td class="td-muted"><?= $user['user_id'] ?></td>
          <td><?= htmlspecialchars($user['name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= $user['product'] ? htmlspecialchars($user['product']) : '<span class="td-muted">—</span>' ?></td>
          <td><?= $user['amount'] !== null ? '$' . number_format((float)$user['amount'], 2) : '<span class="td-muted">—</span>' ?></td>
          <td>
            <a class="action-edit" href="?edit=<?= $user['user_id'] ?>">Edit</a>
            <span class="sep">|</span>
            <a class="action-delete" href="?delete=<?= $user['user_id'] ?>" onclick="return confirm('Delete this user and their orders?')">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>

</div>
</body>
</html>