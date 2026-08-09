<?php
    include "common.php";

    $to_member_id = $_POST["to_member_id"];
    $from_member_id = $_POST["from_member_id"];
    $product_id = $_POST["product_id"];
    $memo = $_POST["detail"] ?? "";
    if($memo) addslashes(trim($memo)); // ' 등의 특수문자 포함 방지

    // 별점 불러오기
    $tmp = "rating";
    for($i = 1; $i <=5; $i++) {
        if(isset($_POST[$tmp.$i])) {
            $rating = $_POST[$tmp.$i];
            break;
        }
    }

    // 서버 데이터 검증
    if(!$rating) {
        echo("<script>alert('별점을 입력하세요.');</script>");
        echo("<script>window.history.back();</script>");
    }
?>