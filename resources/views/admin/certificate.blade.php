@extends('components.default')

@section('title', 'Certificate of Approval')

@section('content')
<div class="max-w-5xl mx-auto mt-10">

    <button onclick="window.print()" class="mb-6 px-4 py-2 bg-gray-800 text-white rounded hover:bg-black print:hidden">
        Print Certificate
    </button>

    <div class="certificate bg-white">
        <div class="title">
            Certificate of Approval
        </div>

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
</div>
@endsection

@push('styles')
<style>
    body {
        font-family: "Times New Roman", serif;
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
        button {
            display: none !important;
        }
    }
</style>
@endpush
