<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
        return view('admin.payments', compact('payments'));
    }

    public function showPaymentMember()
    {
        $memberId = Auth::user()->member->id;
        $payments = Payment::with('reservation.sacrament')
            ->where('member_id', $memberId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.payments', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function payNow(Request $request, Payment $payment)
    {
        $request->validate([
            'receipt' => 'required|image|max:2048',
        ]);

        $path = $request->file('receipt')->store('receipts', 'public');

        $payment->update([
            'receipt_path' => $path,
            'method'       => 'GCash',
            'status'       => 'pending',
        ]);

        return redirect()->route('member.member.payments')->with('success', 'Payment receipt uploaded successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
