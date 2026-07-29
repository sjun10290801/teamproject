<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include "common.php";

    // post 방식으로 데이터 불러오기
    $to_member_id = $_POST["to_member_id"];
    $from_member_id = $_POST["from_member_id"];
    $product_id = $_POST["product_id"];
    $text = $_POST["text"];

    // 이미지 삽입은 상품의 이미지 삽입과 동일
    $filename = $_FILES["image"]["name"]; // 이미지 이름
    if($filename) {
        $tmp = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // strtolower => 영어 소문자로 변경하는 함수
        // pathinfo(경로, PATHINFO_EXTENSION) => 파일의 확장자만 추출하기 위한 함수

        switch($tmp) { // 확장자가 이미지가 아니면 종료
            case "png": case "jpg": case "jpeg":
                break;
            default:
                echo("이미지(png, jpg, jpeg) 파일만 업로드 가능합니다.");
                exit();
        }
    

    
        // 파일 이름 중복 방지 -> "chat" + 제품id
        $sql = "select chat_id from chat order by chat_id desc"; // 제품 id 내림차순 정렬
        $result = mysqli_query($db, $sql);
        if(!$result) exit("에러 : $sql");

        if($row = mysqli_fetch_assoc($result)) { // 제품이 없다면 제품 id는 1. 제품이 있다면 마지막 제품id + 1
            $chat_id = $row["chat_id"] + 1;
        } else {
            $chat_id = 1;
        }

        $fname = "chat".$chat_id.".".$tmp;
        if($_FILES["image"]["error"] == 0)
        {
            if(!move_uploaded_file($_FILES["image"]["tmp_name"],"chat/$fname")) // 업로드
                exit("업로드 실패");
        }
    }

    $sql = "insert into chat(to_member_id, from_member_id, product_id, text, reg_date, state, image)
            values($to_member_id, $from_member_id, $product_id, '$text', sysdate(), 0, '$fname')";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    header("Location:chat_room.php?my_id=$from_member_id&target_id=$to_member_id&product_id=$product_id");
?>