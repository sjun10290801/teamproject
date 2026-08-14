<?php
    include "main_top.php";
    include "common.php";
    
    $page_line = 12;

    loginCheck(); // 로그인 했는지 확인

    $member_id = getId();

    $args="";
    $sql = "select g.product_id, p.name, p.category, p.juso1, p.juso2, p.juso3, p.reg_date, p.price, p.image from good g inner join product p on p.product_id = g.product_id 
            where g.member_id = $member_id";
    $result = mypagination($sql, $args, $count, $pagebar);
    if(!$result) exit("에러 : $sql");


?>

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
<div class="card container" style="width: 18rem;">
  <img src="product/<?php echo $image;?>" class="card-img-top object-fit-contain bg-light" style="height: 200px;" alt="...">
  <div class="card-body">
    <div class="card-body">
    <h5 class="card-title">
      <a href="product.php?product_id=<?php echo $row["product_id"];?>" class="text-dark text-decoration-none stretched-link">
        <?php echo $row["name"];?>
      </a>
    </h5>
    <p class="card-text"><?php echo $a_category[$row["category"]];?></p>
    <p class="card-text text-muted"><?php echo $row["juso1"]." ".$row["juso2"]." ".$row["juso3"];?> · <?php echo $time_text;?></p>
    <h5 class="card-text fw-bold mt-2"><?php echo number_format($row["price"]);?>원</h5>
  </div>
  <a href="good_delete.php?member_id=<?php echo $member_id;?>&product_id=<?php echo $row["product_id"];?>" class="btn btn-sm btn-dark text-white myfont position-relative z-3">삭제</a>
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