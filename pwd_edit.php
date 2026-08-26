<?php

    include_once "common.php";

    $id = $_POST["id"];
    if(!$id) {
        echo("<script>alert('id를 입력해주세요');</script>");
        echo("<script>location.href='pwd_search.php'</script>");
        exit();
    }
    
    $sql = "select * from member where id = '$id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    if(!$row = mysqli_fetch_assoc($result)) { // id가 있는지 확인
        echo("<script>alert('등록되지 않은 id입니다.');</script>");
        echo("<script>location.href='pwd_search.php'</script>");
        exit();
    }

    $name = $_POST["name"];
    $tel1 = $_POST["tel1"];
    $tel2 = $_POST["tel2"];
    $tel3 = $_POST["tel3"];
    $tel = $tel1.$tel2.$tel3;
    $birthday = $_POST["birthday"];

    if(!$name || !$tel1 || !$tel2 || !$tel3 || !$birthday) {
        echo("<script>alert('올바른 정보를 입력해주세요');</script>");
        echo("<script>location.href='pwd_search.php'</script>");
        exit();
    }

    if(!($name == $row["name"] && $tel == $row["tel"] && $birthday == $row["birthday"])) { // id와 회원정보가 일치하지 않으면
        echo("<script>alert('회원정보가 일치하지 않습니다.');</script>");
        echo("<script>location.href='pwd_search.php'</script>");
        exit();
    }
?>

<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>비밀번호 변경</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f6f9f8; }
        .member-card { max-width: 520px; border-radius: 20px; }
        .member-accent { width: 42px; height: 4px; background-color: #147d73; }
        .member-card .form-label { font-weight: 600; }
        .member-card .form-control { min-height: 46px; border-radius: 10px; }
        .btn-theme { background-color: #147d73; border-color: #147d73; color: white; }
        .btn-theme:hover { background-color: #10685f; border-color: #10685f; color: white; }
    </style>
    <script>
        function Submit() {
            if(!form2.pwd.value) {
                alert("비밀번호를 입력해주세요");
                form2.pwd.focus();
                return;
            }

            if(form2.pwd.value != form2.pwd1.value) {
                alert("비밀번호가 일치하지 않습니다.");
                form2.pwd1.focus();
                return;
            }

            form2.submit();
        }
    </script>
</head>


<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card member-card border-0 shadow-sm mx-auto">
                <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <span class="member-accent d-inline-block rounded-pill mb-3"></span>
                    <h2 class="fw-bold mb-2">비밀번호 변경</h2>
                    <p class="text-secondary mb-0">새로 사용할 비밀번호를 입력해주세요.</p>
                </div>

                <form name="form2" method="post" action="pwd_update.php">
                    <input type="hidden" name="id" id="user_id" class="form-control" value="<?php echo $id; ?>">

                    <div class="mb-3">
                        <label for="user_pwd" class="form-label">비밀번호</label>
                        <input type="password" class="form-control" name="pwd" id="user_pwd"
                            placeholder="새 비밀번호를 입력해주세요.">
                    </div>

                    <!-- 비밀번호 확인 -->
                    <div class="mb-3">
                        <label for="user_pwd1" class="form-label">비밀번호 확인</label>
                        <input type="password" class="form-control" name="pwd1" id="user_pwd1"
                            placeholder="비밀번호를 한번더 입력해주세요.">
                    </div>

                    <div class="text-center mt-4">
                        <a href="javascript:Submit();"
                            class="btn btn-theme rounded-pill px-5 py-2">비밀번호 변경</a><!-- 제출 버튼 추가  -->
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
