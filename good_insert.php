<?php
    include "common.php";

    loginCheck();
    $member_id = getId();

    $product_id = $_GET["product_id"];

    mysqli_begin_transaction($db);

    // 이미 찜 목록에 저장되어 있는 품목인지 확인
    $sql = "select good_id from good where member_id = $member_id and product_id = $product_id for update"; // 중복 저장 방지용 행 잠금
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo("<script>alert('오류가 발생했습니다');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    // 이미 찜 목록에 있다면 종료
    if($row = mysqli_fetch_assoc($result)) {
        mysqli_rollback($db);
        echo("<script>alert('이미 등록된 상품입니다.');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    // db에 저장
    $sql = "insert into good(member_id, product_id) values($member_id, $product_id)";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo("<script>alert('오류가 발생했습니다');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    mysqli_commit($db);
    

    echo("<script>alert('찜 목록에 추가되었습니다.');</script>");
    echo("<script>location.href='good.php'</script>");
?>