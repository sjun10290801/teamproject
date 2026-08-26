<?php
include "main_top.php";
?>
<script>
    function Submit() {
        if (!login_form.id.value) {
            alert("아이디를 입력해주세요.");
            form.id.focus();
            return;
        }

        if (!login_form.pwd.value) {
            alert("비밀번호를 입력해주세요");
            form.pwd.focus();
            return;
        }

        login_form.submit();
    }

    window.onload = function() { // 창 싨행시 바로 실행되는 함수
        login_form.id.focus();
        window.scrollTo(0, 400);
    }
</script>
<main class="container py-5" style="max-width: 450px;">
    <form name="login_form" method="post" action="login_check.php">
        <fieldset class="border-0 rounded-3 bg-white shadow-sm p-4">
            <legend class="float-none w-100 text-center fs-3 fw-bold mb-4">
                로그인
            </legend>
            <div class="mb-3">
                <label for="userid" class="form-label">아이디</label>
                <input type="text" name="id" id="userid" class="form-control" placeholder="아이디를 입력해주세요">
            </div>
            <div class="mb-4">
                <label for="userpw" class="form-label">비밀번호</label>
                <input type="password" name="pwd" id="userpw" class="form-control" placeholder="비밀번호를 입력해주세요">
            </div>
            <div class="d-grid mb-3">
                <a href="javascript:Submit()" class="btn text-white" style="background-color: #18766d;">
                    로그인
                </a>
            </div>
            <div class="d-flex justify-content-center gap-3">
                <a href="member_join.php"
                    class="text-secondary text-decoration-none">
                    회원가입
                </a>

                <a href="pwd_search.php"
                    class="text-secondary text-decoration-none">
                    비밀번호 찾기
                </a>
            </div>
            <br>
        </fieldset>
    </form>
</main>
</body>

</html>
<?php
include "main_bottom.php";
?>