<?php
    include "common.php";

    $id = $_POST["id"];

    $pwd = $_POST["pwd"];

    $sql = "select * from member where id = '$id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    if($pwd == $row["password"]) {
        echo("<script>alert('동일한 비밀번호로는 변경할 수 없습니다.');</script>");
        echo("<script>location.href='pwd_search.html'</script>");
    } else {
        $sql = "update member set password = '$pwd' where id = '$id'";
        $result = mysqli_query($db, $sql);
        if(!$result) exit("에러 : $sql");

        echo("<script>alert('변경이 완료되었습니다.');</script>");
        echo("<script>location.href='login.html'</script>");
    }
?>