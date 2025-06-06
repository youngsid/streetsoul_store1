<?php
// ======= FILE: home.php =======

include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../../model/product.model.php";
include_once __DIR__ . "/../layout/header.php";

// Khởi tạo đối tượng Database và lấy danh sách sản phẩm
$database = new Database();
$conn = $database->conn;

// Truy vấn tất cả sản phẩm
$sql = "SELECT * FROM products"; // Giả sử bảng sản phẩm có tên là "products"
$result = $conn->query($sql);

// Kiểm tra và gán kết quả vào biến $allProducts
$allProducts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allProducts[] = $row;
    }
}

$featuredProducts = [];
$hotSaleProducts = [];

// Lọc sản phẩm nổi bật và giảm giá
foreach ($allProducts as $product) {
    if ($product['is_featured']) {
        $featuredProducts[] = $product;
    } elseif ($product['is_hot_sale']) {
        $hotSaleProducts[] = $product;
    }
}
?>

<!-- Banner -->
<div class="banner">
    <img src="public/images/Phong-cach-Streetwear.png.jpg" alt="StreetSoul Banner" class="logo">
    <h2>StreetSoul Collection</h2>
</div>

<!-- Sản phẩm nổi bật -->
<div class="container">
    <h2>Sản phẩm nổi bật</h2>
    <div class="product-list">
        <?php foreach (array_slice($featuredProducts, 0, 8) as $product): ?>
            <div class="product">
                <a href="/streestsoul_store1/view/client/productDetail.php?id=<?php echo $product['id']; ?>">
                    <img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price">
                        <?php echo number_format($product['price']); ?> VNĐ
                    </p>
                </a>
                <div class="product-buttons">
                    <form action="/streestsoul_store1/view/client/order.php" method="GET">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
                        <button type="submit" class="buy-now">Mua ngay</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Sản phẩm giảm giá -->
<div class="container">
    <div class="section-banner">
        <img src="/streestsoul_store1/public/images/banner-sale.jpg" alt="Banner giảm giá">
    </div>
    <div class="product-list">
        <?php foreach (array_slice($hotSaleProducts, 0, 8) as $product): 
            $originalPrice = $product['price'];
            $discountedPrice = $originalPrice * 0.7;
        ?>
            <div class="product">
                <a href="/streestsoul_store1/view/client/productDetail.php?id=<?php echo $product['id']; ?>">
                    <img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="original-price">
                        <?php echo number_format($originalPrice); ?> VNĐ
                    </p>
                    <p class="discounted-price">
                        <?php echo number_format($discountedPrice); ?> VNĐ
                    </p>
                </a>
                <div class="product-buttons">
                    <button class="buy-now">Mua ngay</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
