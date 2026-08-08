<?php
    $db = mysqli_connect("localhost", "market", "1234", "market");  // localhost db와 연결
    if(!$db) exit("DB연결에러"); // 연결 실패 시 종료

    $a_category = ["카테고리", "디지털기기", "가구", "가전", "의류", "게임", "기타"];
    $n_category = count($a_category);

    $a_bank = ["은행 선택", "국민", "신한", "기업", "하나", "우리"];
    $n_bank = count($a_bank);

	$page_line=5;
	$page_block=5;

	function loginCheck() {
		if(!isset($_COOKIE["cookie_id"])) {
            echo("<script>alert('로그인이 필요한 서비스입니다.');</script>");
            echo("<script>location.href='login.php'</script>"); // 로그인 화면으로 돌아감.
            exit();
        }
	}

	function getId() {
		global $db;
		$cookie_id = $_COOKIE["cookie_id"];
    	$sql = "select * from member where id = '$cookie_id'";
    	$result = mysqli_query($db, $sql);
    	if(!$result) exit("에러 : $sql");

		$row = mysqli_fetch_assoc($result);
    	$id = $row["member_id"];

		return $id;
	}

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