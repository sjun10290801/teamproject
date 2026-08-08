<?php
    include "common.php";

    $cookie_id = $_COOKIE["cookie_id"] ?? "";

    // 자신의 멤버id를 조회
    $sql = "select member_id from member where id = '$cookie_id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);
    
    $member_id = $row["member_id"];

    $product_id = $_GET["product_id"];

    $sql = "delete from good where member_id = $member_id and product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>alert('삭제되었습니다.');</script>");
    echo("<script>location.href='good.php'</script>");
?>