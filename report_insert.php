<?php 
    include "common.php";

    loginCheck();
    $id = getId();

    if(!isset($_POST["reason"])) {
        echo("<script>alert('사유를 선택해주세요.');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    $target = $_POST["target"];
    $reason = $_POST["reason"];
    $detail = $_POST["detail"] ?? "";

    
    $fname = imageUpload("report", "admin/report", "report");

    $sql = "insert into report(to_member_id, from_member_id, reason, text, image) 
            values($target, $id, '$reason', '$detail', '$fname')";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>alert('신고 완료.');</script>");
    echo("<script>location.href='index.php'</script>");

?>