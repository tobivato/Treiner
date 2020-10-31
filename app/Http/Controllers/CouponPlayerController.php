<?php

namespace Treiner\Http\Controllers;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Treiner\CartItem;
use Treiner\Coupon;
use Treiner\CouponPlayer;

class CouponPlayerController extends Controller
{
    public function addToCartItem(CartItem $cartItem, Request $request)
    {
        $request->validate([
            'code' => 'string|required|max:255',
        ]);

        $user = Auth::user();

        $coupon = Coupon::find(strtoupper($request->input('code')));

        if (!$coupon) {
            return redirect()->back()->withErrors(['This coupon doesn\'t exist.']);
        }

        if ($user->role_type != 'Treiner\Player') {
            return redirect()->back()->withErrors(['Only players can add coupons.']);
        }

        if ($coupon->redeem_by < Carbon::now()) {
            return redirect()->back()->withErrors(['This code is expired.']);
        }
        
        if ($coupon->currency != $user->currency) {
            return redirect()->back()->withErrors(['This code is not available in your region.']);
        }

        if ($coupon->coach_id && ($cartItem->session->coach_id != $coupon->coach_id)) {
            return redirect()->back()->withErrors(['This code is not available for this coach.']);
        }

        if ($user->player->couponPlayers->where('coupon_id', $coupon->code)->count() >= $coupon->times_redeemable_per_person) {
            return redirect()->back()->withErrors(['You have redeemed this coupon too many times.']);
        }

        if (DB::table('coupon_players')->where('coupon_id', $coupon->code)->count() > $coupon->times_redeemable_total) {
            return redirect()->back()->withErrors(['This code has been redeemed too many times.']);
        }

        if ($cartItem->couponPlayer && $cartItem->couponPlayer->coupon == $coupon) {
            return redirect()->back()->withErrors(['This code has already been applied.']);
        }

        $couponPlayer = CouponPlayer::create([
            'player_id' => $user->player->id,
            'coupon_id' => $coupon->code,
        ]);

        $cartItem->coupon_player_id = $couponPlayer->id;
        $cartItem->save();

        return redirect()->back()->with('message', 'You have successfully added the code to your order.');
    }
}
