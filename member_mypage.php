<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include "common.php";
    include "main_top.php";

    if(!isset($_COOKIE["cookie_id"])) {
        echo("<script>alert('로그인이 필요한 서비스입니다.');</script>");
        echo("<script>location.href='login.php'</script>"); // 로그인 화면으로 돌아감.
        exit();
    }

    $cookie_id = $_COOKIE["cookie_id"];

    // 회원 정보 불러오기
    $sql = "select * from member where id = '$cookie_id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit('에러:$sql');

    $row = mysqli_fetch_array($result);
    $member_id = $row["member_id"];

    $image = $row["image"] ?: "default_profile.jpg";


    // 평점 개수 불러오기
    $sql = "select count(*) as 'rating_count' from rating where to_member_id = $member_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit('에러:$sql');

    $row1 = mysqli_fetch_array($result);

    $count = $row1["rating_count"];
    
?>
    <main class="container py-5">
            <h2 class="text-center mb-4">마이페이지</h2>
            <section class="card mx-auto shadow-sm" style="max-width: 650px;">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">

                        <!--프로필 사진 -->
                        <div class="col-12 col-md-auto text-center">
                            <img src="images/<?php echo $image;?>" alt="프로필 사진"
                                class="rounded-circle object-fit-cover border" style="width: 120px; height: 120px;">
                                <a href="member_edit.php" class="btn btn-sm btn-dark text-white myfont">
                                    정보 수정
                                </a>
                        </div>

                        <!-- 회원 정보 -->
                        <div class="col text-center text-md-start">
                            <h4 class="mb-2"><?php echo $cookie_id;?></h4>

                            <div class="mb-2" aria-label="평점">
                                <i class="bi bi-star-fill text-warning"></i>
                                <strong id="rating_score"><?php echo $row["rating"];?></strong>
                                <span class="text-secondary">(평가 <?php echo $count;?>개)</span>
                            </div>

                            <p class="text-secondary mb-0">
                                <i class="bi bi-geo-alt-fill"></i>
                                <?php echo $row["juso1"]." ".$row["juso2"]." ".$row["juso3"];?>
                            </p>
                        </div>

                    </div>
                </div>
            </section>
            <?php
                $kind = $_GET["kind"] ?? "buy";
                
                // 상대방의 id(멤버), 상품정보(상품), 주문 시각(주문)을 알기 위해 테이블 3개 조인
                if($kind == "buy") { // 구매 내역일 경우 구매자 id가 본인의 id
                    $sql = "select orders.order_id, product.name, product.price, member.id, orders.reg_date, product.state, product.product_id
                    from orders inner join product on orders.product_id = product.product_id
                    inner join member on member.member_id = orders.seller_id where buyer_id = '$member_id'";
                    $result = mysqli_query($db, $sql);
                    if(!$result) exit('에러:$sql');
                } else { // 판매 내역일 경우 판매자 id가 본인의 id
                    $sql = "select orders.order_id, product.name, product.price, member.id, orders.reg_date, product.state, product.product_id
                    from orders inner join product on orders.product_id = product.product_id
                    inner join member on member.member_id = orders.buyer_id where seller_id = '$member_id'";
                    $result = mysqli_query($db, $sql);
                    if(!$result) exit('에러:$sql');
                }
                
            ?>
                <div class="mt-5 mx-auto" style="max-width: 650px;">
                    <h4 class="mb-3">거래 내역</h4>

                    <!-- 구매,판매 구분 버튼 -->
                    <div class="d-flex gap-2 mb-3">
                        <a href="member_mypage.php?kind=buy" class="btn btn-outline-dark flex-fill">
                            구매 내역
                        </a>

                        <a href="member_mypage.php?kind=sell" class="btn btn-outline-dark flex-fill">
                            판매 내역
                        </a>
                    </div>
            <?php
                while($row = mysqli_fetch_assoc($result)) {
            ?>
                    <!-- 거래 내역 -->
                    <div class="border rounded p-3">
                        <p class="mb-1">상품명: <?php echo $row["name"];?></p>
                        <p class="mb-1">가격: <?php echo number_format($row["price"]);?>원</p>
                        <p class="mb-1">거래 상대방: <?php echo $row["id"];?></p>
                        <p class="mb-1">거래 날짜: <?php echo $row["reg_date"];?></p>

                        <span class="badge text-bg-success">
                            <?php
                                if($row["state"] == 0) echo("판매 중");
                                else if($row["state"] == 1) echo("예약됨");
                                else echo("판매 완료");
                            ?>
                        </span>
                        <?php
                            if($kind == "buy") {
                        ?>
                                <a href="rating.php?id=<?php echo $row['order_id']; ?>" class='btn btn-sm btn-dark text-white myfont'>평점 매기기</a>
                        <?php
                            } else {
                        ?>
                                <a href="product_edit.php?id=<?php echo $row['product_id'];?>" class="btn btn-sm btn-dark text-white myfont">상품 수정</a>
                        <?php
                            }
                        ?>
                    </div><br>
            <?php
                }
            ?>
                    </div>
           
    </main>
<?php
  include "main_bottom.php";  
?>

