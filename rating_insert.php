<?php
    include "common.php";

    $to_member_id = $_POST["to_member_id"];
    $from_member_id = $_POST["from_member_id"];
    $product_id = $_POST["product_id"];
    $order_id = $_POST["order_id"];

    // 중복 확인
    $sql = "select * from rating where to_member_id = $to_member_id and from_member_id = $from_member_id and product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    if($row = mysqli_fetch_assoc($result)) { // 이미 평점을 매긴 경우(레코드가 있는 경우)
        echo("<script>alert('이미 작성하셨습니다..');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    $memo = $_POST["detail"] ?? "";
    if($memo) addslashes(trim($memo)); // ' 등의 특수문자 포함 방지

    // 별점 불러오기
    $rating = $_POST["rating"];

    // 서버 데이터 검증
    if(!$rating) {
        echo("<script>alert('별점을 입력하세요.');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    if($rating <= 0 || $rating > 5) {
        echo("<script>alert('올바른 정보를 입력해주세요.');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    mysqli_begin_transaction($db); // 트랜잭션 시작

    //평점 입력 sql
    $sql = "insert into rating(to_member_id, from_member_id, score, reg_date, order_id, memo, product_id) 
            values($to_member_id, $from_member_id, $rating, sysdate(), $order_id, '$memo', $product_id)";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db); // 오류 시 트랜잭션 롤백
        exit("에러 : $sql");
    }

    // 대상 평점 평균 업데이트
    $sql = "update member set rating = (select avg(score) from rating where to_member_id = $to_member_id) where member_id = $to_member_id";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        exit("에러 : $sql");
    }

    mysqli_commit($db);

    echo("<script>alert('평점이 입력되었습니다.');</script>");
    echo("<script>location.href='member_mypage.php?kind=buy'</script>");

    
?>