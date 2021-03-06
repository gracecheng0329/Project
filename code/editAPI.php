<?php
require __DIR__ . '/parts/__connect db.php';
require __DIR__ . '/parts/__admin_required.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

// TODO: 檢查資料格式
// email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
// mobile_pattern = /^09\d{2}-?\d{3}-?\d{3}$/;

if (empty($_POST['sid'])) {
    $output['code'] = 405;
    $output['error'] = '沒有 sid';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match('^[A-Z]', $_POST['productName'])) {
    $output['code'] = 410;
    $output['error'] = '請輸入正確品名';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (!preg_match('^[A-Z]', $_POST['designer'])) {
    $output['code'] = 420;
    $output['error'] = '請輸入正確設計師';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (!preg_match('^[A-Z]', $_POST['origin'])) {
    $output['code'] = 430;
    $output['error'] = '請輸入正確產地';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (!preg_match('\d', $_POST['price'])) {
    $output['code'] = 440;
    $output['error'] = '請輸入正確金額';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

// `sid`, `product_sid`, `designer_sid`, `productName`, `designer`, `description`, `Origin`, `Dimensions`, `detailPics`, `price`, `favorite`, `visible`  
$sql = "UPDATE `products` SET 
    `productName`=?,
    `designer`=?,
    `description`=?,
    `Origin`=?,
    `Dimensions`=?
    `detailPics`=?
    `price`=?
    WHERE `sid`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['productName'],
    $_POST['designer'],
    $_POST['description'],
    $_POST['Origin'],
    $_POST['Dimensions'],
    $_POST['detailPics'],
    $_POST['price'],
    $_POST['sid'],
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
