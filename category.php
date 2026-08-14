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
             
$page_line = 12; //상품 12개만 표시(페이지네이션) 
 
$sql = "select product_id, member_id, image, price, category, reg_date, state, juso1, juso2, juso3, name  
        from product where state != 2 $tmp and category = $category"; 

$args = "menu=$category"; 

$result = mypagination($sql, $args, $count, $pagebar); 

if(!$result) exit("에러 : $sql"); 

?>


<style>

/* =========================================================
   ★ 여기부터 카드 디자인
   PHP 기능에는 영향을 주지 않음
========================================================= */


/* ---------------------------------------------------------
   카드 전체 배치
--------------------------------------------------------- */

.card-list {

    display: grid;

    grid-template-columns: repeat(4, 1fr);

    gap: 24px;

    padding: 20px 0;

}


/* ---------------------------------------------------------
   상품 카드
--------------------------------------------------------- */

.card-list .product-item {

    border: 1px solid #e2e8e6;

    border-radius: 15px;

    background: #fff;

    overflow: hidden;

    /*
       카드 높이를 고정하지 않음
       → 프로필보기까지 잘리지 않음
    */
    height: auto;

    transition: 0.2s ease;

}


/* ---------------------------------------------------------
   마우스를 올렸을 때
--------------------------------------------------------- */

.card-list .product-item:hover {

    transform: translateY(-5px);

    box-shadow: 0 8px 20px rgba(24, 118, 109, 0.12);

}


/* ---------------------------------------------------------
   이미지 영역
--------------------------------------------------------- */

.card-image {

    width: 100%;

    height: 210px;

    background: #fafcfc;

    object-fit: contain;

    display: block;

}


/* ---------------------------------------------------------
   카드 내용
--------------------------------------------------------- */

.product-content {

    padding: 17px 18px 18px;

}


/* ---------------------------------------------------------
   카테고리
--------------------------------------------------------- */

.product-category {

    display: inline-block;

    padding: 4px 10px;

    margin-bottom: 10px;

    border-radius: 20px;

    background: #18766d;

    color: white;

    font-size: 12px;

}


/* ---------------------------------------------------------
   상품명
--------------------------------------------------------- */

.product-name {

    margin: 0 0 13px;

    color: #222;

    font-size: 17px;

    font-weight: 600;

    line-height: 1.4;

    /*
       상품명이 너무 길면 2줄까지만
    */
    display: -webkit-box;

    -webkit-line-clamp: 2;

    -webkit-box-orient: vertical;

    overflow: hidden;

}


/* ---------------------------------------------------------
   가격
--------------------------------------------------------- */

.product-price {

    margin-bottom: 14px;

    color: #18766d;

    font-size: 22px;

    font-weight: 700;

}


/* ---------------------------------------------------------
   주소 / 시간
--------------------------------------------------------- */

.product-info {

    margin-bottom: 15px;

    color: #8b9593;

    font-size: 13px;

    line-height: 1.8;

}


/* 아이콘 색상 */

.product-info i {

    margin-right: 4px;

    color: #18766d;

}


/* ---------------------------------------------------------
   하단 링크
   찜 / 채팅 / 프로필
--------------------------------------------------------- */

.product-links {

    display: flex;

    gap: 15px;

    /*
       선을 넣지 않음
       → 카드가 딱딱하게 나뉘지 않음
    */
}


/* 링크 공통 */

.product-links a {

    color: #777;

    font-size: 13px;

    text-decoration: none;

    transition: 0.2s;

}


/* 마우스를 올렸을 때 */

.product-links a:hover {

    color: #18766d;

}


/* 아이콘 */

.product-links i {

    margin-right: 3px;

}


/* ---------------------------------------------------------
   화면이 작아졌을 때
--------------------------------------------------------- */

@media (max-width: 1000px) {

    .card-list {

        grid-template-columns: repeat(3, 1fr);

    }

}


/* ---------------------------------------------------------
   태블릿
--------------------------------------------------------- */

@media (max-width: 750px) {

    .card-list {

        grid-template-columns: repeat(2, 1fr);

        gap: 16px;

    }

}


/* ---------------------------------------------------------
   모바일
--------------------------------------------------------- */

@media (max-width: 500px) {

    .card-list {

        grid-template-columns: 1fr;

    }

}

</style>


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


    // 상품 이미지가 없으면 default.jpg 사용

    $product_image = $row["image"] ?: "default.jpg"; 

?>


<!-- =====================================================
     ★ 상품 카드
====================================================== -->

<div class="product-item">


    <!-- =================================================
         상품 이미지
    ================================================== -->

    <a 
        href="product.php?product_id=<?php echo $row["product_id"];?>" 
        class="text-decoration-none"
    >

        <img 
            src="product/<?php echo $product_image;?>" 
            class="card-image" 
            alt="상품 이미지"
        >

    </a>


    <!-- =================================================
         카드 내용
    ================================================== -->

    <div class="product-content">


        <!-- =================================================
             카테고리
        ================================================== -->

        <div class="product-category">

            <?php echo $a_category[$row["category"]];?>

        </div>


        <!-- =================================================
             상품명
        ================================================== -->

        <a 
            href="product.php?product_id=<?php echo $row["product_id"];?>" 
            class="text-decoration-none"
        >

            <div class="product-name">

                <?php echo $row["name"];?>

            </div>

        </a>


        <!-- =================================================
             가격
        ================================================== -->

        <div class="product-price">

            <?php echo number_format($row["price"]);?>원

        </div>


        <!-- =================================================
             위치 / 시간
        ================================================== -->

        <div class="product-info">


            <!-- 위치 -->

            <div>

                <i class="bi bi-geo-alt"></i>

                <?php 
                echo $row["juso1"]
                    ." "
                    .$row["juso2"]
                    ." "
                    .$row["juso3"];
                ?>

            </div>


            <!-- 시간 -->

            <div>

                <i class="bi bi-clock"></i>

                <?php echo $time_text;?>

            </div>


        </div>


        <!-- =================================================
             ★ 찜 / 채팅 / 프로필
             기존 기능 전부 유지
        ================================================== -->

        <div class="product-links">


            <!-- 찜하기 -->

            <a 
                href="good_insert.php?product_id=<?php echo $row["product_id"]; ?>"
            >

                <i class="bi bi-heart"></i>

                찜하기

            </a>


            <!-- 채팅하기 -->

            <a 
                href="chat_room.php?my_id=<?php echo $member_id;?>&target_id=<?php echo $row["member_id"];?>&product_id=<?php echo $row["product_id"];?>"
            >

                <i class="bi bi-chat-dots"></i>

                채팅하기

            </a>


            <!-- 프로필보기 -->

            <a 
                href="member_profile.php?id=<?php echo $row["member_id"]; ?>"
            >

                <i class="bi bi-person"></i>

                프로필보기

            </a>


        </div>


    </div>


</div>


<?php 

} 

?>


</div>


<?php 

echo $pagebar; 

?>


<?php 

include "main_bottom.php";

?>