<?php
include_once "common.php";
include "main_top.php";

loginCheck();

$my_id = $_GET["member_id"];
$member_id = getId();

//권한 검사
if($my_id != $member_id) {
    echo("<script>alert('권한이 없습니다');</script>");
    echo("<script>history.back();</script>");
    exit();
}

$sql = "select product_id, name, price, image, state from product where member_id = $member_id and state != 2";
$result = mysqli_query($db, $sql);
if (!$result) exit('에러:$sql');
?>

<style>
    .product-page {
        background-color: #f0f6f5;
    }
</style>

<div class="product-page">
<main class="container py-5">
    <div class="mx-auto" style="max-width: 1000px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">판매 중인 상품</h2>
                <p class="text-secondary mb-0">내가 등록한 상품을 확인할 수 있습니다.</p>
            </div>

            <a href="member_mypage.php" class="btn text-white rounded-pill px-3"
                style="background-color: #18766d;">
                마이페이지
            </a>
        </div>

    
        <!-- 백엔드 연결 시 아래 상품 카드를 반복 출력 -->
        <div class="row g-4">
    <?php while($row = mysqli_fetch_assoc($result)) {
            $image = $row["image"] ?: "default.jpg";
    ?>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-dark">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <img src="product/<?php echo $image;?>" class="card-img-top object-fit-cover"
                            style="height: 190px;" alt="상품 이미지">

                        <div class="card-body">
                            <span class="badge rounded-pill mb-2" style="background-color: #18766d;">
                                <?php
                                    if($row["state"] == 0) {
                                        echo "판매 중";
                                    } else {
                                        echo "예약됨";
                                    }
                                ?>
                            </span>
                            <h5 class="card-title fw-semibold"><?php echo htmlspecialchars($row["name"]);?></h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text fw-bold mb-0" style="color: #18766d;"><?php echo number_format($row["price"])?>원</p>
                                <a href="product_edit.php?id=<?php echo $row['product_id'];?>" class="btn btn-sm rounded-pill px-3"
                                    style="color: #18766d; background-color: #eef8f6; border: 1px solid #b7ddd8;">상품 수정</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php } ?>
           
        </div>
    </div>
</div>
</main>

<?php
include "main_bottom.php";
?>
