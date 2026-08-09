<?php
    include "../common.php";
    adminCheck();
    $member_id = $_GET["member_id"];

    $sql = "delete from member where member_id = $member_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>alert('삭제되었습니다.');</script>");
    echo("<script>location.href='admin_member.php'</script>");
?>