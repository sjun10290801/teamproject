<?php
    include "common.php";
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 상품 등록 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<script>
    function FindZip(zip_kind) 
	{
		w=window.open("zipcode.php?zip_kind="+zip_kind, "zip", 
			"width=440,height=320,scrollbars=no");
	}
</script>
    <form method="post" name="form2" action="product_insert.php" enctype="multipart/form-data"> <!-- 제출용 폼 태그 추가  -->
        <div class="container">
            <h2 class="text-center mb-4">제품 등록</h2>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <select class="form-select" aria-label="Default select example" name="category">
                        <?php
                            for($i = 0; $i < $n_category; $i++) {
                                if($i == 0) { 
                                    $tmp = "selected";
                                } else {
                                    $tmp = "";
                                }
                                echo("<option value='$i' $tmp>$a_category[$i]</option>");
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="product_name" class="form-label">제품명</label>
                    <input type="text" name="name" class="form-control" id="product_name" placeholder="제품명을 입력해주세요.">
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="product_price" class="form-label">가격</label>
                    <input type="text" name="price" class="form-control" id="product_price" placeholder="">
                </div>
            </div>

            <div class="d-flex gap-2 mb-2">
				<input type="text" name="juso" id="zip11" class="form-control custom-dark-input" style="max-width: 140px;" readonly>
				<a href="javascript:FindZip(0);" class="btn btn-premium-inline text-nowrap">
					<i class="bi bi-geo-alt me-1"></i> 주소찾기
			    </a>
		    </div>
				<input type="text" name="juso3" id="juso11" class="form-control custom-dark-input" placeholder="상세 주소를 입력하세요">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="product_description" class="form-label">제품 설명</label>
                    <textarea class="form-control" name="text" id="product_description" placeholder="제품에 대한 설명을 입력해주세요."
                        rows="3"></textarea>
                </div>
            </div>
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label" >제품 사진 등록</label>
                <input class="form-control" type="file" id="formFileMultiple" multiple name="image">
            </div>
            <div class="text-center">
                <button type="submit"  class="btn btn-primary">등록</button> <!-- 제출 버튼 추가  -->
            </div>
        </div>
    </form>
</body>

</html>