<?php
    include "main_top.php";
?>
    <script>
        function Submit() {
            if(!form.id.value) {
                alert("아이디를 입력해주세요.");
                form.id.focus();
                return;
            }

            if(!form.pwd.value) {
                alert("비밀번호를 입력해주세요");
                form.pwd.focus();
                return;
            }

            form.submit();
        }
    </script>
    <div style="max-width: 400px; margin: 50px auto; padding: 20px;">
    <form name="form" method="post" action="login_check.php">
        <fieldset style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
            <legend>로그인화면</legend>
    <p>
        <label for="userid">아이디</label>
        <input type="text" name ="id" id="userid" placeholder="아이디를 입력해주세요">
    </p>
    <p>
        <label for="userpw">비밀번호</label>
        <input type="password" name="pwd" id="userpw" placeholder="비밀번호를 입력해주세요">
    </p>
    <div class="text-center">
        <a href="javascript:Submit()">로그인</a>
    </div>
    <div class="text-center">
        <a href="member_join.php">회원가입</a>
    </div>
    <div class="text-center">
        <a href="pwd_search.html">비밀번호 찾기</a>
    </div>
    <br>
        </fieldset>
    </form>
</div>
</body>
</html>