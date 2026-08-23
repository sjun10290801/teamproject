<?php
    include "../common.php";

    $id = $_POST["id"];
    $pwd = $_POST["pwd"];

    // 서버측 데이터 검증 추가
    if(!$id) {
        echo("<script>alert('아이디를 입력해주세요.');</script>");
        echo("<script>location.href='admin_login.php'</script>");
        exit();
    }
    if(!$pwd) {
        echo("<script>alert('비밀번호를 입력해주세요.');</script>");
        echo("<script>location.href='admin_login.php'</script>");
        exit();
    }

    if($id != "admin") {
        echo("<script>alert('계정정보가 존재하지 않습니다.');</script>");
        echo("<script>location.href='admin_login.php'</script>");
        exit();
    } else if($pwd != "1234") {
        echo("<script>alert('비밀번호가 일치하지 않습니다.');</script>");
        echo("<script>location.href='admin_login.php'</script>");
        exit();
    } else {
        // setcookie("admin_id", "admin"); // 쿠키 생성

        if(!session_id()) { // 세션 생성
                session_start();
            }
        $_SESSION["admin_id"] = $id;

        echo("<script>location.href='admin_member.php'</script>");
        exit();
    }
?>