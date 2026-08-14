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
      if (form1.text.value == 0) {
        alert("검색어를 입력 해주세요");
        form1.text.focus();
        return;
      }
      form1.submit();
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php
  $text = $_POST["text"] ?? "";
  $location = $_POST["location"] ?? "";
  ?>
  <nav class="navbar bg-white fixed-top border-bottom shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="리픽" style="height: 40px;" draggable="false">
      </a>

      <form class="d-flex flex-grow-1 mx-4" action="search.php"
        role="search" style="max-width: 650px;"
        method="post" name="form1">

        <input class="form-control me-2" type="search"
          placeholder="물건"
          name="text" value="<?php echo $text; ?>">

        <input class="form-control me-2" type="search"
          placeholder="위치"
          name="location" value="<?php echo $location; ?>">

        <a href="javascript:Submit();"
          class="btn text-white"
          style="background-color: #18766d;">
          <i class="bi bi-search"></i>
        </a>
      </form>

      <div class="d-flex align-items-center gap-3 flex-shrink-0">
        <a href="product_create.php"
          class="btn text-white text-nowrap"
          style="background-color: #18766d;">
          상품등록
        </a>

        <a href="chat_list.php"
          class="text-dark text-decoration-none text-nowrap">
          채팅
        </a>

        <a href="member_mypage.php"
          class="text-dark text-decoration-none text-nowrap">
          마이페이지
        </a>

        <a href="reviews.php"
          class="text-dark text-decoration-none text-nowrap">
          내 후기
        </a>

        <?php
        $cookie_id = $_COOKIE["cookie_id"] ?? "";

        if ($cookie_id) {
        ?>
          <a href="logout.php"
            class="text-dark text-decoration-none text-nowrap">
            로그아웃
          </a>
        <?php
        } else {
        ?>
          <a href="login.php"
            class="text-dark text-decoration-none text-nowrap">
            로그인
          </a>
        <?php
        }
        ?>
      </div>
    </div>
  </nav>



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