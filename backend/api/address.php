
<?php
require_once 'db.php';
//Lấy danh sách địa chỉ của khách hàng
if (isset($_GET['action']) && $_GET['action'] == 'get_addresses' && isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];
    $stmt = $conn->prepare("SELECT * FROM address WHERE customer_id = ?");
    $stmt->bind_param("s", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $addresses = [];
    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row;
    }
    echo json_encode($addresses);
    exit();
}// Thêm địa chỉ mới cho khách hàng
if (isset($_POST['action']) && $_POST['action'] == 'add_address' && isset($_POST['customer_id']) && isset($_POST['address'])) {
    $customer_id = $_POST['customer_id'];
    $address = $_POST['address'];
    $stmt = $conn->prepare("INSERT INTO address (customer_id, address) VALUES (?, ?)");
    $stmt->bind_param("ss", $customer_id, $address);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add address']);
    }
    exit();
}
// Xóa địa chỉ của khách hàng
if (isset($_POST['action']) && $_POST['action'] == 'delete_address' && isset($_POST['address_id'])) {
    $address_id = $_POST['address_id'];
    $stmt = $conn->prepare("DELETE FROM address WHERE id = ?");
    $stmt->bind_param("i", $address_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete address']);
    }
    exit();
}
// Cập nhật địa chỉ của khách hàng
if (isset($_POST['action']) && $_POST['action'] == 'update_address' && isset($_POST['address_id']) && isset($_POST['address'])) {
    $address_id = $_POST['address_id'];
    $address = $_POST['address'];
    $stmt = $conn->prepare("UPDATE address SET address = ? WHERE id = ?");
    $stmt->bind_param("si", $address, $address_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update address']);
    }
    exit();
}
// Check điều kiện nếu vượt quá số lượng địa chỉ tối đa là 3, vượt quá 3 không cho phép thêm địa chỉ mới
if (isset($_POST['action']) && $_POST['action'] == 'check_address_limit' && isset($_POST['customer_id'])) {
    $customer_id = $_POST['customer_id'];
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM address WHERE customer_id = ?");
    $stmt->bind_param("s", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['count'] >= 3) {
        echo json_encode(['status' => 'error', 'message' => 'You can only have up to 3 addresses']);
    } else {
        echo json_encode(['status' => 'success']);
    }
    exit();
}


?>