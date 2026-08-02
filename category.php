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

<ul class="nav align-items-center">
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

    <div class="card-list">
        <?php
        while($row = mysqli_fetch_assoc($result)) {
                // 채팅 리스트의 시간 표기 방식 그대로 활용
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
        <div class="card">
                <img src="product/<?php echo $product_image;?>" class="card-img-top object-fit-contain bg-light" style="height: 400px;" " alt="...">
                <div class="card-body">
                    <h5 class="card-title">
                <a href="product.php?product_id=<?php echo $row["product_id"];?>" class="text-decoration-none text-dark stretched-link"><?php echo $row["name"];?></a>
            </h5>
                    <p class="card-text"><?php echo $a_category[$row["category"]];?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $row["juso1"]." ".$row["juso2"]." ".$row["juso3"];?></li>
                    <li class="list-group-item"><?php echo $time_text;?></li>
                    <li class="list-group-item"><?php echo number_format($row["price"]);?>원</li>
                </ul>
                <div class="card-body">
                    <div class="position-relative" style="z-index: 2;">
                    <a href="#" class="card-link">찜하기</a>
                    <a href="chat_room.php?my_id=<?php echo $member_id;?>&target_id=<?php echo $row["member_id"];?>&product_id=<?php echo $row["product_id"];?>
                    " class="card-link">채팅하기</a>
                    <a href="member_profile.php?id=<?php echo $row["member_id"];?>" class="card-link">프로필보기</a>
                </div>
            </div>
            </div>
        <?php } ?>

    
        </div>
    </div>

    <?php
    echo $pagebar; ?>

<?php
    include "main_bottom.php";
?>