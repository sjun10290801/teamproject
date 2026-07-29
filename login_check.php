<?php
    include "common.php";

    // id, pwd 받기
    $id = $_POST["id"];
    $pwd = $_POST["pwd"];

    // 입력한 id가 있는지 확인
    $sql = "select * from member where id = '$id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    if($row = mysqli_fetch_assoc($result)) { // 해당하는(id가 같은) 계정이 있는지 확인
        
        if($row["password"] == $pwd) { // id와 비밀번호가 모두 일치하는 계정이 있다면
            setcookie("cookie_id", $id); // 쿠키 생성
            header("Location:index.html"); // 메인화면으로 되돌아감
            exit();
        } else {
            echo("<script>alert('비밀번호가 일치하지 않습니다.');</script>"); // id가 없으면 종료
            echo("<script>location.href='login.php'</script>"); // 로그인 화면으로 돌아감.
            exit();
        exit();
        }
    } else {
        echo("<script>alert('계정 정보가 존재하지 않습니다.');</script>"); // id가 없으면 종료
        echo("<script>location.href='login.php'</script>");
        exit();
    }
?>