<?php
	include "common.php";

   $a_juso = ["주소", "서울", "경기", "인천", "강원", "충청북도", "세종", "충청남도", "대전", "경상북도", "대구", "울산", "부산", "경상남도", "전라북도", "전라남도", "광주", "제주"];
   $n_juso = count($a_juso);
	
	$sel = $_REQUEST["sel"] ?? "1";
	$text1 = $_REQUEST["text1"] ?? "";

?>
<!doctype html>
<html lang="kr" style="overflow:hidden">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fulid">

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script>
	function SearchZip() 
	{
		if (!form.text1.value) 
		{
			alert("주소(시/군/구)를 입력해주세요");
			form.text1.focus();
			return;
		}
		form.submit();
	}
	
	function SendZip() 
	{
		var str;
		str = form1.post_no.value;
		opener.form2.juso.value = str;

		self.close();
	}
</script>

<!--  페이지 제목 -->
<div class="row m-0">
	<div class="col bg-light" align="center">
		<h4 class="m-2">우편번호 (Zipcode)</h4>
	</div>	
	<hr size="4px" class="my-0">
</div>	

<div class="row m-1 mb-0">
	<div class="col" align="center">
		<br>
		<br>
		<!--  form 시작 -->
		<form  name="form" method="post" action="zipcode.php">
		
		<input type="hidden" name="zip_kind" value="<?=$zip_kind;?>">

		<div align="left">
			<font size="2" color="#666666"><b>주소(시/군/구)를 입력해주세요</b></font>
			<div class="d-inline-flex mt-1">
				<div class="input-group input-group-sm">
					<select name="sel" class="form-select form-select-sm bg-light" style="width:100px;font-size:13px">
                    <?php
                        for($i = 1; $i < $n_juso; $i++) {
                            if($i == $sel) $tmp = "selected";
                            else $tmp = "";

                            echo("<option value='$i' $tmp>$a_juso[$i]</option>");
                        }
                    ?>
					</select>				
					<input type="text" name="text1" value="<?=$text1?>" class="form-control" style="width:150px;">
					<a href="javascript:SearchZip()" class="btn btn-sm btn-outline-secondary" 
						style="width:50px;font-size:13px">검색</a>
				</div>
			</div>
		</div>
		</form>
		<br>
		<form name="form1">
		<div class="d-inline-flex w-100 mb-1">
			<select name="post_no" class="form-select form-select-sm bg-light" style="font-size:13px">
				<?
					if($text1)
					{
						$sql="select * from juso where juso1 like '%$a_juso[$sel]%' and juso2 like '%$text1%'";
						$result=mysqli_query($db, $sql);
						if(!$result) exit("에러:$sql");
						
						foreach($result as $row)
						{
                            $juso1 = $row["juso1"];
                            $juso2 = $row["juso2"];
							
                            $juso = $juso1." ".$juso2;

							echo("<option value='$juso'>$juso</option>");
						}
					}
					else
						echo("<option></option>");
				?>
			</select>
		</div>
		</form>
		<br><br>

		<a href="javascript:SendZip();" class="btn btn-sm btn-dark text-white myfont">확 인</a>

	</div>
</div>

<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
