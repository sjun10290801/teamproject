<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include "main_top.php";
    include "common.php";

    $member_id = $_GET["id"];

    // 회원 정보 가져오기
    $sql = "select * from member where member_id = $member_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit('에러:$sql');

    $row = mysqli_fetch_assoc($result);

    $image = $row["image"] ?: "default_profile.jpg";
    $rating = $row["rating"] ?: 0;

    // 평점 (n개 평가됨) 횟수 를 적기 위해 rating 테이블 가져오기
    $sql = "select count(*) as rating_count from rating where to_member_id = $member_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit('에러:$sql');

    $row1 = mysqli_fetch_assoc($result);

    $count = $row1["rating_count"];
?>
    <main class="container py-5">
        <h2 class="text-center mb-4">
            <?php echo $row["id"];?>님의 프로필
        </h2>
        <section class="card mx-auto shadow-sm" style="max-width: 650px;">
            <div class="card-body p-4">
                <div class="row align-items-center g-4">

                    <!--프로필 사진 -->
                    <div class="col-12 col-md-auto text-center">
                        <img src="images/<?php echo $image;?>" alt="프로필 사진"
                            class="rounded-circle object-fit-cover border" style="width: 120px; height: 120px;">


                    </div>

                    <!-- 회원 정보 -->
                    <div class="col text-center text-md-start">
                        <h4 class="mb-2"><?php echo $row["id"];?></h4>

                        <div class="mb-2" aria-label="평점">
                            <i class="bi bi-star-fill text-warning"></i>
                            <strong id="rating_score"><?php echo $rating;?></strong>
                            <span class="text-secondary">(평가 <?php echo $count;?>개)</span>
                        </div>

                        <p class="text-secondary mb-0">
                            <i class="bi bi-geo-alt-fill"></i>
                            <?php echo $row["juso1"]." ".$row["juso2"];?>
                        </p>
                    </div>

                </div>
            </div>
        </section>
        <div class="mt-5 mx-auto" style="max-width: 650px;">
            <h4 class="mb-3">판매 상품</h4>

            <!-- 다른 회원의 프로필이라 구매내역은 지우고 판매내역만 남겨둠 -->
            <div class="d-flex gap-2 mb-3">


                <a class="btn btn-outline-dark flex-fill">
                    판매 내역
                </a>
            </div>
            <?php
                $sql = "select * from product where member_id = $member_id and state = 2";
                $result = mysqli_query($db, $sql);
                if(!$result) exit('에러:$sql');

                while($row = mysqli_fetch_assoc($result)) {
            ?>

            <!-- 판매 내역 -->
            <div class="border rounded p-3">
                <p class="mb-1">상품명: <?php echo $row["name"];?></p>
                <p class="mb-1">가격: <?php echo number_format($row["price"]);?>원</p>
                <p class="mb-1">등록 날짜: <?php echo $row["reg_date"];?></p>

                <span class="badge text-bg-success">
                    판매 완료
                </span>
            </div>
            <?php } ?>
        </div>

        <!-- 판매중인 상품 -->
        <section class="mt-5 mx-auto" style="max-width: 650px;">
            <h4 class="mb-3">판매 중인 상품</h4>
        <?php
                $sql = "select * from product where member_id = $member_id and state != 2";
                $result = mysqli_query($db, $sql);
                if(!$result) exit('에러:$sql');

                while($row = mysqli_fetch_assoc($result)) {

                    if($row["state"] == 0) $tmp = "판매중";
                    else $tmp = "예약됨";
            ?>

            <!-- 판매 내역 -->
            <div class="border rounded p-3">
                <p class="mb-1">상품명: <?php echo $row["name"];?></p>
                <p class="mb-1">가격: <?php echo number_format($row["price"]);?>원</p>
                <p class="mb-1">등록 날짜: <?php echo $row["reg_date"];?></p>

                <span class="badge text-bg-success">
                    <?php echo $tmp; ?>
                </span>
            </div>
            <?php } 
                $sql = "select count(*) as countnum from product where member_id = $member_id and state != 2";
                $result = mysqli_query($db, $sql);
                if(!$result) exit('에러:$sql');

                $row = mysqli_fetch_assoc($result);

                if($row["countnum"] == 0) {
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