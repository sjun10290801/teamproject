<?php
include "../common.php";

adminCheck();

$member_id = $_GET["member_id"];

// 대상 회원의 정보 조회
$sql = "select id, name, tel, email, birthday, juso1, juso2, juso3, bank_name from member where member_id = $member_id";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");

$row = mysqli_fetch_assoc($result);

if (substr($row["tel"], 0, 2) == "02") {
  $tel1 = substr($row["tel"], 0, 2);
  $tel2 = substr($row["tel"], 2, 4);
  $tel3 = substr($row["tel"], 6, 4);
} else {
  $tel1 = substr($row["tel"], 0, 3);
  $tel2 = substr($row["tel"], 3, 4);
  $tel3 = substr($row["tel"], 7, 4);
}

$juso = $row["juso1"] . " " . $row["juso2"] . " " . $row["juso3"];
?>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container mt-5 mb-5">
  <div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-bold">관리자-회원수정</h2>
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link active bg-dark" aria-current="page" href="admin_member.php">회원관리</a>
      </li>
    </ul>
  </div>
</div>

<body>
  <script>
    function FindZip() {
      window.open(
        "../zipcode.php",
        "zip",
        "width=440,height=320,scrollbars=no"
      );
    }

    function Submit() {

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

      if (!form2.email.value) {
        alert("이메일을 입력해주세요.");
        form2.email.focus();
        return;
      }

      if (!form2.birthday.value) {
        alert("생년월일을 입력해주세요.");
        form2.birthday.focus();
        return;
      }

      if (!form2.juso.value) {
        alert("주소를 입력해주세요.");
        form2.juso.focus();
        return;
      }

      if (!form2.juso3.value) {
        alert("상세주소를 입력해주세요.");
        form2.juso3.focus();
        return;
      }

      if (form2.bank_name.value == 0) {
        alert("은행명을 입력해주세요.");
        form2.bank_name.focus();
        return;
      }

      form2.submit();
    }
  </script>
  <form method="post" action="member_update.php" name="form2">
    <div class="mb-3">
      <div class="col-md-6 mx-auto">
        <label for="formGroupExampleInput" class="form-label">회원번호</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="회원번호" value="<?php echo $member_id; ?>" name="member_id" readonly>
      </div>
    </div>


    <div class="mb-3">
      <div class="col-md-6 mx-auto">
        <label for="formGroupExampleInput" class="form-label">아이디</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="아이디" value="<?php echo $row["id"]; ?>" name="id" readonly>
      </div>
    </div>

    <div class="mb-3">
      <div class="col-md-6 mx-auto">
        <label for="formGroupExampleInput" class="form-label">이름</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="이름" value="<?php echo $row["name"]; ?>" name="name">
      </div>
    </div>

    <div class="mb-3">
      <div class="col-md-6 mx-auto">
        <label for="formGroupExampleInput" class="form-label">휴대폰번호</label>
        <div class="d-flex align-items-center gap-2">
          <input type="text" class="form-control text-center" value="<?php echo $tel1; ?>" maxlength="3" name="tel1">
          <span>-</span>
          <input type="text" class="form-control text-center" maxlength="4" value="<?php echo $tel2; ?>" name="tel2">
          <span>-</span>
          <input type="text" class="form-control text-center" maxlength="4" value="<?php echo $tel3; ?>" name="tel3">
        </div>
      </div>
    </div>

    <div class="mb-3">
      <div class="col-md-6 mx-auto">
        <label for="formGroupExampleInput" class="form-label">이메일</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="이메일" value="<?php echo $row["email"]; ?>" name="email">
      </div>
    </div>

    <div class="mb-3">
      <div class="col-md-6 mx-auto">
        <label for="formGroupExampleInput" class="form-label">생년월일</label>
        <input type="date" class="form-control" id="formGroupExampleInput" placeholder="0000-00-00" value="<?php echo $row["birthday"]; ?>" name="birthday">
      </div>
    </div>

    <div class="mb-3">
      <div class="col-md-6 mx-auto">
        <label for="user_address" class="form-label">주소 변경</label>

        <div class="input-group">
          <input type="text" name="juso" id="user_address" value="<?php echo $juso; ?>"
            class="form-control" placeholder="주소를 검색해주세요." readonly>

          <button type="button" class="btn btn-outline-secondary" onclick="FindZip()">
            주소 검색
          </button>
        </div>

        <input type="text" name="juso3" value="<?php echo $row["juso3"]; ?>"
          class="form-control mt-2" placeholder="상세 주소를 입력해주세요.">
      </div>
    </div>

    <div class="mb-3">
      <div class="col-md-6 mx-auto">
        <label for="formGroupExampleInput" class="form-label">은행</label>
        <select class="form-select" aria-label="Default select example" name="bank_name">
          <?php
          for ($i = 0; $i < $n_bank; $i++) {
            if ($a_bank[$i] == $row["bank_name"]) $tmp = "selected";
            else $tmp = "";
            echo ("<option value='$i' $tmp>$a_bank[$i]</option>");
          }
          ?>
          </select>
      </div>
    </div>

    <div class="col-md-6 mx-auto">
    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="admin_member.php" class="btn btn-secondary px-4">취소</a>
        <a href="javascript:Submit();" class="btn btn-primary px-4">수정 완료</a>
    </div>
</div>

</form>

</body>

</html>