<?php
//세션 시작
if(!session_id()) {
	session_start();
}

    $db = mysqli_connect("localhost", "market", "1234", "market");  // localhost db와 연결
    if(!$db) exit("DB연결에러"); // 연결 실패 시 종료

    $a_category = ["카테고리", "디지털기기", "가구", "가전", "의류", "게임", "기타"];
    $n_category = count($a_category);

    $a_bank = ["은행 선택", "국민", "신한", "기업", "하나", "우리"];
    $n_bank = count($a_bank);

	$a_report = ["사기", "욕설·위협", "거래 약속 불이행", "반복적인 광고·도배", "타인 사칭", "개인정보 침해", "부적절한 프로필·게시물", "기타"];
	$n_report = count($a_report);

	$page_line=5;
	$page_block=5;

	// 로그인 했는지 확인
	function loginCheck() {
		if(!isset($_SESSION["id"])) {
            echo("<script>alert('로그인이 필요한 서비스입니다.');</script>");
            echo("<script>location.href='login.php'</script>"); // 로그인 화면으로 돌아감.
            exit();
        }
	}

	// 쿠키 기반으로 id가져오기
	function getId() {
		global $db;
		$session_id = $_SESSION["id"];
    	$sql = "select * from member where id = '$session_id'";
    	$result = mysqli_query($db, $sql);
    	if(!$result) exit("에러 : $sql");

		$row = mysqli_fetch_assoc($result);
    	$id = $row["member_id"];

		return $id;
	}

	function adminCheck() {
		if(!isset($_SESSION["admin_id"])) {
            echo("<script>alert('권한이 없습니다.');</script>");
            echo("<script>location.href='admin_login.php'</script>"); // 로그인 화면으로 돌아감.
            exit();
        }
	}

	// 이미지 업로드
	function imageUpload($name, $direct, $table) {
		global $db;

		$target = $table."_id";

		$filename = $_FILES["image"]["name"]; // 이미지 이름
    	if($filename) { // 확장자 검사 
        $tmp = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // strtolower => 영어 소문자로 변경하는 함수
        // pathinfo(경로, PATHINFO_EXTENSION) => 파일의 확장자만 추출하기 위한 함수

        switch($tmp) { // 확장자가 이미지가 아니면 종료
            case "png": case "jpg": case "jpeg":
                break;
            default:
                echo("이미지(png, jpg, jpeg) 파일만 업로드 가능합니다.");
                exit();
        }

			// 파일 이름 중복 방지 -> "$name" + id
			$sql = "select * from $table order by $target desc"; // 제품 id 내림차순 정렬
			$result = mysqli_query($db, $sql);
			if(!$result) exit("에러 : $sql");

			if($row = mysqli_fetch_assoc($result)) { // 제품이 없다면 제품 id는 1. 제품이 있다면 마지막 제품id + 1
				$num = $row["$target"] + 1;
			} else {
				$num = 1;
			}

			$fname = $name.$num.".".$tmp;
			if($_FILES["image"]["error"] == 0)
			{
				if(!move_uploaded_file($_FILES["image"]["tmp_name"],$direct."/".$fname)) // 업로드
					exit("업로드 실패");
			}


			return $fname;
		}

		return "";
	}

	// 페이지네이션
    function mypagination($query, $args, &$count, &$pagebar)
	{
		global $db, $page_line, $page_block;			// 서버DB 정보

		$page=$_REQUEST["page"] ?? 1;	// page초기화
		
		$url=basename($_SERVER['PHP_SELF']) . "?" . $args;    // 문서이름?전송할 변수들
		
		// 전체 레코드개수
		$sql = strtolower( $query );
		$sql ="select count(*) " . substr($sql, strpos($sql,"from"));
		$result=mysqli_query($db, $sql);
		if (!$result) exit("에러: $sql <br>" . mysqli_error($db));
		$row=mysqli_fetch_array($result);
		$count = $row[0];

		// 페이지내 자료
		$first = ($page-1) * $page_line;
		
		$sql = str_replace(";", "", $query);
		$sql .= " limit $first, $page_line";
		$result=mysqli_query($db, $sql);
		if (!$result) exit("에러: $sql <br>" . mysqli_error($db));

		// pagebar html
		$pages = ceil($count/$page_line);				// 페이지수
		$blocks = ceil($pages/$page_block);			// 블록수 
		$block = ceil($page/$page_block);			// 블록 위치
		$page_s = $page_block * ($block-1);		// 블록의 시작페이지
		$page_e = $page_block * $block;				// 블록의 마지막페이지
		if ($blocks <= $block) $page_e = $pages;

		$pagebar ="<nav>
			<ul class='pagination pagination-sm justify-content-center py-1'>";

		if ($block > 1)				// 이전 블록으로
			$pagebar .="<li class='page-item'>
					<a class='page-link' href='$url&page=$page_s'>◀</a>
				</li>";

		for($i=$page_s+1; $i<=$page_e; $i++)
		{
			if ($page == $i)			// 선택한 page
				$pagebar .="<li class='page-item active'>
						<span class='page-link mycolor1'>$i</span>
					</li>";
			else
				$pagebar .="<li class='page-item'>
						<a class='page-link' href='$url&page=$i'>$i</a>
					</li>";
		}

		if ($block < $blocks)		// 다음 블록으로
			$pagebar .="<li class='page-item'>
					<a class='page-link' href='$url&page=" . $page_e+1 . "'>▶</a>
				</li>";
				
		$pagebar .="</ul>
			</nav>";
			
			
		return $result;
	}
?>