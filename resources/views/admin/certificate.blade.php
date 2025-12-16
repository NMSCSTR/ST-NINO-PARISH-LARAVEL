@extends('components.default')

@section('title', 'Certificate of Approval')

@section('content')
<div class="max-w-5xl mx-auto mt-10">

    <button onclick="window.print()" class="mb-6 px-4 py-2 bg-gray-800 text-white rounded hover:bg-black print:hidden">
        Print Certificate
    </button>

    <div class="certificate bg-white">

        <!-- WATERMARK -->
        <div class="watermark">
            <img src="{{ asset('images/stparish.jpg') }}" alt="Watermark Logo">
        </div>

        <!-- LOGO (TOP CENTER) -->
        <div class="logo-container">
            <img src="{{ asset('images/stparish.jpg') }}" alt="Santo Niño Parish Logo" class="logo">
        </div>

        <!-- CHURCH HEADER -->
        <div class="church-header">
            <div class="church-name">SANTO NIÑO PARISH CHURCH</div>
            <div class="church-location">Sta. Maria, Tangub City</div>
            <div class="church-diocese">Archdiocese of Ozamis</div>
        </div>

        <!-- CERTIFICATE TITLE -->
        <div class="title">
            Certificate of Approval
        </div>

        <!-- CONTENT -->
        <div class="content">
            This is to formally certify that the reservation of
            <strong>
                {{ $reservation->member->user->firstname }}
                {{ $reservation->member->user->lastname }}
            </strong>
            for the Sacrament of
            <strong>{{ $reservation->sacrament->sacrament_type }}</strong>,
            scheduled on
            <strong>
                {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F d, Y') }}
            </strong>,
            has been duly examined and officially approved in accordance with
            the canonical and pastoral regulations of the Santo Niño Parish Church.

            <br><br>

            Printed/Viewed by:
            <strong>
                {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
            </strong>

            <br><br>

            Date Approved:
            <strong>
                @if ($reservation->approved_by)
                {{ \Carbon\Carbon::parse($reservation->updated_at)->format('F d, Y') }}
                @else
                <span class="text-gray-400">Not yet approved</span>
                @endif
            </strong>
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

    /* CERTIFICATE BORDER */
    .certificate {
        position: relative;
        border: 6px double #000;
        padding: 60px 50px;
        background: #fff;
        overflow: hidden;
    }

    /* WATERMARK */
    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.05;
        z-index: 0;
    }

    .watermark img {
        width: 400px;
    }

    /* LOGO */
    .logo-container {
        text-align: center;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .logo {
        width: 110px;
        height: auto;
    }

    /* CHURCH HEADER */
    .church-header {
        text-align: center;
        line-height: 1.3;
        margin-bottom: 40px;
        position: relative;
        z-index: 1;
    }

    .church-name {
        font-size: 22px;
        font-weight: bold;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .church-location {
        font-size: 16px;
        font-style: italic;
        margin-top: 2px;
    }

    .church-diocese {
        font-size: 14px;
        margin-top: 2px;
    }

    /* TITLE */
    .title {
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 35px;
        position: relative;
        z-index: 1;
    }

    /* CONTENT */
    .content {
        font-size: 18px;
        line-height: 1.9;
        text-align: justify;
        margin: 0 60px;
        position: relative;
        z-index: 1;
    }

    .text-gray-400 {
        color: #9ca3af;
    }

    /* FOOTER */
    .footer {
        margin-top: 90px;
        display: flex;
        justify-content: space-between;
        padding: 0 70px;
        position: relative;
        z-index: 1;
    }

    .signature-block {
        text-align: center;
        font-size: 16px;
    }

    .signature-title {
        font-style: italic;
        font-size: 14px;
    }

    @media print {
        button {
            display: none !important;
        }
    }
</style>
@endpush
