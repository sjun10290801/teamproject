<?php
    include "main_top.php";
    include_once "common.php";
    
    $page_line = 12;

    loginCheck(); // 로그인 했는지 확인

    $member_id = getId();

    $args="";
    $sql = "select g.product_id, p.name, p.category, p.juso1, p.juso2, p.juso3, p.reg_date, p.price, p.image from good g inner join product p on p.product_id = g.product_id 
            where g.member_id = $member_id";
    $result = mypagination($sql, $args, $count, $pagebar);
    if(!$result) exit("에러 : $sql");


?>



<style>

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

</style>

<div class="container mt-5 mb-5">
    <h2 class="text-center fw-bold">관심목록</h2>
</div>



<div class="card-list">

<?php
  while($row = mysqli_fetch_assoc($result)) {
    $image = $row["image"] ?: "default.jpg";
    
    // 시간 차이 계산
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

?>


<div class="product-item">

    <div class="product-image-wrap">

        <img
            src="product/<?php echo htmlspecialchars($image); ?>"
            class="product-image"
            alt="<?php echo htmlspecialchars($row["name"]); ?>"
        >

        <div class="product-category">
            <?php echo htmlspecialchars($a_category[$row["category"]]); ?>
        </div>

    </div>

    <div class="product-content">

        <h5 class="product-title">
            <a
                href="product.php?product_id=<?php echo $row["product_id"]; ?>"
                class="stretched-link"
            >
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
                <span>
                    <?php echo $time_text; ?>
                </span>
            </div>

            <div class="product-info-item">
                <i class="bi bi-eye"></i>
                <span>125</span>
            </div>

        </div>

        <div class="product-price">
            <?php echo number_format($row["price"]); ?>원
        </div>

    </div>

    <div class="product-actions">

<a
    href="good_delete.php?member_id=<?php echo $member_id; ?>&product_id=<?php echo $row["product_id"]; ?>"
    class="product-btn product-btn-wish"
>
    <i class="bi bi-heart"></i>
    <span>삭제</span>
</a>

        <a
            href="chat_room.php?my_id=<?php echo $member_id; ?>&target_id=<?php echo $row["member_id"]; ?>&product_id=<?php echo $row["product_id"]; ?>"
            class="product-btn product-btn-chat"
        >
            <i class="bi bi-chat-dots"></i>
            <span>채팅</span>
        </a>

        <a
            href="member_profile.php?id=<?php echo $row["member_id"]; ?>"
            class="product-btn product-btn-profile"
        >
            <i class="bi bi-person"></i>
            <span>프로필</span>
        </a>

    </div>

</div>


<?php
  }
?>

</div>



<?php
  echo $pagebar;
  include "main_bottom.php";
?>