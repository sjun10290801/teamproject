<?php
    if(!isset($_COOKIE["cookie_id"])) {
        echo("<script>alert('로그인이 필요한 서비스입니다.');</script>");
        echo("<script>location.href='login.html'</script>"); // 로그인 화면으로 돌아감.
        exit();
    }


    include "common.php";
    
    $cookie_id = $_COOKIE["cookie_id"];

    $sql = "select * from member where id = '$cookie_id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit('에러:$sql');

    $row = mysqli_fetch_assoc($result);
?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>회원 정보 수정</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function FindZip() {
            window.open(
                "zipcode.php",
                "zip",
                "width=440,height=320,scrollbars=no"
            );
        }
    </script>
</head>


<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <h2 class="text-center mb-4">회원 정보 수정</h2>

                <form name="form2">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">아이디</label>

                        <div class="input-group">
                            <input type="text" name="id" id="user_id" value="<?php echo('$cookie_id');?>" class="form-control"
                                placeholder="아이디는 변경할 수 없습니다." readonly>


                        </div>
                    </div>

                    <!-- 비밀번호 입력 -->
                    <div class="mb-3">
                        <label for="user_pwd" class="form-label">새 비밀번호</label>
                        <input type="password" name="pwd" id="user_pwd" class="form-control"
                            placeholder="변경할 경우에만 입력해주세요.">
                    </div>

                    <!-- 비밀번호 확인 -->
                    <div class="mb-3">
                        <label for="user_pwd1" class="form-label">비밀번호 변경 확인</label>
                        <input type="password" name="pwd1" id="user_pwd1" class="form-control"
                            placeholder="비밀번호를 한번더 입력해주세요.">
                    </div>

                    <!-- 이름 입력 -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="user_name" class="form-label">이름 변경</label>
                            <input type="text" name="name" id="user_name" value="<?php echo $row['name'];?>" class="form-control"
                                placeholder="이름을 입력해주세요.">
                        </div>
                    </div>

                    <!-- 휴대폰 -->
                    <div class="mb-3">
                        <label class="form-label">휴대폰 변경</label>

                        <div class="d-flex align-items-center gap-2">
                            <input type="text" name="tel1" value="010" class="form-control" maxlength="3"
                                inputmode="numeric" placeholder="" aria-label="앞자리" style="max-width: 60px;">



                            <input type="text" name="tel2" value="1234" class="form-control" maxlength="4"
                                inputmode="numeric" placeholder="" aria-label="중간자리" style="max-width: 80px;">



                            <input type="text" name="tel3" value="1234" class="form-control" maxlength="4"
                                inputmode="numeric" placeholder="" aria-label="뒤자리" style="max-width: 80px;">
                        </div>
                    </div>

                    <!-- 이메일 입력-->
                    <div class="mb-3">
                        <label for="user_email" class="form-label">이메일 변경</label>

                        <input type="email" name="email" id="user_email" value="test@example.com" class="form-control"
                            placeholder="이메일을 입력해주세요.">
                    </div>


                    <!-- 생년월일 -->
                    <div class="mb-3">
                        <label for="user_birthday" class="form-label">생년월일 변경</label>

                        <div class="d-flex align-items-center gap-2">
                            <input type="date" name="birthday"  id="user_birthday" value="2000-10-10" class="form-control">

                        </div>
                    </div>

                    <!-- 주소 입력 -->
                    <div class="mb-3">
                        <label for="user_address" class="form-label">주소 변경</label>

                        <div class="input-group">
                            <input type="text" name="juso" id="user_address" value="서울특별시 강남구" class="form-control"
                                placeholder="주소를 검색해주세요." readonly>

                            <button type="button" class="btn btn-outline-secondary" onclick="FindZip()">
                                주소 검색
                            </button>
                        </div>

                        <input type="text" name="juso3" value="11" class="form-control mt-2"
                            placeholder="상세 주소를 입력해주세요.">
                    </div>

                     <div class="mb-3">
                        <label for="user_bank" class="form-label">은행명</label>
                        <select class="form-select" aria-label="Default select example" name="bank_name">
                        <?php
                            for($i = 0; $i < $n_bank; $i++) {
                                 echo("<option value='$i'>$a_bank[$i]</option>");
                            }
                        ?>
                    </div>

                    <div class="mb-3">
                        <label for="user_bank_num" class="form-label">계좌번호(-제외)</label>

                        <input type="text" name="bank_num" id="user_bank_num" class="form-control"
                            placeholder="계좌번호를 입력해주세요.(- 제외하고 입력)">
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-dark">
                            회원 정보 수정
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</body>

</html>