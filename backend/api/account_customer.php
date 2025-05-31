<?php
require_once 'db.php';
//Lấy thông tin người dùng từ bảng customer dựa trên user_id
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM customer WHERE user_id =.$user_id ");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['status' => 'success', 'data' => $user]);
    } else {
        echo json_encode(['status' => 'fail', 'message' => 'User not found']);
    }
}

//Lưu thông tin người dùng vào bảng customer

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $customer_name = $_POST['customer_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    
    $stmt = $pdo->prepare("UPDATE customer SET customer_name=.$user_id., email=$customer_name., phone=$phone., date_of_birth=$date_of_birth., gender=.$gender. WHERE user_id=.$user_id.");
    $result = $stmt->execute([$customer_name, $email, $phone, $date_of_birth, $gender, $user_id]);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Update successful']);
    } else {
        echo json_encode(['status' => 'fail', 'message' => 'Update failed']);
    }
}
?>
