<?php
    include "../common.php";

    adminCheck();

    $report_id = $_GET["id"];
    $text = $_GET["text"];
    $sel = $_GET["sel"];

    $sql = "delete from report where report_id = $report_id";
    $result = mysqli_query($db, $sql);
    if (!$result) exit("에러 : $sql");

    echo("<script>alert('삭제되었습니다');</script>");
    echo("<script>location.href='admin_report.php?text=$text&sel=$sel'</script>");

?>