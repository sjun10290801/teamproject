<?php

include "main_top.php";
include "common.php";

?>
<style>
  body {
    background-color: #f8f9fa;
  }

  .main-btn {
    background-color: #18766d;
    border-color: #18766d;
    color: white;
  }

  .main-btn:hover {
    background-color: #105f58;
    border-color: #105f58;
    color: white;
  }

  .category-link:hover {
    color: #18766d !important;
    background-color: #e8f4f2;
  }
  .section-title {
    border-left: 5px solid #18766d;
    padding-left: 12px;
}
</style>

<ul class="nav justify-content-center align-items-center gap-2 py-3 border-bottom bg-white">
  <li class="nav-item">
    <span class="nav-link fw-bold text-dark ps-0">카테고리</span>
  </li>

  <?php
  for ($i = 1; $i < $n_category; $i++) {
  ?>
    <li class="nav-item">
      <a class="nav-link text-secondary rounded-pill px-3 category-link"
        href="category.php?menu=<?php echo $i; ?>">
        <?php echo $a_category[$i]; ?>
      </a>
    </li>
  <?php } ?>
</ul>



<div class="d-flex justify-content-between align-items-center px-4 mt-4 mb-3">
  <h4 class="mb-0 fw-bold section-title">최근 등록된 상품</h4>

<select class="form-select w-auto" aria-label="Default select example">
    <option value="" selected disabled>정렬방법</option>
    <option value="reporter">최신순</option>
    <option value="reported">낮은가격순</option>
    <option value="reporter">높은순</option>
    <option value="reporter">낮은순</option>
  </select>
</div>

<div class="card-list">
  <?php
  $cookie_id = $_COOKIE["cookie_id"] ?? "";
  if ($cookie_id) { // 로그인한 상태라면 sql문으로 자신의 id를 조회하여 해당 상품이 안뜨도록 함.
    $sql = "select member_id from member where id = '$cookie_id'";
    $result = mysqli_query($db, $sql);
    if (!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);
    $member_id = $row["member_id"];
    $tmp = "and member_id != $member_id";
  } else {
    $member_id = "";
    $tmp = "";
  }


  $sql = "select product_id, member_id, image, price, category, reg_date, state, juso1, juso2, juso3, name 
                    from product where state != 2 $tmp order by product_id desc limit 12"; // limit 12로 12개만 보이도록 함.(너무 길어지는 것 방지)
  $result = mysqli_query($db, $sql);
  if (!$result) exit("에러 : $sql");

  while ($row = mysqli_fetch_assoc($result)) {
    // 채팅 리스트의 시간 표기 방식 그대로 활용
    date_default_timezone_set('Asia/Seoul');
    $time = $row["reg_date"];
    $diff = (strtotime(date('Y-m-d H:i:s')) - strtotime($time));
    if ($diff >= 2678400) {
      $time_text = "1달 이상";
    } else if ($diff >= 86400) {
      $time_text = floor($diff / 86400) . "일 전";
    } else if ($diff >= 3600) {
      $time_text = floor($diff / 3600) . "시간 전";
    } else if ($diff >= 60) {
      $time_text = floor($diff / 60) . "분 전";
    } else {
      $time_text = "방금";
    }

    $product_image = $row["image"] ?: "default.jpg";
  ?>
    <div class="card h-100 border-0 shadow-sm">
      <img src="product/<?php echo $product_image; ?>" class="card-img-top object-fit-contain bg-light" style="height: 200px;" alt="...">
      <div class="card-body">
        <h5 class="card-title">
          <a href="product.php?product_id=<?php echo $row["product_id"]; ?>" class="text-decoration-none text-dark stretched-link"><?php echo $row["name"]; ?></a>
        </h5>
        <p class="card-text"><?php echo $a_category[$row["category"]]; ?></p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><?php echo $row["juso1"] . " " . $row["juso2"] . " " . $row["juso3"]; ?></li>
        <li class="list-group-item"><?php echo $time_text; ?></li>
        <li class="list-group-item"><?php echo number_format($row["price"]); ?>원</li>
      </ul>
      <div class="card-body">
        <div class="position-relative" style="z-index: 2;">
          <a href="good_insert.php?product_id=<?php echo $row["product_id"]; ?>" class="card-link">찜하기</a>
          <a href="chat_room.php?my_id=<?php echo $member_id; ?>&target_id=<?php echo $row["member_id"]; ?>&product_id=<?php echo $row["product_id"]; ?>
                    " class="card-link">채팅하기</a>
          <a href="member_profile.php?id=<?php echo $row["member_id"]; ?>" class="card-link">프로필보기</a>
        </div>
      </div>
    </div>
  <?php } ?>


</div>

<div class="d-grid gap-2">
  <button class="btn main-btn py-2" type="button">더보기</button>
</div>

<?php
include "main_bottom.php";
?>
