<?php

include "main_top.php";
include_once "common.php";

$session_id = $_SESSION["id"] ?? "";
if ($session_id) { // 로그인한 상태라면 채팅, 찜 링크 전달용 본인 id 가져오기
  $sql = "select member_id from member where id = '$session_id'";
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

<style>
  .product-detail-card {
    max-width: 1000px;
    border: 1px solid #dceae8 !important;
  }

  .detail-accent {
    height: 6px;
    background-color: #18766d;
  }

  .detail-image-area {
    min-height: 470px;
    background-color: #f3f8f7;
  }

  .detail-product-image {
    width: 100%;
    height: 420px;
    object-fit: contain;
  }

  .detail-label {
    color: #18766d;
    font-size: 13px;
    font-weight: 700;
  }

  .seller-box {
    display: block;
    padding: 16px;
    color: #333333;
    background-color: #f3f8f7;
    border: 1px solid #dceae8;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .seller-box:hover {
    color: #18766d;
    background-color: #eef8f6;
    border-color: #b7ddd8;
  }

  .detail-action-btn {
    flex: 1 1 120px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
    padding: 10px 12px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
  }

  .detail-btn-wish {
    color: #dc3545;
    background-color: #fff5f5;
    border: 1px solid #f1b8be;
  }

  .detail-btn-wish:hover,
  .detail-btn-report:hover {
    color: #ffffff;
    background-color: #dc3545;
    border-color: #dc3545;
  }

  .detail-btn-chat {
    color: #18766d;
    background-color: #f1f8f7;
    border: 1px solid #bcdad6;
  }

  .detail-btn-chat:hover {
    color: #ffffff;
    background-color: #18766d;
    border-color: #18766d;
  }

  .detail-btn-profile {
    color: #555555;
    background-color: #ffffff;
    border: 1px solid #dddddd;
  }

  .detail-btn-profile:hover {
    color: #18766d;
    background-color: #f5fafa;
    border-color: #a8ccc8;
  }

  .detail-btn-report {
    color: #dc3545;
    background-color: #ffffff;
    border: 1px solid #f1b8be;
  }
</style>

<main class="container py-5">
  <div class="card product-detail-card mx-auto shadow-sm rounded-4 overflow-hidden">
    <div class="detail-accent"></div>

    <div class="row g-0">
      <div class="col-12 col-lg-6 detail-image-area d-flex align-items-center p-4">
        <img src="product/<?php echo $product_image; ?>" class="detail-product-image" alt="상품 이미지">
      </div>

      <div class="col-12 col-lg-6 p-4 p-lg-5">
        <p class="detail-label mb-2">상품 정보</p>
        <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($row["name"]); ?></h2>
        <p class="fs-3 fw-bold mb-4" style="color: #18766d;">
          <?php echo number_format($row["price"]); ?>원
        </p>

        <hr class="my-4" style="border-color: #dceae8; opacity: 1;">

        <div class="mb-4">
          <p class="fw-semibold mb-2">상품 설명</p>
          <p class="text-secondary mb-0" style="min-height: 72px; white-space: pre-line;"><?php echo htmlspecialchars(stripslashes($row["memo"])); ?></p>
        </div>

        <p class="small text-secondary mb-4">
          <i class="bi bi-clock me-1"></i>등록일 <?php echo $row["reg_date"]; ?>
        </p>

        <a href="member_profile.php?id=<?php echo htmlspecialchars($row["member_id"]); ?>" class="seller-box">
          <div class="d-flex align-items-center">
            <img src="images/<?php echo $member_image; ?>" alt="프로필 사진"
              class="rounded-circle object-fit-cover border me-3" style="width: 55px; height: 55px;">

            <div class="flex-grow-1" style="min-width: 0;">
              <p class="fw-bold mb-1"><?php echo htmlspecialchars($row["id"]); ?></p>
              <p class="small text-secondary text-truncate mb-0">
                <i class="bi bi-geo-alt-fill me-1"></i>
                <?php echo $row["juso1"] . " " . $row["juso2"] . " " . htmlspecialchars($row["juso3"]); ?>
              </p>
            </div>

            <div class="ms-3 text-nowrap">
              <i class="bi bi-star-fill text-warning"></i>
              <span class="fw-semibold"><?php echo $rating; ?></span>
            </div>
          </div>
        </a>
      </div>
    </div>

    <div class="card-body border-top bg-white p-4">
      <div class="position-relative d-flex flex-wrap justify-content-center gap-2 mb-3 mx-auto" style="z-index: 2; max-width: 700px;">
        <a href="good_insert.php?product_id=<?php echo $product_id; ?>" class="detail-action-btn detail-btn-wish"><i class="bi bi-heart"></i>찜하기</a>
        <a href="chat_room.php?my_id=<?php echo $member_id; ?>&target_id=<?php echo $row["member_id"]; ?>&product_id=<?php echo $product_id; ?>"
          class="detail-action-btn detail-btn-chat"><i class="bi bi-chat-dots"></i>채팅하기</a>
        <a href="member_profile.php?id=<?php echo $row["member_id"]; ?>" class="detail-action-btn detail-btn-profile"><i class="bi bi-person"></i>프로필보기</a>
        <a href="report.php?member_id=<?php echo $row["member_id"]; ?>" class="detail-action-btn detail-btn-report"><i class="bi bi-exclamation-triangle"></i>신고하기</a>
      </div>
      <div class="d-grid col-12 col-md-6 mx-auto">
        <a class="btn w-100 fw-bold text-white rounded-3 py-2" href="order_pay.php?product_id=<?php echo $product_id; ?>" style="background-color: #18766d;"><i class="bi bi-bag-check me-1"></i> 구매하기</a>
      </div>
    </div>
  </div>
</main>


<?php
include "main_bottom.php";
?>
