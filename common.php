<?php
    $db = mysqli_connect("localhost", "market", "1234", "market");  // localhost db와 연결
    if(!$db) exit("DB연결에러"); // 연결 실패 시 종료

    $a_category = ["카테고리", "디지털기기", "가구", "가전", "의류", "게임", "기타"];
    $n_category = count($a_category);

    $a_bank = ["은행 선택", "국민", "신한", "기업", "하나", "우리"];
    $n_bank = count($a_bank);
?>