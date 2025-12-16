@extends('components.default')

@section('title', 'Certificate of Approval')

@section('content')
<div class="max-w-5xl mx-auto mt-10">

    <button onclick="window.print()"
        class="mb-6 px-4 py-2 bg-gray-800 text-white rounded hover:bg-black print:hidden">
        Print Certificate
    </button>

    <div class="certificate bg-white">

        <!-- LOGO & CHURCH HEADER -->
        <div class="logo-container">
            <img src="{{ asset('images/stparish.jpg') }}" alt="Santo Niño Parish Logo" class="logo">

            <div class="church-header">
                <div class="church-name">SANTO NIÑO PARISH CHURCH</div>
                <div class="church-location">STA. MARIA, TANGUB CITY</div>
                <div class="church-diocese">ARCHDIOCESE OF OZAMIS</div>
            </div>
        </div>

        <!-- CERTIFICATE TITLE -->
        <div class="title">
            Certificate of Approval
        </div>

        <!-- CERTIFICATE CONTENT -->
        <div class="content">
            This certifies that the reservation of
            <strong>
                {{ $reservation->member->user->firstname }}
                {{ $reservation->member->user->lastname }}
            </strong>
            for the sacrament of
            <strong>{{ $reservation->sacrament->sacrament_type }}</strong>
            scheduled on
            <strong>
                {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F d, Y') }}
            </strong>
            has been officially approved by the Santo Niño Parish Church.

            <br><br>

            Approved by:
            <strong>
                {{ $reservation->approvedBy->firstname }}
                {{ $reservation->approvedBy->lastname }}
            </strong>
            <br>

            Date Approved:
            <strong>
                {{ \Carbon\Carbon::parse($reservation->updated_at)->format('F d, Y') }}
            </strong>
        </div>

        <!-- FOOTER SIGNATURES -->
        <div class="footer">
            <div class="signature-block">
                ___________________________<br>
                Parish Office
            </div>

            <div class="signature-block">
                ___________________________<br>
                Parish Priest
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        font-family: "Times New Roman", serif;
    }

    .certificate {
        border: 5px double #000;
        padding: 50px 40px;
        text-align: center;
    }

    .logo-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 120px;
        height: auto;
        margin-bottom: 10px;
    }

    .church-header {
        text-align: center;
        margin-top: 10px;
        line-height: 1.2;
    }

    .church-name {
        font-size: 22px;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .church-location {
        font-size: 16px;
        font-style: italic;
    }

    .church-diocese {
        font-size: 14px;
        font-weight: normal;
    }

    .title {
        text-align: center;
        font-size: 28px;
        font-weight: bold;
        margin: 40px 0 30px 0;
        text-decoration: underline;
    }

    .content {
        font-size: 18px;
        line-height: 1.8;
        text-align: justify;
        margin: 0 50px;
    }

    .footer {
        margin-top: 80px;
        display: flex;
        justify-content: space-between;
        padding: 0 60px;
    }

    .signature-block {
        text-align: center;
        font-size: 16px;
    }

    @media print {
        button {
            display: none !important;
        }
    }
</style>
@endpush
