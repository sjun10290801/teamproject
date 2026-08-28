<?php
include_once "common.php";
include "main_top.php";

loginCheck();

$session_id = $_SESSION["id"];

// 회원 정보 불러오기
$sql = "select image, member_id, rating, juso1, juso2, juso3 from member where id = '$session_id'";
$result = mysqli_query($db, $sql);
if (!$result) exit('에러:$sql');

$row = mysqli_fetch_array($result);
$member_id = $row["member_id"];

$image = $row["image"] ?: "default_profile.jpg";
$rating = $row["rating"] ?: 0;


// 평점 개수 불러오기
$sql = "select count(*) as 'rating_count' from rating where to_member_id = $member_id";
$result = mysqli_query($db, $sql);
if (!$result) exit('에러:$sql');

$row1 = mysqli_fetch_array($result);

$count = $row1["rating_count"];

?>
<style>
    .mypage-page {
        background-color: #f0f6f5;
    }

    .mypage-tab {
        transition: 0.2s;
    }

    .mypage-tab:hover {
        color: white !important;
        background-color: #18766d !important;
        border-color: #18766d !important;
    }
</style>

<div class="mypage-page">
<main class="container py-5">
    <h2 class="text-center fw-bold mb-5">마이페이지</h2>
    <section class="card mx-auto border-0 shadow-sm rounded-4 overflow-hidden" style="max-width: 700px;">
        <div style="height: 6px; background-color: #18766d;"></div>
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">

                <!--프로필 사진 -->
                <div class="col-12 col-md-auto text-center">
                    <img src="images/<?php echo $image; ?>" alt="프로필 사진"
                        class="rounded-circle object-fit-cover border border-3 d-block mx-auto mb-3 shadow-sm"
                        style="width: 130px; height: 130px; border-color: #18766d !important;">
                    <a href="member_edit.php" class="btn btn-sm text-white px-3 myfont" style="background-color: #18766d;">
                        정보 수정
                    </a>
                </div>

                <!-- 회원 정보 -->
                <div class="col text-center text-md-start">
                    <h4 class="fw-bold mb-2"><?php echo htmlspecialchars($session_id); ?></h4>

                    <div class="d-inline-flex align-items-center gap-1 bg-light rounded-pill px-3 py-2 mb-3" aria-label="평점">
                        <i class="bi bi-star-fill text-warning"></i>
                        <strong id="rating_score" class="ms-1"><?php echo $rating; ?></strong>
                        <span class="text-secondary">(평가 <?php echo $count; ?>개)</span>
                    </div>

                    <p class="small text-secondary mb-0">
                        <i class="bi bi-geo-alt-fill me-1" style="color: #18766d;"></i>
                        <?php echo $row["juso1"] . " " . $row["juso2"] . " " . htmlspecialchars($row["juso3"]); ?>
                    </p>
                </div>

            </div>
        </div>
    </section>
    <?php
    // 현재 판매중인 상품을 불러오기 위한 sql
    $member_id = getId();
    $mypage_sql = "select product_id, name, price, image, state from product where member_id = $member_id and state != 2 limit 2";
    $mypage_result = mysqli_query($db, $mypage_sql);
    if (!$mypage_result) exit('에러:$sql');
    ?>
    <!-- 판매 중인 상품 -->
    <section class="mt-5 mx-auto" style="max-width: 650px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                판매 중인 상품
            </h4>

            <a href="member_products.php?member_id=<?php echo $member_id;?>" class="small text-secondary text-decoration-none">
                전체보기
            </a>
        </div>

        <div class="row g-3">
    <?php
        while($mypage_row = mysqli_fetch_assoc($mypage_result)) {
            $image = $mypage_row["image"] ?: "default.jpg";

    ?>
            <!-- 판매 상품 임시 카드 -->
            <div class="col-12 col-sm-6">
                <div class="text-dark">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <img src="product/<?php echo $image;?>" class="card-img-top object-fit-cover"
                            style="height: 160px;" alt="상품 이미지">

                        <div class="card-body">
                            <span class="badge rounded-pill mb-2" style="background-color: #18766d;">
                                <?php
                                    if($mypage_row["state"] == 0) {
                                        echo "판매 중";
                                    } else {
                                        echo "예약됨";
                                    }
                                ?>
                            </span>

                            <h5 class="card-title fw-semibold">
                                <?php echo htmlspecialchars($mypage_row["name"]);?>
                            </h5>

                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text fw-bold mb-0" style="color: #18766d;"><?php echo number_format($mypage_row["price"])?>원</p>
                               
                                <a href="product_edit.php?id=<?php echo $mypage_row['product_id'];?>" class="btn btn-sm rounded-pill px-3"
                                    style="color: #18766d; background-color: #eef8f6; border: 1px solid #b7ddd8;">상품 수정</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    <?php } ?>

        </div>
    </section>
    <?php
    $kind = $_GET["kind"] ?? "buy";

    // 상대방의 id(멤버), 상품정보(상품), 주문 시각(주문)을 알기 위해 테이블 3개 조인
    if ($kind == "buy") { // 구매 내역일 경우 구매자 id가 본인의 id
        $sql = "select orders.order_id, product.name, product.price, member.id, orders.reg_date, product.state, product.product_id, r.score
                    from orders inner join product on orders.product_id = product.product_id
                    inner join member on member.member_id = orders.seller_id 
                    left join rating r on r.order_id = orders.order_id where buyer_id = '$member_id' order by reg_date desc";
        $result = mysqli_query($db, $sql);
        if (!$result) exit('에러:$sql');
    } else { // 판매 내역일 경우 판매자 id가 본인의 id
        $sql = "select orders.order_id, product.name, product.price, member.id, orders.reg_date, product.state, product.product_id
                    from orders inner join product on orders.product_id = product.product_id
                    inner join member on member.member_id = orders.buyer_id where seller_id = '$member_id' order by reg_date desc";
        $result = mysqli_query($db, $sql);
        if (!$result) exit('에러:$sql');
    }

    ?>
    <div class="mt-5 mx-auto" style="max-width: 700px;">
        <h4 class="fw-bold mb-3">거래 내역</h4>

        <!-- 구매,판매 구분 버튼 -->
        <div class="d-flex gap-2 mb-4">
            <a href="member_mypage.php?kind=buy" class="btn btn-outline-secondary rounded-pill flex-fill mypage-tab">
                구매 내역
            </a>

            <a href="member_mypage.php?kind=sell" class="btn btn-outline-secondary rounded-pill flex-fill mypage-tab">
                판매 내역
            </a>
        </div>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <!-- 거래 내역 -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-3">
                <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($row["name"]); ?></h5>
                <p class="fw-bold mb-2" style="color: #18766d;"><?php echo number_format($row["price"]); ?>원</p>
                <p class="small text-secondary mb-1">
                    <i class="bi bi-person me-1"></i>
                    거래 상대방: <?php echo htmlspecialchars($row["id"]); ?>
                </p>
                <p class="small text-secondary mb-3">
                    <i class="bi bi-calendar3 me-1"></i>
                    거래 날짜: <?php echo $row["reg_date"]; ?>
                </p>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span
                        class="badge rounded-pill px-3 py-2 fw-normal"
                        style="color: #18766d; background-color: #eef8f6; border: 1px solid #b7ddd8;">
                        <?php
                        if ($row["state"] == 0) echo ("판매 중");
                        else if ($row["state"] == 1) echo ("예약됨");
                        else echo ("판매 완료");
                        ?>
                    </span>

                    <?php
                    if ($kind == "buy") {
                        if ($row["score"]) {
                    ?>
                            <span class="badge rounded-pill px-3 py-2 fw-normal"
                                style="color: #6c757d; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                                <i class="bi bi-check-circle-fill me-1" style="color: #18766d;"></i>
                                평점 완료 </span>
                        <?php
                        } else {
                        ?>
                            <a href="rating.php?id=<?php echo $row['order_id']; ?>"
                                class="btn btn-sm rounded-pill px-3 myfont"
                                style="color: #18766d; border-color: #18766d;">
                                평점 매기기 </a>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

</main>
<?php
include "main_bottom.php";
?>
