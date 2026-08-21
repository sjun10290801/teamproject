<?php
 error_reporting(E_ALL);
ini_set('display_errors', 1);
    include_once "common.php";
    loginCheck();

    $member_id = getId();

    $order_id = $_GET["id"];

    $sql = "select buyer_id from orders where order_id = $order_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    // 구매자 아이디와 접속자의 아이디가 불일치 시 접근 불가
    if($member_id != $row["buyer_id"]) {
        echo("<script>alert('권한이 없습니다.');</script>");
        echo("<script>location.href='index.php'</script>"); // 메인화면으로 돌아감.
        exit();
    }

    // 주문번호를 기준으로 상대방의 아이디 및 상품 이름 조회
    $sql = "select m.id as id, od.seller_id, p.name, p.product_id from orders od inner join member m on m.member_id = od.seller_id inner join product p on 
            p.product_id = od.product_id where order_id = $order_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    include "main_top.php";
    
?>

<div class="container py-5">
    <h2 class="text-center mb-4">거래 평가</h2>

    <form name="rating_form" method="post" action="rating_insert.php">
        <div class="card mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-header bg-transparent fw-bold">별점 등록</div>

            <div class="card-body p-4">
                <!-- 평가 대상 -->
                <div class="mb-3">
                    <label for="target_member" class="form-label fw-bold">평가 대상</label>
                    <input type="text" name="target_member" id="target_member" class="form-control" value="<?php echo $row["id"];?>" readonly>

                    <input type="hidden" name="to_member_id" id="to_member_id" class="form-control" value="<?php echo $row["seller_id"];?>">
                    <input type="hidden" name="from_member_id" id="from_member_id" class="form-control" value="<?php echo $member_id;?>">
                    <input type="hidden" name="product_id" id="product_id" class="form-control" value="<?php echo $row["product_id"];?>">
                    <input type="hidden" name="order_id" id="order_id" class="form-control" value="<?php echo $order_id;?>">
                </div>

                <!-- 거래 상품 -->
                <div class="mb-4">
                    <label for="product_name" class="form-label fw-bold">거래 상품</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $row["name"];?>" readonly>
                </div>

                <!-- 별점 -->
                <div class="mb-4">
                    <label class="form-label fw-bold">별점</label>

                    <div class="form-check mb-2">
                        <input type="radio" name="rating" id="rating5" value="5" class="form-check-input" required>
                        <label for="rating5" class="form-check-label text-warning">★★★★★ <span class="text-dark">5점</span></label>
                    </div>

                    <div class="form-check mb-2">
                        <input type="radio" name="rating" id="rating4" value="4" class="form-check-input">
                        <label for="rating4" class="form-check-label text-warning">★★★★☆ <span class="text-dark">4점</span></label>
                    </div>

                    <div class="form-check mb-2">
                        <input type="radio" name="rating" id="rating3" value="3" class="form-check-input">
                        <label for="rating3" class="form-check-label text-warning">★★★☆☆ <span class="text-dark">3점</span></label>
                    </div>

                    <div class="form-check mb-2">
                        <input type="radio" name="rating" id="rating2" value="2" class="form-check-input">
                        <label for="rating2" class="form-check-label text-warning">★★☆☆☆ <span class="text-dark">2점</span></label>
                    </div>

                    <div class="form-check">
                        <input type="radio" name="rating" id="rating1" value="1" class="form-check-input">
                        <label for="rating1" class="form-check-label text-warning">★☆☆☆☆ <span class="text-dark">1점</span></label>
                    </div>
                </div>

                <!-- 거래 후기 -->
                <div>
                    <label for="rating_detail" class="form-label fw-bold">거래 후기</label>
                    <textarea name="detail" id="rating_detail" class="form-control" rows="4" placeholder="거래 후기를 입력해주세요."></textarea>
                </div>
            </div>

            <div class="card-footer bg-transparent">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="history.back()">취소</button>
                    <button type="submit" class="btn btn-dark flex-fill">평가 등록</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include "main_bottom.php";
?>