<?php
    include_once "common.php";
    include "main_top.php";
?>
    <script>
        function FindZip() {
            window.open(
                "zipcode.php",
                "zip",
                "width=440,height=320,scrollbars=no"
            );
        }

        function IdCheck() {
            if(!form2.id.value) {
                alert("아이디를 입력해주세요");
                form2.id.focus();
                return;
            }

            window.open(
                "id_check.php?uid=" + form2.id.value,
                "zip",
                "width=440,height=320,scrollbars=no"
            );
        }

        function Submit() {
            if(form2.check.value == 0) {
                alert("중복 확인을 해주세요");
                form2.id.focus();
                return;
            }

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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <h2 class="text-center mb-4">회원가입</h2>

                <form name="form2" method="post" action="member_insert.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">아이디</label>

                        <div class="input-group">
                            <input type="text" name="id" id="user_id" class="form-control" placeholder="아이디를 입력해주세요.">

                            <a href="javascript:IdCheck();" class="btn btn-sm btn-dark text-white myfont">중복 확인</a>
                            <input type="hidden" name="check" value="0"> <!--id 체크시 1로 바뀜-->
                        </div>
                    </div>

                    <!-- 비밀번호 입력 -->
                    <div class="mb-3">
                        <label for="user_pwd" class="form-label">비밀번호</label>
                        <input type="password" class="form-control" name="pwd" id="user_pwd"
                            placeholder="비밀번호를 입력해주세요.">
                    </div>

                    <!-- 비밀번호 확인 -->
                    <div class="mb-3">
                        <label for="user_pwd1" class="form-label">비밀번호 확인</label>
                        <input type="password" class="form-control" name="pwd1" id="user_pwd1"
                            placeholder="비밀번호를 한번더 입력해주세요.">
                    </div>

                    <!-- 이름 입력 -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="user_name" class="form-label">이름</label>
                            <input type="text" name="name" id="user_name" class="form-control"
                                placeholder="이름을 입력해주세요.">
                        </div>
                    </div>

                    <!-- 휴대폰 -->
                    <div class="mb-3">
                        <label class="form-label">휴대폰</label>

                        <div class="d-flex align-items-center gap-2">
                            <input type="text" name="tel1" class="form-control" maxlength="3" inputmode="numeric"
                                placeholder="" aria-label="앞자리" style="max-width: 60px;">



                            <input type="text" name="tel2" class="form-control" maxlength="4" inputmode="numeric"
                                placeholder="" aria-label="중간자리" style="max-width: 80px;">



                            <input type="text" name="tel3" class="form-control" maxlength="4" inputmode="numeric"
                                placeholder="" aria-label="뒤자리" style="max-width: 80px;">
                        </div>
                    </div>

                    <!-- 이메일 입력-->
                    <div class="mb-3">
                        <label for="user_email" class="form-label">이메일</label>

                        <input type="email" name="email" id="user_email" class="form-control"
                            placeholder="이메일을 입력해주세요.">
                    </div>


                    <!-- 생년월일 -->
                    <div class="mb-3">
                        <label class="form-label">생년월일</label>

                        <div class="d-flex align-items-center gap-2">
                            <input type="date" name="birthday" class="form-control" maxlength="4" inputmode="numeric"
                                placeholder="연도" aria-label="출생 연도" style="max-width: 300px;">
                        </div>
                    </div>

                    <!-- 주소 입력 -->
                    <div class="mb-3">
                        <label for="user_address" class="form-label">주소</label>

                        <div class="input-group">
                            <input type="text" name="juso" id="user_address" class="form-control"
                                placeholder="주소를 검색해주세요." readonly>

                            <button type="button" class="btn btn-outline-secondary" onclick="FindZip()">
                                주소 검색
                            </button>
                        </div>

                        <input type="text" name="juso3" class="form-control mt-2" placeholder="거래에 사용할 상세 주소를 입력해주세요.">
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

                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label" >프로필 사진 등록</label>
                        <input class="form-control" type="file" id="formFileMultiple" multiple name="image">
                    </div>

                    <div class="text-center">
                        <a href="javascript:Submit();" class="btn btn-sm btn-dark text-white myfont">회원가입</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php
    include "main_bottom.php";
?>