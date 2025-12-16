<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Approval</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            margin: 40px;
        }
        .certificate {
            border: 5px double #000;
            padding: 40px;
        }
        .title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .content {
            font-size: 18px;
            line-height: 1.8;
            text-align: justify;
        }
        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>

<button onclick="window.print()">Print Certificate</button>

<div class="certificate">
    <div class="title">Certificate of Approval</div>

    <div class="content">
        This certifies that the reservation of
        <strong>
            {{ $reservation->member->user->firstname }}
            {{ $reservation->member->user->lastname }}
        </strong>
        for the sacrament of
        <strong>{{ $reservation->sacrament->sacrament_type }}</strong>
        scheduled on
        <strong>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F d, Y') }}</strong>
        has been officially approved by the Santo Niño Parish Church.

        <br><br>

        Approved by:
        <strong>
            {{ $reservation->approvedBy->firstname }}
            {{ $reservation->approvedBy->lastname }}
        </strong><br>

        Date Approved:
        <strong>
            {{ \Carbon\Carbon::parse($reservation->updated_at)->format('F d, Y') }}
        </strong>
    </div>

    <div class="footer">
        <div>
            ___________________________<br>
            Parish Office
        </div>
        <div>
            ___________________________<br>
            Parish Priest
        </div>
    </div>
</div>

</body>
</html>
