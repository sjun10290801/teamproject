<?php

 error_reporting(E_ALL);
ini_set('display_errors', 1);

include "main_top.php";
include_once "common.php";

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

<script>
  function order_change() {
    index_form.submit();
  }

  function order_scroll() {
    setTimeout(function() {
        window.scrollTo(0, 550);
    }, 50);
  }
  

</script>
<?php
  if(isset($_POST["scroll"])) {
    echo("<script>order_scroll();</script>");
  }
?>

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

<main class="container py-4">


<div class="d-flex justify-content-between align-items-center px-4 mt-4 mb-3">
  <h4 class="mb-0 fw-bold section-title">최근 등록된 상품</h4>

  <?php
    $a_order = ["정렬방식", "최신순", "낮은가격순", "높은가격순", "조회수순"];
    $n_order = count($a_order);

    // 상품 정렬 방식 설정
    $orderby = $_POST["orderby"] ?? 1; // 값이 있다면 받아오고, 없다면 디폴트가 1(최신순)

    switch($orderby) {
      case 2:
        $order_sql = "order by price asc, product_id desc"; // 낮은 가격 순 정렬
        break;
      case 3:
        $order_sql = "order by price desc, product_id desc"; // 높은 가격 순 정렬
        break;
      case 4:
        $order_sql = "order by view desc, product_id desc"; // 조회수순 정렬
        break;
      default:
        $order_sql = "order by product_id desc"; // 최신순 정렬
        
        break;
    }
  ?>

<form name="index_form" method="post" action="index.php">
<select class="form-select w-auto" aria-label="Default select example" name="orderby" onchange="order_change();"> <!-- onchange 속성을 사용해 값 변경 시 폼을 제출하도록 함.-->
<?php
  for($i = 1; $i < $n_order; $i++) {
    if($orderby == $i) {
      $is_selected = "selected";
    } else {
      $is_selected = "";
    }
?>
    <option value="<?php echo $i;?>" <?php echo $is_selected;?>><?php echo $a_order[$i];?></option>
<?php } ?>
  </select>
  <input type="hidden" name="scroll" value="1">
</form>
</div>

<div class="card-list">
  <?php
  $session_id = $_SESSION["id"] ?? "";
  if ($session_id) { // 로그인한 상태라면 sql문으로 자신의 id를 조회하여 해당 상품이 안뜨도록 함.
    $sql = "select member_id, juso1, juso2 from member where id = '$session_id'";
    $result = mysqli_query($db, $sql);
    if (!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);
    $member_id = $row["member_id"];
    $tmp = "and member_id != $member_id";

    // 자신의 주소 출력을 위해 가져오기
    $search_juso = $row["juso2"];
    
  } else {
    $member_id = "";
    $tmp = "";
    $search_juso = "";
  }


  $sql = "select product_id, member_id, image, price, category, reg_date, state, juso1, juso2, juso3, name, view 
                    from product where state != 2 $tmp $order_sql limit 12"; // limit 12로 12개만 보이도록 함.(너무 길어지는 것 방지)
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
          <a href="product.php?product_id=<?php echo $row["product_id"]; ?>" class="text-decoration-none text-dark stretched-link"><?php echo htmlspecialchars($row["name"]); ?></a>
        </h5>
        <p class="card-text"><?php echo $a_category[$row["category"]]; ?></p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><?php echo $row["juso1"] . " " . $row["juso2"] . " " .htmlspecialchars($row["juso3"]); ?></li>
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
  <button class="btn main-btn py-2" type="button" onclick="location.href='search.php?location=<?php echo $search_juso?>'">더보기</button>
</div>

</main>

<?php
include "main_bottom.php";
?>
