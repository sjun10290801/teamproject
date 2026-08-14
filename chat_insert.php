<?php
    include "common.php";

    // post 방식으로 데이터 불러오기
    $to_member_id = $_POST["to_member_id"];
    $from_member_id = $_POST["from_member_id"];
    $product_id = $_POST["product_id"];
    $text = $_POST["text"];

    // 이미지 삽입은 상품의 이미지 삽입과 동일
    $filename = $_FILES["image"]["name"]; // 이미지 이름

    if(!$text && !$filename) {
        echo("<script>alert('내용을 입력해주세요');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    mysqli_begin_transaction($db); // 트랜잭션 시작

    // 이미지 업로드
    $fname = imageUpload("chat", "chat", "chat");
    if(!$fname) {
        mysqli_rollback($db);
        echo("<script>alert('오류가 발생했습니다');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    // 채팅 데이터 저장
    $sql = "insert into chat(to_member_id, from_member_id, product_id, text, reg_date, state, image)
            values($to_member_id, $from_member_id, $product_id, '$text', sysdate(), 0, '$fname')";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo("<script>alert('오류가 발생했습니다');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    mysqli_commit($db);

    header("Location:chat_room.php?my_id=$from_member_id&target_id=$to_member_id&product_id=$product_id");
?>