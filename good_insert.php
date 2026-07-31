<?php
    include "common.php";

    $cookie_id = $_COOKIE["cookie_id"] ?? "";
    if(!$cookie_id) {
        echo("<script>alert('로그인이 필요한 서비스입니다.');</script>");
        echo("<script>location.href='login.php'</script>"); // 로그인 화면으로 돌아감.
    }

    // 자신의 멤버id를 조회
    $sql = "select member_id from member where id = '$cookie_id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);
    
    $member_id = $row["member_id"];

    $product_id = $_GET["product_id"];

    // 이미 찜 목록에 저장되어 있는 품목인지 확인
    $sql = "select good_id from good where member_id = $member_id and product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    // 이미 찜 목록에 있다면 종료
    if($row = mysqli_fetch_assoc($result)) {
        echo("<script>alert('이미 등록된 상품입니다.');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    // db에 저장
    $sql = "insert into good(member_id, product_id) values($member_id, $product_id)";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>alert('찜 목록에 추가되었습니다.');</script>");
    echo("<script>location.href='good.php'</script>");
?>