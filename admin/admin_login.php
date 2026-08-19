<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<body>
<script>
    function Submit() {
        if(!alogin_form.id.value) {
            alert("아이디를 입력해주세요.");
            alogin_form.id.focus();
            return;
        }

        if(!alogin_form.pwd.value) {
            alert("비밀번호를 입력해주세요.");
            alogin_form.pwd.focus();
            return;
        }

        alogin_form.submit();
    }
</script>
    <div class="card border-dark mb-3 mx-auto mt-5" style="max-width: 25rem;">
        <div class="card-header bg-transparent border-dark text-center">관리자 로그인 화면</div>
        <form method="post" action="admin_login_check.php" name="alogin_form">
            <div class="card-body">
                <div class="mb-3">
                    <label for="userid" class="form-label">아이디</label>
                    <input type="text" name="id" id="userid" class="form-control" placeholder="아이디를 입력해주세요">
                </div>
                <div class="mb-3">
                    <label for="userid" class="form-label">비밀번호</label>
                    <input type="text" name="pwd" id="userpwd" class="form-control" placeholder="비밀번호를 입력해주세요">
                </div>
                <div class="d-grid mt-4">
                    <a class="btn btn-outline-dark" onclick="javascript:Submit();">로그인</a>
                </div>
            </div>

            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">회원가입</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">비밀번호 찾기</a>
                </li>
            </ul>
        </form>
    </div>
    </div>



</body>

</html>