<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "main_top.php";
include "common.php";

$category = $_GET["menu"];

$cookie_id = $_COOKIE["cookie_id"] ?? "";

if($cookie_id) { // 로그인한 상태라면 sql문으로 자신의 id를 조회하여 해당 상품이 안뜨도록 함.

    $sql = "select member_id from member where id = '$cookie_id'";
    $result = mysqli_query($db, $sql);

    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    $member_id = $row["member_id"];
    $tmp = "and member_id != $member_id";

} else {

    $member_id = "";
    $tmp = "";

}


$page_line = 12; // 상품 12개만 표시(페이지네이션)


$sql = "select product_id, member_id, image, price, category, reg_date, state, juso1, juso2, juso3, name
        from product
        where state != 2 $tmp and category = $category";

$args = "menu=$category";

$result = mypagination($sql, $args, $count, $pagebar);

if(!$result) exit("에러 : $sql");

?>


<style>

/* =========================================================
   카드 전체 영역
   ★ 기존 main_top.php의 .card-list와 구분하기 위해
     category.php에서 다시 설정
========================================================= */

.card-list {

    display: grid;

    grid-template-columns: repeat(4, 1fr);

    gap: 24px;

    padding: 20px 0;

}


/* =========================================================
   상품 카드
   ★ 카드 높이를 고정하지 않음
   → 하단 버튼이 잘리지 않음
========================================================= */

.card-list .card {

    width: 100%;

    height: auto;

    border: 1px solid #e5e9e8;

    border-radius: 15px;

    background-color: #fff;

    overflow: hidden;

    box-sizing: border-box;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;

}


/* =========================================================
   마우스를 올렸을 때
========================================================= */

.card-list .card:hover {

    transform: translateY(-5px);

    box-shadow:
        0 8px 22px rgba(24, 118, 109, 0.13);

}


/* =========================================================
   상품 이미지
========================================================= */

.card-list .card-img-top {

    width: 100%;

    height: 210px !important;

    object-fit: contain;

    background-color: #fafcfc !important;

    display: block;

}


/* =========================================================
   카드 내용
   ★ 기존 Bootstrap card-body의 느낌을 조금 부드럽게
========================================================= */

.card-list .card-body {

    padding: 16px 18px;

}


/* =========================================================
   상품명
========================================================= */

.card-list .card-title {

    margin-bottom: 8px;

    font-size: 17px;

    font-weight: 600;

    line-height: 1.4;

}


/* 상품명 링크 */

.card-list .card-title a {

    color: #222 !important;

    transition: 0.2s;

}


/* 상품명에 마우스를 올렸을 때 */

.card-list .card-title a:hover {

    color: #18766d !important;

}


/* =========================================================
   카테고리
========================================================= */

.card-list .card-text {

    display: inline-block;

    margin-bottom: 0;

    padding: 4px 10px;

    border-radius: 20px;

    background-color: #18766d;

    color: white;

    font-size: 12px;

}


/* =========================================================
   상품 정보 영역
   ★ 기존 list-group 느낌을 없애고 자연스럽게 표시
========================================================= */

.card-list .list-group {

    border: none;

}


/* =========================================================
   주소 / 시간 / 가격
========================================================= */

.card-list .list-group-item {

    padding: 4px 18px;

    border: none;

    background-color: transparent;

    color: #7d8785;

    font-size: 13px;

}


/* =========================================================
   가격
   ★ 가격만 강조
========================================================= */

.card-list .list-group-item:last-child {

    padding-top: 7px;

    padding-bottom: 8px;

    color: #18766d;

    font-size: 21px;

    font-weight: 700;

}


/* =========================================================
   하단 버튼 영역
   ★ 찜하기 / 채팅하기 / 프로필보기
========================================================= */

.card-list .card-body:last-child {

    padding: 12px 18px 18px;

}


/* =========================================================
   채팅 버튼
   ★ #18766d 테마
========================================================= */

.btn-chat {

    background-color: #18766d;

    border-color: #18766d;

    color: #fff;

}


/* 채팅 버튼 Hover */

.btn-chat:hover {

    background-color: #105f58;

    border-color: #105f58;

    color: #fff;

}


/* =========================================================
   버튼 공통
========================================================= */

.card-list .card-body:last-child .btn {

    font-size: 12px;

    white-space: nowrap;

}


/* =========================================================
   모바일 / 태블릿
========================================================= */

@media (max-width: 1000px) {

    .card-list {

        grid-template-columns: repeat(3, 1fr);

    }

}


@media (max-width: 750px) {

    .card-list {

        grid-template-columns: repeat(2, 1fr);

        gap: 16px;

    }

}


@media (max-width: 500px) {

    .card-list {

        grid-template-columns: 1fr;

    }

}

</style>


<!-- =========================================================
     상품 카드 목록
========================================================= -->

<div class="card-list">


<?php

while($row = mysqli_fetch_assoc($result)) {


    // 채팅 리스트의 시간 표기 방식 그대로 활용

    date_default_timezone_set('Asia/Seoul');

    $time = $row["reg_date"];

    $diff = (
        strtotime(date('Y-m-d H:i:s'))
        - strtotime($time)
    );


    if($diff >= 2678400) {

        $time_text = "1달 이상";

    } else if($diff >= 86400) {

        $time_text = floor($diff/86400)."일 전";

    } else if($diff >= 3600) {

        $time_text = floor($diff/3600)."시간 전";

    } else if($diff >= 60) {

        $time_text = floor($diff/60)."분 전";

    } else {

        $time_text = "방금";

    }


    // 상품 이미지가 없으면 기본 이미지 사용

    $product_image = $row["image"] ?: "default.jpg";

?>


    <!-- =====================================================
         상품 카드
    ====================================================== -->

    <div class="card">


        <!-- =================================================
             상품 이미지
        ================================================== -->

        <a
            href="product.php?product_id=<?php echo $row["product_id"];?>"
            class="text-decoration-none"
        >

            <img
                src="product/<?php echo $product_image;?>"
                class="card-img-top object-fit-contain bg-light"
                style="height: 200px;"
                alt="상품 이미지"
            >

        </a>


        <!-- =================================================
             상품명 / 카테고리
        ================================================== -->

        <div class="card-body">


            <!-- 상품명 -->

            <h5 class="card-title">

                <a
                    href="product.php?product_id=<?php echo $row["product_id"];?>"
                    class="text-decoration-none"
                >

                    <?php echo $row["name"];?>

                </a>

            </h5>


            <!-- 카테고리 -->

            <p class="card-text">

                <?php echo $a_category[$row["category"]];?>

            </p>


        </div>


        <!-- =================================================
             상품 상세 정보
        ================================================== -->

        <ul class="list-group list-group-flush">


            <!-- 주소 -->

            <li class="list-group-item">

                <i class="bi bi-geo-alt me-1"></i>

                <?php
                echo $row["juso1"]
                    ." "
                    .$row["juso2"]
                    ." "
                    .$row["juso3"];
                ?>

            </li>


            <!-- 등록 시간 -->

            <li class="list-group-item">

                <i class="bi bi-clock me-1"></i>

                <?php echo $time_text;?>

            </li>


            <!-- 가격 -->

            <li class="list-group-item">

                <?php echo number_format($row["price"]);?>원

            </li>


        </ul>


        <!-- =================================================
             하단 버튼 영역
             ★ 찜하기 / 채팅하기 / 프로필 보기
        ================================================== -->

        <div class="card-body">


            <div
                class="d-flex gap-2"
                style="position: relative; z-index: 2;"
            >


                <!-- =================================================
                     찜하기
                ================================================== -->

                <a
                    href="good_insert.php?product_id=<?php echo $row["product_id"]; ?>"
                    class="btn btn-outline-danger btn-sm flex-fill d-flex justify-content-center align-items-center gap-1"
                >

                    <i class="bi bi-heart"></i>

                    찜하기

                </a>


                <!-- =================================================
                     채팅하기
                ================================================== -->

                <a
                    href="chat_room.php?my_id=<?php echo $member_id;?>&target_id=<?php echo $row["member_id"];?>&product_id=<?php echo $row["product_id"];?>"
                    class="btn btn-chat btn-sm flex-fill d-flex justify-content-center align-items-center gap-1 text-decoration-none"
                >

                    <i class="bi bi-chat-dots"></i>

                    채팅하기

                </a>


                <!-- =================================================
                     프로필 보기
                ================================================== -->

                <a
                    href="member_profile.php?id=<?php echo $row["member_id"];?>"
                    class="btn btn-outline-secondary btn-sm flex-fill d-flex justify-content-center align-items-center gap-1 text-decoration-none"
                >

                    <i class="bi bi-person"></i>

                    프로필 보기

                </a>


            </div>


        </div>


    </div>


<?php

}

?>


</div>


<!-- =========================================================
     페이지네이션
========================================================= -->

<?php

echo $pagebar;

?>


<?php

include "main_bottom.php";

?>