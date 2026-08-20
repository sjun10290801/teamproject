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

    $stmt = $db->stmt_init();
    $sql = "select * from member where id = ?";
    $stmt->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    $stmt->close();

    if(password_verify($pwd, $row["password"])) {
        echo("<script>alert('동일한 비밀번호로는 변경할 수 없습니다.');</script>");
        echo("<script>location.href='pwd_search.html'</script>");
        exit();
    } else {
        $password = password_hash($pwd, PASSWORD_DEFAULT);

        $stmt = $db->stmt_init();
        $sql = "update member set password = '$password' where id = ?";
        $stmt->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        if(!$stmt->execute()) {
            echo("<script>alert('오류가 발생했습니다.');</script>");
            echo("<script>location.href='pwd_search.html'</script>");
            exit();
        }

        $stmt->close();

        echo("<script>alert('변경이 완료되었습니다.');</script>");
        echo("<script>location.href='login.php'</script>");
        exit();
    }
?>