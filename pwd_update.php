<?php
    include "common.php";

    $id = $_POST["id"];

    $pwd = $_POST["pwd"];
    $pwd1 = $_POST["pwd1"];

    if(!$id || !$pwd) {
        echo("<script>alert('비밀번호를 입력해주세요');</script>");
        echo("<script>location.href='pwd_search.html'</script>");
        exit();
    }

    if($pwd != $pwd1) {
        echo("<script>alert('비밀번호가 일치하지 않습니다');</script>");
        echo("<script>location.href='pwd_search.html'</script>");
        exit();
    }

    $sql = "select * from member where id = '$id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    if($pwd == $row["password"]) {
        echo("<script>alert('동일한 비밀번호로는 변경할 수 없습니다.');</script>");
        echo("<script>location.href='pwd_search.html'</script>");
        exit();
    } else {
        $sql = "update member set password = '$pwd' where id = '$id'";
        $result = mysqli_query($db, $sql);
        if(!$result) exit("에러 : $sql");

        echo("<script>alert('변경이 완료되었습니다.');</script>");
        echo("<script>location.href='login.html'</script>");
    }
?>