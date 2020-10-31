<?php

namespace Treiner\Http\Controllers\Admin;

use Carbon\Carbon;
use Treiner\Coupon;
use Treiner\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::paginate(25);
        return view('admin.coupons.index', ['coupons' => $coupons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code',
            'percent-off' => 'required|min:0|max:100|integer',
            'amount-off' => 'required|integer|min:0|max:99999',
            'times-redeemable-total' => 'required|integer|max:100000|min:1',
            'times-redeemable-per-person' => 'required|min:1|integer|max:10|lte:times-redeemable-total',
            'coach-id' => 'nullable',
            'currency' => 'required|string|min:3|max:3',
            'redeem-by' => 'required|date|after:now'
        ]);

        Coupon::create([
            'code' => strtoupper($request->input('code')),
            'percent_off' => $request->input('percent-off'),
            'amount_off' => $request->input('amount-off'),
            'times_redeemable_per_person' => $request->input('times-redeemable-per-person'),
            'times_redeemable_total' => $request->input('times-redeemable-total'),
            'coach_id' => $request->input('coach-id'),
            'currency' => $request->input('currency'),
            'redeem_by' => new \Carbon\Carbon($request->input('redeem-by')),
        ]);

        return redirect(route('coupons.index'))->with('message', 'Your coupon code has been successfully created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Treiner\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', ['coupon' => $coupon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Treiner\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'percent-off' => 'required|min:0|max:100|integer',
            'amount-off' => 'required|integer|min:0|max:99999',
            'times-redeemable-total' => 'required|integer|max:100000|min:1',
            'times-redeemable-per-person' => 'required|min:1|integer|max:10|lte:times-redeemable-total',
            'coach-id' => 'nullable',
            'currency' => 'required|string|min:3|max:3',
            'redeem-by' => 'required|date|after:now'
        ]);

        $coupon->update([
            'code' => strtoupper($request->input('code')),
            'percent_off' => $request->input('percent-off'),
            'amount_off' => $request->input('amount-off'),
            'times_redeemable_per_person' => $request->input('times-redeemable-per-person'),
            'times_redeemable_total' => $request->input('times-redeemable-total'),
            'coach_id' => $request->input('coach-id'),
            'currency' => $request->input('currency'),
            'redeem_by' => new \Carbon\Carbon($request->input('redeem-by')),
        ]);
        return redirect(route('coupons.index'))->with('message', 'Your coupon code has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Treiner\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->couponPlayers()->delete();
        $coupon->delete();
        return redirect(route('coupons.index'))->with('message', 'Your coupon has been successfully destroyed.');
    }
}
