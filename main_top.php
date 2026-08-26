<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>메인화면</title>

  <link href="https://hangeul.pstatic.net/hangeul_static/css/nanum-square-round.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


  <style>
    body {
      font-family: "NanumSquareRound", sans-serif;
      padding-top: 50px;
    }
  </style>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php
  include_once "common.php";
  // 로그인 한 경우 주소 가져오기
  if (isset($_SESSION["id"]) && !(isset($_GET["text"]))) {
    $member_id = getId();
    $sql = "select juso2 from member where member_id = $member_id";
    $top_result = mysqli_query($db, $sql);
    if (!$top_result) {
      echo "<script>alert('오류가 발생했습니다.'); history.back();</script>";
      exit();
    }

    $top_row = mysqli_fetch_assoc($top_result);
    $location = $top_row["juso2"];
  } else {
    $location = "";
  }

  $text = $_GET["text"] ?? "";
  $location = $_GET["location"] ?? $location;
  ?>
  <nav class="navbar bg-white fixed-top border-bottom shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="리픽" style="height: 40px;" draggable="false">
      </a>

      <form class="d-flex flex-grow-1 mx-4 gap-2" action="search.php"
        role="search" style="max-width: 650px;"
        method="get" name="form1">

        <input class="form-control border-0 rounded-3 px-3" type="search"
          placeholder="어떤 상품을 찾으세요?"
          name="text" value="<?php echo htmlspecialchars($text); ?>"
          style="flex: 2; background-color: #f3f7f7;">

        <input class="form-control border-0 rounded-3 px-3" type="search"
          placeholder="지역"
          name="location" value="<?php echo htmlspecialchars($location); ?>"
          style="flex: 1; background-color: #f3f7f7;">

        <button type="submit"
          class="btn text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
          style="width: 42px; height: 42px; background-color: #18766d;"
          aria-label="검색">
          <i class="bi bi-search fs-5"></i>
        </button>
      </form>

      <div class="d-flex align-items-center gap-3 flex-shrink-0">
        <a href="product_create.php"
          class="btn text-white text-nowrap rounded-pill px-4 py-2 fw-semibold shadow-sm"
          style="background-color: #18766d;">
          <i class="bi bi-plus-lg me-1"></i>상품 등록
        </a>

        <div class="dropdown">
          <a href="#" class="text-dark text-decoration-none text-nowrap dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            마이페이지
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-3">
            <li><a class="dropdown-item" href="member_mypage.php"><i class="bi bi-person me-2"></i>마이페이지 홈</a></li>
            <li><a class="dropdown-item" href="reviews.php"><i class="bi bi-star me-2"></i>내 후기</a></li>
            <li><a class="dropdown-item" href="good.php"><i class="bi bi-heart me-2"></i>찜 목록</a></li>
            <li><a class="dropdown-item" href="chat_list.php"><i class="bi bi-chat-dots me-2"></i>채팅</a></li>
          </ul>
        </div>

        <?php
        $session_id = $_SESSION["id"] ?? "";

        if ($session_id) {
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
