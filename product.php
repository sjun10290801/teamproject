<?php

include "main_top.php";
include "common.php";

$cookie_id = $_COOKIE["cookie_id"] ?? "";
if ($cookie_id) { // 로그인한 상태라면 채팅, 찜 링크 전달용 본인 id 가져오기
  $sql = "select member_id from member where id = '$cookie_id'";
  $result = mysqli_query($db, $sql);
  if (!$result) exit("에러 : $sql");

  $row = mysqli_fetch_assoc($result);
  $member_id = $row["member_id"];
} else {
  $member_id = "";
}

$product_id = $_GET["product_id"];

// 상품 조회수 증가
$sql = "update product set view = view + 1 where product_id = $product_id";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");

// 상품 id에 해당하는 상품의 상세, 올린 회원의 정보 표시
$sql = "select p.name, p.price, p.memo, p.reg_date, p.member_id, m.id, p.juso1, p.juso2, p.juso3, p.image, m.image as member_image , m.rating
          from product p inner join member m on p.member_id = m.member_id where product_id = $product_id";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");

$row = mysqli_fetch_assoc($result);

$product_image = $row["image"] ?: "default.jpg";
$member_image = $row["member_image"] ?: "default_profile.jpg";
$rating = $row["rating"] ?: 0;
?>

<main class="container py-5">
  <div class="card mx-auto shadow-sm" style="max-width: 900px;">
    <div class="row g-0">
      <div class="col-12 col-md-6">
        <img src="product/<?php echo $product_image; ?>" class="card-img-top object-fit-contain bg-light" style="height: 400px;" alt="...">
      </div>
      <div class="col-12 col-md-6">
        <div class="card-body text-center border-bottom ">

          <div class="col-12 col-md-auto text-center mx-auto mb-3">
            <a href="member_profile.php?id=<?php echo $row["member_id"]; ?>">
              <img src="images/<?php echo $member_image; ?>" alt="프로필 사진" class="rounded-circle object-fit-cover border" style="width: 70px; height: 70px;">
            </a>
          </div>

          <h5 class="card-title"><?php echo $row["id"]; ?></h5>
          <div class="mb-2">
            <i class="bi bi-star-fill text-warning"></i>
            <span><?php echo $rating; ?></span>
          </div>
          <p class="card-text text-secondary">
            <i class="bi bi-geo-alt-fill"></i>
            <?php echo $row["juso1"] . " " . $row["juso2"] . " " . $row["juso3"]; ?>
          </p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item fw-bold fs-5"><?php echo $row["name"]; ?></li>
          <li class="list-group-item fw-bold fs-4" style="color: #18766d;"><?php echo number_format($row["price"]); ?>원</li>
          <li class="list-group-item">등록일 : <?php echo $row["reg_date"]; ?></li>
          <li class="list-group-item"><?php echo stripslashes($row["memo"]); ?></li>
        </ul>
      </div>
    </div>
    <div class="card-body">
      <div class="position-relative d-flex flex-wrap justify-content-center gap-2 mb-3" style="z-index: 2;">
       <a href="good_insert.php?product_id=<?php echo $product_id; ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-heart"></i> 찜하기</a>
        <a href="chat_room.php?my_id=<?php echo $member_id; ?>&target_id=<?php echo $row["member_id"]; ?>&product_id=<?php echo $product_id; ?>"
          class="btn btn-sm btn-outline-dark"><i class="bi bi-chat-dots"></i>채팅하기</a>
        <a href="member_profile.php?id=<?php echo $row["member_id"]; ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-person"></i>프로필보기</a>
        <a href="report.php?member_id=<?php echo $row["member_id"]; ?>" class="card-link text-decoration-none text-danger"><i class="bi bi-exclamation-triangle"></i>신고하기</a>
      </div>


      <div class="d-grid gap-2 col-6 mx-auto">
        <a class="btn w-100 fw-bold text-white" href="order_pay.php?product_id=<?php echo $product_id; ?>" style="background-color: #18766d;"><i class="bi bi-bag-check"></i>구매하기</a>
      </div>

    </div>
  </div>
</main>


<?php
include "main_bottom.php";
?>