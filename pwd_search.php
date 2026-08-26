<?php
include "main_top.php";
?>
<style>
    body {
        background-color: #f6f9f8;
    }

    .member-card {
        max-width: 580px;
        border-radius: 20px;
    }

    .member-accent {
        width: 42px;
        height: 4px;
        background-color: #147d73;
    }

    .member-card .form-label {
        font-weight: 600;
    }

    .member-card .form-control {
        min-height: 46px;
        border-radius: 10px;
    }

    .btn-theme {
        background-color: #147d73;
        border-color: #147d73;
        color: white;
    }

    .btn-theme:hover {
        background-color: #10685f;
        border-color: #10685f;
        color: white;
    }
</style>
<script>
    function Submit() {

        if (!form2.id.value) {
            alert("아이디를 입력해주세요");
            form2.id.focus();
            return;
        }

        if (!form2.name.value) {
            alert("이름을 입력해주세요.");
            form2.name.focus();
            return;
        }

        if (!form2.tel1.value || !form2.tel2.value || !form2.tel3.value) {
            alert("전화번호를 입력해주세요.");
            form2.tel1.focus();
            return;
        }

        if (!form2.birthday.value) {
            alert("생년월일을 입력해주세요.");
            form2.birthday.focus();
            return;
        }

        form2.submit();
    }
</script>
<div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card member-card border-0 shadow-sm mx-auto">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <span class="member-accent d-inline-block rounded-pill mb-3"></span>
                            <h2 class="fw-bold mb-2">비밀번호 찾기</h2>
                            <p class="text-secondary mb-0">가입할 때 입력한 회원정보를 확인합니다.</p>
                        </div>

                        <form name="form2" method="post" action="pwd_edit.php">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">아이디</label>

                                <div class="input-group">
                                    <input type="text" name="id" id="user_id" class="form-control" placeholder="아이디를 입력해주세요.">
                                </div>
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

                            <!-- 생년월일 -->
                            <div class="mb-3">
                                <label class="form-label">생년월일</label>

                                <div class="d-flex align-items-center gap-2">
                                    <input type="date" name="birthday" class="form-control" maxlength="4" inputmode="numeric"
                                        placeholder="연도" aria-label="출생 연도" style="max-width: 300px;">
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="javascript:Submit();"
                                    class="btn btn-theme rounded-pill px-5 py-2">확인</a><!-- 제출 버튼 추가  -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include "main_bottom.php";
?>
