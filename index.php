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








  .card-list {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 24px;
    padding: 30px;
    max-width: 1500px;
    margin: 0 auto;
  }

  .product-item {
    position: relative;
    background: #ffffff;
    border: 1px solid #e3eeee;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(24, 118, 109, 0.08);
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
    min-width: 0;
  }

  .product-item:hover {
    transform: translateY(-6px);
    border-color: #b8d8d4;
    box-shadow: 0 10px 28px rgba(24, 118, 109, 0.16);
  }

  .product-image-wrap {
    position: relative;
    width: 100%;
    height: 220px;
    background: #f5f9f9;
    overflow: hidden;
  }


  .product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
  }

  .product-item:hover .product-image {
    transform: scale(1.04);
  }

  .product-category {
    position: absolute;
    left: 14px;
    top: 14px;
    padding: 6px 11px;
    background: #18766d;
    color: #ffffff;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    box-shadow: 0 3px 8px rgba(24, 118, 109, 0.2);
  }

  .product-content {
    padding: 18px;
  }

  .product-title {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }


  .product-title a {
    color: #222222;
    text-decoration: none;
  }


  .product-title a:hover {
    color: #18766d;
  }

  .product-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 14px;
    font-size: 13px;
    color: #777777;
  }


  .product-info-item {
    display: flex;
    align-items: center;
    gap: 7px;
    min-width: 0;
  }


  .product-info-item i {
    color: #18766d;
    font-size: 14px;
    flex-shrink: 0;
  }


  .product-info-item span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .product-price {
    margin-top: 16px;
    color: #18766d;
    font-size: 21px;
    font-weight: 800;
  }

  .product-actions {
    position: relative;
    z-index: 2;
    margin-top: auto;
    padding: 14px 18px 18px;
    border-top: 1px solid #edf2f2;
    display: flex;
    gap: 8px;
  }

  .product-btn {
    position: relative;
    z-index: 3;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
    padding: 9px 5px;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
  }

  .product-btn-wish {
    color: #dc3545;
    background: #fff5f5;
    border: 1px solid #f1b8be;
  }


  .product-btn-wish:hover {
    color: #ffffff;
    background: #dc3545;
    border-color: #dc3545;
  }

  .product-btn-chat {
    color: #18766d;
    background: #f1f8f7;
    border: 1px solid #bcdad6;
  }


  .product-btn-chat:hover {
    color: #ffffff;
    background: #18766d;
    border-color: #18766d;
  }

  .product-btn-profile {
    color: #555555;
    background: #ffffff;
    border: 1px solid #dddddd;
  }


  .product-btn-profile:hover {
    color: #18766d;
    background: #f5fafa;
    border-color: #a8ccc8;
  }
  .category-menu {
    display: flex;
    justify-content: center;
    gap: 12px;
    padding: 18px 15px;
    background: #ffffff;
    border-bottom: 1px solid #e5eeee;
  }

  .category-item {
    min-width: 105px;
    padding: 11px 16px;
    color: #4d5857;
    background: #ffffff;
    border: 1px solid #dce9e7;
    border-radius: 14px;
    text-align: center;
    text-decoration: none;
    transition: 0.2s;
  }

  .category-item i {
    margin-right: 6px;
    color: #18766d;
  }

  .category-item:hover {
    color: #18766d;
    background: #eef7f5;
    border-color: #9ccbc6;
    transform: translateY(-2px);
  }

  .category-item.active {
    color: #ffffff;
    background: #18766d;
    border-color: #18766d;
    box-shadow: 0 4px 10px rgba(24, 118, 109, 0.2);
  }

  .category-item.active i {
    color: #ffffff;
  }

  .form-select {
    width: 130px;
    border-color: #bcdad6;
    color: #18766d;
    font-weight: 600;
}

.form-select:focus {
    border-color: #18766d;
    box-shadow: 0 0 0 0.2rem rgba(24, 118, 109, 0.15);
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
if (isset($_POST["scroll"])) {
  echo ("<script>order_scroll();</script>");
}
?>

<?php
$category_icon = ["", "bi-phone", "bi-lamp", "bi-plug", "bi-bag", "bi-controller", "bi-three-dots"];
?>

<div class="category-menu">
  <a href="index.php" class="category-item active">
    <i class="bi bi-grid-fill"></i>
    <span>전체</span>
  </a>

  <?php for ($i = 1; $i < $n_category; $i++) { ?>
    <a href="<?php echo ($i == $n_category - 1) ? 'category_all.php' : 'category.php?menu=' . $i; ?>" class="category-item">
      <i class="bi <?php echo $category_icon[$i]; ?>"></i>
      <span><?php echo $a_category[$i]; ?></span>
    </a>
  <?php } ?>
</div>

<main class="py-4">


  <div class="d-flex justify-content-between align-items-center px-4 mt-4 mb-3">
    <h4 class="mb-0 fw-bold section-title">등록된 상품</h4>

    <?php
    //상품 정렬 방식 설정
    $orderby = $_POST["orderby"] ?? 1; // 값이 있다면 받아오고, 없다면 디폴트가 1(최신순)

    switch ($orderby) {
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
        for ($i = 1; $i < $n_order; $i++) {
          if ($orderby == $i) {
            $is_selected = "selected";
          } else {
            $is_selected = "";
          }
        ?>
          <option value="<?php echo $i; ?>" <?php echo $is_selected; ?>><?php echo $a_order[$i]; ?></option>
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
      $tmp = "and p.member_id != $member_id";

      // 자신의 주소 출력을 위해 가져오기
      $search_juso = $row["juso2"];
    } else {
      $member_id = "";
      $tmp = "";
      $search_juso = "";
    }


    $sql = "select p.product_id, p.member_id, p.image, p.price, p.category, p.reg_date, p.state, p.juso1, p.juso2, p.juso3, p.name, p.view, m.status
                    from product p inner join member m on p.member_id = m.member_id
                    where p.state != 2 $tmp and m.status = 0 $order_sql limit 12"; // limit 12로 12개만 보이도록 함.(너무 길어지는 것 방지)
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
      <div class="product-item">

        <div class="product-image-wrap">

          <img
            src="product/<?php echo htmlspecialchars($product_image); ?>"
            class="product-image"
            alt="<?php echo htmlspecialchars($row["name"]); ?>">

          <div class="product-category">
            <?php echo htmlspecialchars($a_category[$row["category"]]); ?>
          </div>

        </div>

        <div class="product-content">

          <h5 class="product-title">
            <a
              href="product.php?product_id=<?php echo $row["product_id"]; ?>"
              class="stretched-link">
              <?php echo htmlspecialchars($row["name"]); ?>
            </a>
          </h5>

          <div class="product-info">

            <div class="product-info-item">
              <i class="bi bi-geo-alt-fill"></i>
              <span>
                <?php
                echo htmlspecialchars(
                  $row["juso1"] . " " .
                    $row["juso2"] . " " .
                    $row["juso3"]
                );
                ?>
              </span>
            </div>

            <div class="product-info-item">
              <i class="bi bi-clock"></i>
              <span><?php echo $time_text; ?></span>
            </div>

            <div class="product-info-item">
              <i class="bi bi-eye"></i>
              <span><?php echo $row["view"]; ?></span>
            </div>

          </div>

          <div class="product-price">
            <?php echo number_format($row["price"]); ?>원
          </div>

        </div>

        <div class="product-actions">

          <a
            href="good_insert.php?product_id=<?php echo $row["product_id"]; ?>"
            class="product-btn product-btn-wish">
            <i class="bi bi-heart"></i>
            <span>찜</span>
          </a>

          <a
            href="chat_room.php?my_id=<?php echo $member_id; ?>&target_id=<?php echo $row["member_id"]; ?>&product_id=<?php echo $row["product_id"]; ?>"
            class="product-btn product-btn-chat">
            <i class="bi bi-chat-dots"></i>
            <span>채팅</span>
          </a>

          <a
            href="member_profile.php?id=<?php echo $row["member_id"]; ?>"
            class="product-btn product-btn-profile">
            <i class="bi bi-person"></i>
            <span>프로필</span>
          </a>

        </div>

      </div>

    <?php } ?>


  </div>

  <div class="text-center mt-5">
    <a href="search.php?location=<?php echo $search_juso; ?>"
      class="btn main-btn rounded-pill px-5 py-2 fw-semibold">
      상품 더보기
      <i class="bi bi-chevron-right ms-1"></i>
    </a>
  </div>

</main>

<?php
include "main_bottom.php";
?>
