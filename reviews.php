<?php
    include_once "common.php";
    include "main_top.php";
    loginCheck();
    $member_id = getId();

    $sql = "select m.id, p.name, r.score, r.memo from rating r inner join member m on r.from_member_id = m.member_id 
            inner join product p on r.product_id = p.product_id where to_member_id = $member_id";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        echo("<script>alert('오류가 발생했습니다');</script>");
        echo("<script>location.href='login.php'</script>");
        exit();
    }
    
?>
<style>
    .review-title{
        color: #18766d;
        font-size: 40px;
    }

    .review-divider{
        border: 0;
        border-top: 2px solid #18766d;
    }

    .review-card {
    border: 1px solid #e3eeee;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(24, 118, 109, 0.08);
    padding: 22px;
}

.review-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.review-writer {
    display: flex;
    align-items: center;
    gap: 10px;
}

.writer-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e8f4f2;
    color: #18766d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.writer-name {
    font-size: 16px;
    font-weight: 700;
    color: #333;
}

.review-stars {
    color: #f5b400;
    font-size: 16px;
    letter-spacing: 1px;
}

.product-info {
    margin-bottom: 15px;
}

.product-label {
    font-size: 12px;
    color: #8a8a8a;
    margin-bottom: 4px;
}

.product-name {
    font-size: 15px;
    font-weight: 600;
    color: #18766d;
}

.review-content {
    color: #444;
    line-height: 1.7;
    font-size: 14px;
    white-space: pre-line;
}

</style>

<div class="container mt-5">

    <div class="container mt-5 mb-5">
        <h2 class="text-center fw-bold review-title">판매 후기</h2>
    </div>
    <hr class="review-divider">

<?php
    while($row = mysqli_fetch_assoc($result)) {
?>
    <div class="card review-card mb-3">
        <div class="card-body p-0">

        
<div class="review-top">
    <div class="review-writer">
        <div class="writer-icon">
            <i class="bi bi-person-fill"></i>
        </div>

        <div class="writer-name">
            <?php echo htmlspecialchars($row["id"]); ?>
        </div>
    </div>

    <div class="review-stars">
        <?php for($i = 0; $i < $row["score"]; $i++) { ?>
            <i class="bi bi-star-fill"></i>
        <?php } ?>
    </div>
</div>

    <div class="product-info">
        <div class="product-label">거래 상품</div>

        <div class="product-name">
            <?php echo htmlspecialchars($row["name"]); ?>
        </div>
    </div>

    <div class="review-content">
        <?php echo stripslashes($row["memo"]); ?>
    </div>
        
</div>
    </div>
<?php } ?>
</div>


<?php
include "main_bottom.php";
?>