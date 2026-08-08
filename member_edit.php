<?php


    include "common.php";

    loginCheck();
    
    $cookie_id = $_COOKIE["cookie_id"];

    $sql = "select * from member where id = '$cookie_id'"; // 쿠키 id에 맞는 회원정보 레코드 불러오기
    $result = mysqli_query($db, $sql);
    if(!$result) exit('에러:$sql');

    $row = mysqli_fetch_assoc($result);


    // 전화번호 쪼개기
    $tel = $row['tel'];
    if(substr($tel, 0, 2) == "02") {
        $tel1 = substr($tel, 0, 2);
        $tel2 = substr($tel, 2, 4);
        $tel3 = substr($tel, 6, 4);
    } else {
        $tel1 = substr($tel, 0, 3);
        $tel2 = substr($tel, 3, 4);
        $tel3 = substr($tel, 7, 4);
    }

    // 주소 합치기
    $juso1 = $row['juso1'];
    $juso2 = $row['juso2'];
    $juso = $juso1." ".$juso2;

    $image = $row["image"] ?: "default_profile.jpg";

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

        function Submit() {

            if(form2.pwd.value != form2.pwd1.value) {
                alert("비밀번호가 일치하지 않습니다.");
                form2.pwd1.focus();
                return;
            }

            if(!form2.name.value) {
                alert("이름을 입력해주세요.");
                form2.name.focus();
                return;
            }

            if(!form2.tel1.value || !form2.tel2.value || !form2.tel3.value) {
                alert("전화번호를 입력해주세요.");
                form2. tel1.focus();
                return;
            }

            if(!form2.email.value) {
                alert("이메일을 입력해주세요.");
                form2.email.focus();
                return;
            }

            if(!form2.birthday.value) {
                alert("생년월일을 입력해주세요.");
                form2.birthday.focus();
                return;
            }

            if(!form2.juso.value) {
                alert("주소를 입력해주세요.");
                form2.juso.focus();
                return;
            }

            if(!form2.juso3.value) {
                alert("상세주소를 입력해주세요.");
                form2.juso3.focus();
                return;
            }

            if(form2.bank_name.value == 0) {
                alert("은행명을 입력해주세요.");
                form2.bank_name.focus();
                return;
            }

            if(!form2.bank_num.value) {
                alert("계좌번호을 입력해주세요.");
                form2.bank_num.focus();
                return;
            }

            if(form2.bank_num.value.indexOf('-') != -1) {
                alert("-를 제외하고 입력해주세요.");
                form2.bank_num.focus();
                return;
            }

            form2.submit();
        }
    </script>
</head>


<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <h2 class="text-center mb-4">회원 정보 수정</h2>

                <form name="form2" method="post" action="member_update.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">아이디</label>
                        <input type="hidden" name="member_id" id="user_id" value="<?php echo $row['member_id'];?>" class="form-control">
                        <div class="input-group">
                            <input type="text" name="id" id="user_id" value="<?php echo($cookie_id);?>" class="form-control"
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
                            <input type="text" name="tel1" value="<?php echo($tel1);?>" class="form-control" maxlength="3"
                                inputmode="numeric" placeholder="" aria-label="앞자리" style="max-width: 60px;">



                            <input type="text" name="tel2" value="<?php echo($tel2);?>" class="form-control" maxlength="4"
                                inputmode="numeric" placeholder="" aria-label="중간자리" style="max-width: 80px;">



                            <input type="text" name="tel3" value="<?php echo($tel3);?>" class="form-control" maxlength="4"
                                inputmode="numeric" placeholder="" aria-label="뒤자리" style="max-width: 80px;">
                        </div>
                    </div>

                    <!-- 이메일 입력-->
                    <div class="mb-3">
                        <label for="user_email" class="form-label">이메일 변경</label>

                        <input type="email" name="email" id="user_email" value="<?php echo $row['email'];?>" class="form-control"
                            placeholder="이메일을 입력해주세요.">
                    </div>


                    <!-- 생년월일 -->
                    <div class="mb-3">
                        <label for="user_birthday" class="form-label">생년월일 변경</label>

                        <div class="d-flex align-items-center gap-2">
                            <input type="date" name="birthday"  id="user_birthday" value="<?php echo $row['birthday'];?>" class="form-control">

                        </div>
                    </div>

                    <!-- 주소 입력 -->
                    <div class="mb-3">
                        <label for="user_address" class="form-label">주소 변경</label>

                        <div class="input-group">
                            <input type="text" name="juso" id="user_address" value="<?php echo($juso);?>" class="form-control"
                                placeholder="주소를 검색해주세요." readonly>

                            <button type="button" class="btn btn-outline-secondary" onclick="FindZip()">
                                주소 검색
                            </button>
                        </div>

                        <input type="text" name="juso3" value="<?php echo $row['juso3'];?>" class="form-control mt-2"
                            placeholder="상세 주소를 입력해주세요.">
                    </div>

                     <div class="mb-3">
                        <label for="user_bank" class="form-label">은행명</label>
                        <select class="form-select" aria-label="Default select example" name="bank_name">
                        <?php
                            for($i = 0; $i < $n_bank; $i++) {
                                if($a_bank[$i] == $row["bank_name"]) $tmp = "selected";
                                else $tmp = "";
                                 echo("<option value='$i' $tmp>$a_bank[$i]</option>");
                            }
                        ?>
                    </div>

                    <div class="mb-3">
                        <label for="user_bank_num" class="form-label">계좌번호(-제외)</label>

                        <input type="text" name="bank_num" id="user_bank_num" class="form-control"
                            placeholder="계좌번호를 입력해주세요.(- 제외하고 입력)" value="<?php echo $row['bank_num'];?>">
                    </div>
                    <div>
                        <label for="formFileMultiple" class="form-label" >프로필 사진 변경 (이미지 삭제 시 체크) </label>
                        <input type="checkbox" name="check" value="1"> <!--체크박스 체크 시 1 전송-->
                        <img src="images/<?php echo $image;?>" alt="프로필 사진"
                                        class="rounded-circle object-fit-cover border" style="width: 120px; height: 120px;">
                        <input type="hidden" name="image_name" value="<?php echo $row["image"];?>">
                        <input class="form-control" type="file" id="formFileMultiple" multiple name="image">
                    </div><br>
                    <div class="text-center">
                         <a href="javascript:Submit();" class="btn btn-sm btn-dark text-white myfont">수정</a>
                         <a href="javascript:history.back();"  class="btn btn-sm btn-dark text-white myfont">돌아가기</a>
                    </div>

                     <div class="mb-3">
                
            </div>

                </form>

            </div>
        </div>
    </div>
</body>

</html>