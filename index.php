<?php

    include "main_top.php";
    include "common.php";
    
?>


<div id="carouselExampleIndicators" class="carousel slide mt-3 mb-2">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/banner.png" class="d-block w-100 object-fit-cover" style="height: 500px;" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/banner2.png" class="d-block w-100 object-fit-cover" style="height: 500px;" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/banner3.png" class="d-block w-100 object-fit-cover" style="height: 500px;" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>



<ul class="nav align-items-center">
  <li class="nav-item">
    <span class="nav-link fw-bold text-dark ps-0">카테고리</span>
  </li>
<?php
    for($i = 1; $i < $n_category; $i++) {
?>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php?menu=<?php echo $i ?>"><?php echo $a_category[$i]; ?></a>
  </li>
<?php } ?>
  
</ul>


<div class="d-flex justify-content-end px-4 mt-3 mb-2">
      <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          정렬방법
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">최신순</a></li>
          <li><a class="dropdown-item" href="#">낮은가격순</a></li>
          <li><a class="dropdown-item" href="#">높은순</a></li>
          <li><a class="dropdown-item" href="#">추천순</a></li>
        </ul>
      </div>
    </div>
    
    <div class="card-list">
        <?php
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


            $sql = "select product_id, member_id, image, price, category, reg_date, state, juso1, juso2, juso3, name 
                    from product where state != 2 $tmp limit 12"; // limit 12로 12개만 보이도록 함.(너무 길어지는 것 방지)
            $result = mysqli_query($db, $sql);
            if(!$result) exit("에러 : $sql");

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
                <img src="product/<?php echo $product_image;?>" class="card-img-top object-fit-contain bg-light" style="height: 200px;" alt="...">
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
                    <a href="good_insert.php?product_id=<?php echo $row["product_id"];?>" class="card-link">찜하기</a>
                    <a href="chat_room.php?my_id=<?php echo $member_id;?>&target_id=<?php echo $row["member_id"];?>&product_id=<?php echo $row["product_id"];?>
                    " class="card-link">채팅하기</a>
                    <a href="member_profile.php?id=<?php echo $row["member_id"];?>" class="card-link">프로필보기</a>
                </div>
            </div>
            </div>
        <?php } ?>

        
    </div>

<div class="d-grid gap-2">
  <button class="btn btn-outline-dark" type="button">더보기</button>
</div>

    <?php
    include "main_bottom.php";
?>