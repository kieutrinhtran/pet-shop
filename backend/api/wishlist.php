<?php
// wishlist.php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', '', 'petshop'); // sửa lại config nếu cần

if ($conn->connect_error) {
    die(json_encode(['status' => 0, 'msg' => 'DB Connection failed']));
}

// GET: Lấy danh sách wishlist (pagination)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = intval($_GET['user_id']);
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $size = isset($_GET['size']) ? max(1, intval($_GET['size'])) : 10;
    $offset = ($page - 1) * $size;

    $sql = "SELECT w.product_id, w.quantity, p.name, p.image_url, p.price, 
                   (p.price * w.quantity) AS total_price
            FROM wishlist w 
            JOIN product p ON w.product_id = p.product_id
            WHERE w.user_id = ?
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $user_id, $offset, $size);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    // Tính tổng số sản phẩm cho phân trang
    $countSql = "SELECT COUNT(*) as total FROM wishlist WHERE user_id = ?";
    $countStmt = $conn->prepare($countSql);
    $countStmt->bind_param('i', $user_id);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $total = $countResult->fetch_assoc()['total'];

    echo json_encode([
        'status' => 1,
        'data' => $items,
        'page' => $page,
        'total' => $total,
        'pages' => ceil($total / $size)
    ]);
    exit();
}

// POST: Thêm hoặc xoá sản phẩm wishlist
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $product_id = intval($_POST['product_id']);

    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        // Xoá
        $sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $user_id, $product_id);
        $stmt->execute();
        echo json_encode(['status' => 1, 'msg' => 'Deleted']);
        exit();
    } else {
        // Thêm mới
        // Check đã có trong wishlist chưa
        $checkSql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param('ii', $user_id, $product_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
            echo json_encode(['status' => 0, 'msg' => 'Already in wishlist']);
            exit();
        }
        // Thêm vào wishlist
        $insertSql = "INSERT INTO wishlist (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param('ii', $user_id, $product_id);
        $insertStmt->execute();
        echo json_encode(['status' => 1, 'msg' => 'Added']);
        exit();
    }
}

echo json_encode(['status' => 0, 'msg' => 'Invalid request']);
