<?php
    include "../common.php";

    adminCheck();

    $report_id = $_GET["id"];
    $text = $_GET["text"];
    $sel = $_GET["sel"];

    //사진 삭제
    $sel_sql = "select image from report where report_id = $report_id";
    $sel_result = mysqli_query($db, $sel_sql);
    if(!$sel_result) exit("에러 : $sel_sql");

    $row = mysqli_fetch_assoc($sel_result);
    $fname = $row["image"];
    if($fname) {
        if(file_exists("report/".$fname))
        unlink("report/".$fname); // 파일 삭제
    }

    $sql = "delete from report where report_id = $report_id";
    $result = mysqli_query($db, $sql);
    if (!$result) exit("에러 : $sql");

    echo("<script>alert('삭제되었습니다');</script>");
    echo("<script>location.href='admin_report.php?text=$text&sel=$sel'</script>");

?>