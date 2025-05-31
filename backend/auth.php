<?php


require_once 'db.php';
$action = $_SERVER['REQUEST_METHOD'] === 'POST' ? ($_POST['action'] ?? '') : '';

if ($action === 'register') {
    // đăng ký
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = 'INSERT INTO user_account (user_id, user_name, password_hash, role, status, created_at) VALUES (UUID(), ?, ?, "user", "active", NOW())';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $password]);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'login') {
    // đăng nhập
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT user_id, password_hash FROM user_account WHERE user_name = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        echo json_encode(['success' => true]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
    }
    exit;
}

if ($action === 'change_password') {
    // đổi mật khẩu
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) { http_response_code(401); echo json_encode(['error'=>'Unauthorized']); exit; }
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $stmt = $pdo->prepare('SELECT password_hash FROM user_account WHERE user_id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    if ($user && password_verify($old, $user['password_hash'])) {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $upd = $pdo->prepare('UPDATE user_account SET password_hash = ? WHERE user_id = ?');
        $upd->execute([$hash, $userId]);
        echo json_encode(['success'=>true]);
    } else {
        http_response_code(400);
        echo json_encode(['error'=>'Current password incorrect']);
    }
    exit;
}

http_response_code(400);
echo json_encode(['error'=>'Invalid action']);
?>
