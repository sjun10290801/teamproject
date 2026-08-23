<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>신고 상세보기</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .report-container {
            max-width: 900px;
            margin: 60px auto;
        }

        .report-card {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .report-header {
            padding: 20px 25px;
            border-bottom: 1px solid #dee2e6;
            background-color: #fff5f5;
        }

        .report-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .report-body {
            padding: 30px;
        }

        .info-title {
            font-weight: 600;
            color: #555;
        }

        .detail-box {
            margin-top: 10px;
            padding: 20px;
            min-height: 150px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            line-height: 1.7;
        }

    </style>
</head>

<body>

<div class="container report-container">
<?php
 error_reporting(E_ALL);
ini_set('display_errors', 1);
    include "../common.php";

    adminCheck();

    $report_id = $_GET["id"];
    $text = $_GET["text"];
    $sel = $_GET["sel"];

    $stmt = $db->stmt_init();
    $sql = "select m1.id as target, m2.id as id, r.reason, r.text, r.to_member_id from report r inner join member m1 on m1.member_id = r.to_member_id 
            inner join member m2 on r.from_member_id = m2.member_id where r.report_id = ?";
    $stmt->prepare($sql);
    $stmt->bind_param("d", $report_id);
    $stmt->execute();
    $report_result = $stmt->get_result();
    if(!$report_result) {
        exit();
    }

    $report_row = mysqli_fetch_assoc($report_result);

    $to_member_id = $report_row["to_member_id"];
    $reason = $report_row["reason"]
?>
    <div class="report-card">
        <div class="report-header">
            <h3>
                신고 상세보기
            </h3>
        </div>

        <div class="report-body">

            <div class="mb-4">

                <div class="row mb-3">
                    <div class="col-md-3 info-title">
                        신고번호
                    </div>
                    <div class="col-md-9">
                        <?php echo htmlspecialchars($report_id);?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 info-title">
                        신고자 아이디
                    </div>
                    <div class="col-md-9">
                        <?php echo htmlspecialchars($report_row["id"]);?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 info-title">
                        피신고자 아이디
                    </div>
                    <div class="col-md-9">
                        <?php echo htmlspecialchars($report_row["target"]);?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 info-title">
                        신고사유
                    </div>
                    <div class="col-md-9">
                            <?php echo $a_report[$report_row["reason"]];?>
                        </span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="mt-4">

                <h5 class="fw-bold mb-3">
                    상세사유
                </h5>

                <div class="detail-box">
                    <?php echo htmlspecialchars(stripslashes($report_row["text"]));?>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">

                <button type="button"
                        class="btn btn-dark" onclick="location.href='report_delete.php?id=<?php echo $report_id;?>'">
                    반려
                </button>

                <button type="button"
                        class="btn btn-danger" onclick="location.href='report_insert.php?id=<?php echo $to_member_id;?>&text=<?php echo $text;?>&sel=<?php echo $sel;?>&reason=<?php echo $reason;?>'">
                    제재
                </button>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>