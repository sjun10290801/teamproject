<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인화면</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
      <style>
    body {
        padding-top: 50px; 
    }
    </style>

          <style>
    body {
        padding-bottom: 50px; 
    }
    </style>

    <style>
        .search-container {
            display: flex;
            justify-content: space-between;
            ;
            padding: 20px;
            width: 100%;
        }
    </style>

    <style>
        .card-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }
    </style>

    <style>
        .product-card {
            border: 1px solid #000000;
            padding: 15px;
            width: 320px;
            height: 400px;
        }
    </style>
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>

<body>
  <script>
    function Submit() {
            if(form1.text.value == 0) {
                alert("검색어를 입력 해주세요");
                form1.text.focus();
                return;
            }
            form1.submit();
    }
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<nav class="navbar bg-body-tertiary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
    <img src="images/logo.png" alt="리픽" style="height: 40px;"  draggable="false">
</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">메뉴</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="login.php">로그인</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="chat_list.php">채팅</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="member_mypage.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              마이페이지
            </a>
          </button>
          <ul class="dropdown-menu dropdown-menu-lights">
            <li><a class="dropdown-item" href="member_mypage.php">내정보</a></li>
            <li><a class="dropdown-item" href="good.php">찜한목록</a></li>
            <li><a class="dropdown-item" href="product_create.php">상품등록</a></li>
            <li><a class="dropdown-item" href="member_mypage.php?kind=sell">판매관리</a></li>
            <li><a class="dropdown-item" href="member_mypage.php?kind=buy">구매내역</a></li>
            <li><a class="dropdown-item" href="reviews.html">내후기보기</a></li>
          </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<?php
  $text = $_POST["text"] ?? "";
  $location = $_POST["location"] ?? "";
?>
  <form class="d-flex mt-3" action="search.php" role="search" style="max-width: 500px;" method="post" name="form1">
  <input class="form-control me-2" type="search" placeholder="물건" aria-label="Search" name="text" value="<?php echo $text;?>"/>
  <input class="form-control me-2" type="search" placeholder="위치" aria-label="Search" name="location" value="<?php echo $location;?>"/>
  <a href="javascript:Submit();" class="btn btn-sm btn-dark text-white text-nowrap">검색하기</a>
</form>

<div id="carouselExampleIndicators" class="carousel slide mt-3 mb-2">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/banner-wide.png" class="d-block w-100 object-fit-cover" style="height: 450px;" object-position: center; alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/banner2-wide.png" class="d-block w-100 object-fit-cover" style="height: 450px;" object-position: center; alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/banner3-wide.png" class="d-block w-100 object-fit-cover" style="height: 450px;" object-position: center; alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
 <button class="carousel-control-next" type="button"
  data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
  <span class="carousel-control-next-icon" aria-hidden="true"></span>
  <span class="visually-hidden">Next</span>
</button>
</div>

<?php
$a_category = ["카테고리", "디지털기기", "가구", "가전", "의류", "게임", "기타"];
$n_category = count($a_category);
?>

<ul class="nav justify-content-center align-items-center gap-2 py-3 border-bottom bg-white">
  <li class="nav-item">
    <span class="nav-link fw-bold text-dark ps-0">
      카테고리
    </span>
  </li>

  <?php
  for ($i = 1; $i < $n_category; $i++) {
  ?>
    <li class="nav-item">
      <a class="nav-link text-secondary rounded-pill px-3 category-link"
        href="category.php?menu=<?php echo $i; ?>">
        <?php echo $a_category[$i]; ?>
      </a>
    </li>
  <?php } ?>
</ul>
