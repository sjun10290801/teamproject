<?php
    include "common.php";

    loginCheck();
    $member_id = getId();

    $product_id = $_GET["product_id"];

    $sql = "delete from good where member_id = $member_id and product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>alert('삭제되었습니다.');</script>");
    echo("<script>location.href='good.php'</script>");
?>