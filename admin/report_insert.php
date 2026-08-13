<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include "../common.php";

    adminCheck();

    $member_id = $_GET["id"];
    $text = $_GET["text"];
    $sel = $_GET["sel"];
    $reason = $_GET["reason"];

    mysqli_begin_transaction($db); // 트랜잭션 시작

    // 데이터 저장 -> 멤버 목록 업데이트
    $sql = "insert into reportedmember (member_id, reason) values ($member_id, $reason)";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo "<script>alert('처리 중 오류가 발생했습니다'); history.back();</script>";
        exit();
    }

    $sql = "update member set status = 1 where member_id = $member_id";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo "<script>alert('처리 중 오류가 발생했습니다'); history.back();</script>";
        exit();
    }

    mysqli_commit($db); // 커밋

    echo("<script>alert('제재 완료되었습니다');</script>");
    echo("<script>location.href='admin_report.php?text=$text&sel=$sel'</script>");

?>