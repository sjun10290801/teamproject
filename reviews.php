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


<div class="container mt-5">

    <div class="container mt-5 mb-5">
        <h2 class="text-center fw-bold">판매 후기</h2>
    </div>
    <hr>

<?php
    while($row = mysqli_fetch_assoc($result)) {
?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title"><?php echo $row["id"];?></h5>
                <div class="text-warning">
                <?php for($i = 0; $i < $row["score"]; $i++) { ?>
                    <i class="bi bi-star-fill"></i>
                <?php } ?>
                </div>
            </div>

            <h6 class="card-subtitle mb-2 text-muted">거래한 상품명: <?php echo $row["name"];?></h6>
            <p class="card-text"><?php echo stripslashes($row["memo"]);?></p>
        </div>
    </div>
<?php } ?>
</div>
