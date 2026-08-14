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
/* 카드 컨테이너 */
.custom-card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 24px;
  padding: 20px 0;
}

/* 상품 카드 디자인 */
.product-card {
  border-radius: 12px;
  border: 1px solid #e9ecef;
  background-color: #fff;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  overflow: hidden;
  position: relative;
}

/* 호버 시 떠오르는 효과 */
.product-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}

/* 상품 이미지 영역 */
.product-card .img-wrapper {
  position: relative;
  width: 100%;
  padding-top: 75%; /* 4:3 비율 */
  background-color: #f8f9fa;
}

.product-card .img-wrapper img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* 카테고리 뱃지 */
.category-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background-color: rgba(0, 0, 0, 0.6);
  color: white;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 500;
  z-index: 2;
}

/* 텍스트 말줄임 (2줄 제한) */
.text-truncate-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: normal;
  line-height: 1.4;
  height: 2.8em;
}

/* 가격 및 부가 정보 텍스트 */
.price-text {
  color: #18766d;
  font-size: 1.25rem;
  font-weight: 700;
}

.meta-text {
  font-size: 0.85rem;
  color: #868e96;
}

/* 카드 하단 버튼 */
.btn-chat {
  background-color: #18766d;
  color: white;
  border: none;
}
.btn-chat:hover {
  background-color: #105f58;
  color: white;
}
</style>

<ul class="nav justify-content-center align-items-center gap-2 py-3 border-bottom bg-white w-100">
  <li class="nav-item">
    <span class="nav-link fw-bold text-dark ps-0">카테고리</span>
  </li>
<?php
    for($i = 1; $i < $n_category; $i++) {
        if($i == $category) $tmp = "color='blue'";
        else $tmp = "";
?>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php?menu=<?php echo $i ?>"><font <?php echo $tmp; ?>><?php echo $a_category[$i]; ?></font></a>
  </li>
<?php } ?>
</ul>

<div class="custom-card-grid px-2">
    <?php
    while($row = mysqli_fetch_assoc($result)) {
        date_default_timezone_set('Asia/Seoul');
        $time = $row["reg_date"];
        $diff = (strtotime(date('Y-m-d H:i:s')) - strtotime($time));
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

        $product_image = $row["image"] ?: "default.jpg";
    ?>
    
    <div class="product-card">
        <!-- 이미지 영역 -->
        <a href="product.php?product_id=<?php echo $row["product_id"];?>" class="text-decoration-none">
            <div class="img-wrapper">
                <span class="category-badge"><?php echo $a_category[$row["category"]];?></span>
                <img src="product/<?php echo $product_image;?>" alt="상품 이미지">
            </div>
        </a>

        <!-- 내용 영역 -->
        <div class="p-3 d-flex flex-column h-100">
            <!-- 상품명 -->
            <a href="product.php?product_id=<?php echo $row["product_id"];?>" class="text-decoration-none text-dark">
                <h6 class="text-truncate-2 mb-2 fw-bold"><?php echo $row["name"];?></h6>
            </a>
            
            <!-- 가격 -->
            <div class="price-text mb-3">
                <?php echo number_format($row["price"]);?>원
            </div>
            
            <!-- 지역 및 시간 정보 (아이콘 활용) -->
            <div class="meta-text mb-3 d-flex flex-column gap-1">
                <div><i class="bi bi-geo-alt me-1"></i><?php echo $row["juso1"]." ".$row["juso2"];?></div>
                <div><i class="bi bi-clock me-1"></i><?php echo $time_text;?></div>
            </div>
            
            <!-- 하단 버튼 영역 -->
            <div class="d-flex gap-2 mt-auto pt-2 border-top">
                <a href="#" class="btn btn-outline-danger btn-sm w-50 d-flex justify-content-center align-items-center gap-1">
                    <i class="bi bi-heart"></i> 찜
                </a>
                <a href="chat_room.php?my_id=<?php echo $member_id;?>&target_id=<?php echo $row["member_id"];?>&product_id=<?php echo $row["product_id"];?>" class="btn btn-chat btn-sm w-50 d-flex justify-content-center align-items-center gap-1 text-decoration-none">
                    <i class="bi bi-chat-dots"></i> 채팅
                </a>
            </div>
        </div>
    </div>
    
    <?php } ?>
</div>

    <?php
    echo $pagebar; ?>

<?php
    include "main_bottom.php";
?>