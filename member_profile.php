<?php
include "main_top.php";
include_once "common.php";

$member_id = $_GET["id"];

// 회원 정보 가져오기
$sql = "select image, rating, juso1, juso2, juso3, id from member where member_id = $member_id";
$result = mysqli_query($db, $sql);
if (!$result) exit('에러:$sql');

$row = mysqli_fetch_assoc($result);

$image = $row["image"] ?: "default_profile.jpg";
$rating = $row["rating"] ?: 0;

// 평점 (n개 평가됨) 횟수 를 적기 위해 rating 테이블 가져오기
$sql = "select count(*) as rating_count from rating where to_member_id = $member_id";
$result = mysqli_query($db, $sql);
if (!$result) exit('에러:$sql');

$row1 = mysqli_fetch_assoc($result);

$count = $row1["rating_count"];
?>
<main class="container py-5">
    <h2 class="text-center fw-bold mb-5">
        <?php echo htmlspecialchars($row["id"]); ?>님의 프로필
    </h2>
    <section class="card mx-auto border-0 shadow-sm rounded-4 overflow-hidden" style="max-width: 700px;">
        <div style="height: 6px; background-color: #18766d;"></div>
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">

                <!--프로필 사진 -->
                <div class="col-12 col-md-auto text-center">
                    <img src="images/<?php echo $image; ?>" alt="프로필 사진"
                        class="rounded-circle object-fit-cover border border-3 shadow-sm"
                        style="width: 130px; height: 130px; border-color: #18766d !important;">


                </div>

                <!-- 회원 정보 -->
                <div class="col text-center text-md-start">
                    <h4 class="fw-bold mb-2"><?php echo htmlspecialchars($row["id"]); ?></h4>

                    <div class="d-inline-flex align-items-center gap-1 bg-light rounded-pill px-3 py-2 mb-3" aria-label="평점">
                        <i class="bi bi-star-fill text-warning"></i>
                        <strong id="rating_score" class="ms-1"><?php echo $rating; ?></strong>
                        <span class="text-secondary">(평가 <?php echo $count; ?>개)</span>
                    </div>

                    <p class="small text-secondary mb-0">
                        <i class="bi bi-geo-alt-fill me-1" style="color: #18766d;"></i>
                        <?php echo $row["juso1"] . " " . $row["juso2"]; ?>
                    </p>
                </div>

            </div>
        </div>
    </section>
    <div class="mt-5 mx-auto" style="max-width: 700px;">
        <h4 class="fw-bold mb-3">판매 완료 상품</h4>


        <?php
        $sql = "select * from product where member_id = $member_id and state = 2";
        $result = mysqli_query($db, $sql);
        if (!$result) exit('에러:$sql');

        while ($row = mysqli_fetch_assoc($result)) {
        ?>

            <!-- 판매 내역 -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-3">
                <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($row["name"]); ?></h5>
                <p class="fw-bold mb-2" style="color: #18766d;"><?php echo number_format($row["price"]); ?>원</p>
                <p class="small text-secondary mb-3">
                    <i class="bi bi-calendar3 me-1"></i>
                    등록 날짜: <?php echo $row["reg_date"]; ?>
                </p>

                <span
                    class="badge rounded-pill align-self-start px-3 py-2 fw-normal"
                    style="color: #6c757d; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                    판매 완료
                </span>
            </div>
        <?php } ?>
    </div>

    <!-- 판매중인 상품 -->
    <section class="mt-5 mx-auto" style="max-width: 700px;">
        <h4 class="fw-bold mb-3">판매 중인 상품</h4>
        <?php
        $sql = "select * from product where member_id = $member_id and state != 2";
        $result = mysqli_query($db, $sql);
        if (!$result) exit('에러:$sql');

        while ($row = mysqli_fetch_assoc($result)) {

            if ($row["state"] == 0) $tmp = "판매중";
            else $tmp = "예약됨";
        ?>

            <!-- 판매 내역 -->
            <div class="card border-0 shadow-sm rounded-3 position-relative p-4 mb-3" style="cursor: pointer;">
                <h5 class="fw-bold mb-2">
                    <a href="product.php?product_id=<?php echo $row["product_id"]; ?>"
                        class="text-dark text-decoration-none stretched-link">
                        <?php echo htmlspecialchars($row["name"]); ?>
                    </a>
                </h5>
                <p class="fw-bold mb-2" style="color: #18766d;">
                    <?php echo number_format($row["price"]); ?>원
                </p>
                <p class="small text-secondary mb-3">
                    <i class="bi bi-calendar3 me-1"></i>
                    등록 날짜: <?php echo $row["reg_date"]; ?>
                </p>

                <span class="badge rounded-pill align-self-start px-3 py-2 fw-normal"
                    style="color: #18766d; background-color: #eef8f6; border: 1px solid #b7ddd8;">
                    <?php echo $tmp; ?>
                </span>
            </div>
        <?php }
        $sql = "select count(*) as countnum from product where member_id = $member_id and state != 2";
        $result = mysqli_query($db, $sql);
        if (!$result) exit('에러:$sql');

        $row = mysqli_fetch_assoc($result);

        if ($row["countnum"] == 0) {
        ?>
            <p class="text-secondary">
                판매 중인 상품이 없습니다.
            </p>
        <?php
        }
        ?>
    </section>

</main>
<?php
include "main_bottom.php";
?>