<?php
// Đăng nhập - action = login
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    require 'db.php';
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (empty($user_name) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Vui lòng nhập đầy đủ thông tin!"]);
        exit();
    }

    $sql = "SELECT * FROM user WHERE user_name = '$user_name'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if (!$user) {
        echo json_encode(["success" => false, "message" => "Tài khoản không tồn tại!"]);
    } elseif ($user['status'] != "active") {
        echo json_encode(["success" => false, "message" => "Tài khoản đã bị khóa hoặc chưa kích hoạt!"]);
    } elseif (password_verify($password, $user['password_hash'])) {
        echo json_encode(["success" => true, "message" => "Đăng nhập thành công!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Mật khẩu không đúng!"]);
    }
    exit();
}
// Đăng ký - action = register
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    require 'db.php';
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (empty($user_name) || empty($password) || empty($email)) {
        echo json_encode(["success" => false, "message" => "Vui lòng nhập đầy đủ thông tin!"]);
        exit();
    }

    $sql = "SELECT * FROM user WHERE user_name = '$user_name' OR email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Tài khoản hoặc email đã tồn tại!"]);
        exit();
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (user_name, password_hash, email, status) VALUES ('$user_name', '$password_hash', '$email', 'active')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Đăng ký thành công!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi đăng ký: " . $conn->error]);
    }
    exit();
}
// Đăng xuất - action = logout
if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    session_start();
    session_destroy();
    echo json_encode(["success" => true, "message" => "Đăng xuất thành công!"]);
    exit();
}
//Đổi mật khẩu - action = change_password
if (isset($_POST['action']) && $_POST['action'] == 'change_password') {
    require 'db.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    if (empty($old_password) || empty($new_password)) {
        echo json_encode(["success" => false, "message" => "Vui lòng nhập đầy đủ thông tin!"]);
        exit();
    }

    $sql = "SELECT * FROM user WHERE id = '$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if (!$user) {
        echo json_encode(["success" => false, "message" => "Tài khoản không tồn tại!"]);
        exit();
    }

    if (!password_verify($old_password, $user['password_hash'])) {
        echo json_encode(["success" => false, "message" => "Mật khẩu cũ không đúng!"]);
        exit();
    }

    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password_hash = '$new_password_hash' WHERE id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Đổi mật khẩu thành công!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi đổi mật khẩu: " . $conn->error]);
    }
    exit();
}
?>