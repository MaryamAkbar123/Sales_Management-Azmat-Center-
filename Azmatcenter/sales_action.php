<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garments_shop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Get the action from POST request
$action = $_POST['action'] ?? '';

if ($action === 'insert') {
    $product_name = sanitizeInput($_POST['product_name']);
    $retail_price = floatval($_POST['retail_price']);
    $sale_price = floatval($_POST['sale_price']);
    $profit = $sale_price - $retail_price;
    $sale_date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO sales (product_name, retail_price, sale_price, profit, sale_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sddds", $product_name, $retail_price, $sale_price, $profit, $sale_date);
    $stmt->execute();

    echo "Sale added successfully!";
} elseif ($action === 'update') {
    $id = intval($_POST['id']);
    $product_name = sanitizeInput($_POST['product_name']);
    $retail_price = floatval($_POST['retail_price']);
    $sale_price = floatval($_POST['sale_price']);
    $profit = $sale_price - $retail_price;

    $stmt = $conn->prepare("UPDATE sales SET product_name = ?, retail_price = ?, sale_price = ?, profit = ? WHERE id = ?");
    $stmt->bind_param("sdddi", $product_name, $retail_price, $sale_price, $profit, $id);
    $stmt->execute();

    echo "Sale updated successfully!";
} elseif ($action === 'delete') {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM sales WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "Sale deleted successfully!";
} elseif ($action === 'load') {
    $filter = sanitizeInput($_POST['filter'] ?? '');
    $query = "SELECT * FROM sales";

    if ($filter === 'daily') {
        $query .= " WHERE sale_date = CURDATE()";
    } elseif ($filter === 'monthly') {
        $query .= " WHERE MONTH(sale_date) = MONTH(CURDATE()) AND YEAR(sale_date) = YEAR(CURDATE())";
    } elseif ($filter === 'yearly') {
        $query .= " WHERE YEAR(sale_date) = YEAR(CURDATE())";
    }

    $query .= " ORDER BY sale_date DESC";
    $result = $conn->query($query);

    $output = '';
    $totalSales = $totalProfit = 0;

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row['product_name']) . "</td>
                        <td>" . number_format($row['retail_price'], 2) . "</td>
                        <td>" . number_format($row['sale_price'], 2) . "</td>
                        <td>" . number_format($row['profit'], 2) . "</td>
                        <td>" . htmlspecialchars($row['sale_date']) . "</td>
                        <td>
                            <button class='update-btn' data-id='" . $row['id'] . "'>Edit</button>
                            <button class='delete-btn' data-id='" . $row['id'] . "'>Delete</button>
                        </td>
                    </tr>";
        $totalSales += $row['sale_price'];
        $totalProfit += $row['profit'];
    }

    echo json_encode(['data' => $output, 'totalSales' => $totalSales, 'totalProfit' => $totalProfit]);
}
?>
