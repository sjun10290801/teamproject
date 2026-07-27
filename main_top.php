<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인화면</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
</head>

<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<nav class="navbar bg-body-tertiary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">중고거래</a>

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
            <a class="nav-link" href="#">채팅</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              마이페이지
            </a>
          </button>
          <ul class="dropdown-menu dropdown-menu-lights">
            <li><a class="dropdown-item" href="member_mypage.php">내정보</a></li>
            <li><a class="dropdown-item" href="#">찜한목록</a></li>
            <li><a class="dropdown-item" href="#">상품등록</a></li>
            <li><a class="dropdown-item" href="#">판매관리</a></li>
            <li><a class="dropdown-item" href="#">구매내역</a></li>
          </ul>
          </li>
        </ul>
        <form class="d-flex mt-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>