<?php
    include "common.php";

    loginCheck();

    $product_id = $_POST["product_id"];

    mysqli_begin_transaction($db);

    //중복 결제 방지
    $sql = "select state from product where product_id = $product_id for update";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo "<script>alert('처리 중 오류가 발생했습니다.'); history.back();</script>";
        exit();
    }

    $row = mysqli_fetch_assoc($result);

    if($row["state"] == 2) { // 이미 판매된 제품이라면 종료
        mysqli_rollback($db);
        echo "<script>alert('이미 판매된 제품입니다.'); location.href='index.php';</script>";
        exit();
    }

    $member_id = getId();

    $method = $_POST["payment_method"];
    $seller_id = $_POST["seller_id"];

    // 주문 테이블에 데이터 저장
    $sql = "insert into orders(product_id, buyer_id, seller_id, method, reg_date) 
            values($product_id, $member_id, $seller_id, $method, sysdate())";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo "<script>alert('처리 중 오류가 발생했습니다.'); history.back();</script>";
        exit();
    }

    // 상품 상태 판매완료로 변경
    $sql = "update product set state = 2 where product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo "<script>alert('처리 중 오류가 발생했습니다.'); history.back();</script>";
        exit();
    }

    mysqli_commit($db);

    echo "<script>alert('결제가 완료되었습니다.'); location.href='member_mypage.php?kind=buy';</script>";

?>