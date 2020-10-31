<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers;

use Arr;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use Treiner\BillingAddress;
use Treiner\CartItem;
use Treiner\Conversation;
use Treiner\CouponPlayer;
use Treiner\Http\Requests\BillingRequest;
use Treiner\Payment\PaymentHandler;
use Treiner\Session;

class CartItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(CartItem::class, 'book');
    }

    /**
     * Store a newly created cart item in the cart.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::user()->player->clearCart();

        CartItem::create([
            'player_id' => Auth::user()->player->id,
            'players' => $request->input('number'),
            'session_id' => $request->input('session_id'),
        ]);

        return redirect(route('book.index'));
    }

    public function storeFromUrl(Session $session) {
        Auth::user()->player->clearCart();

        CartItem::create([
            'player_id' => Auth::user()->player->id,
            'players' => 1,
            'session_id' => $session->id,
        ]);

        return redirect(route('book.index'));
    }

    public function index()
    {
        if (count(Auth::user()->player->cartitems) < 1) {
            return redirect('home');
        }

        return view('cart.cart', ['cartitem' => Auth::user()->player->cartitems->first()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $book)
    {
        $book->delete();

        return redirect(route('book.index'));
    }

    /**
     * Completes the payment from a cart and sends it off
     */
    public function complete(BillingRequest $request)
    {
        $validated = $request->validated();

        $players = [];

        for ($i=0; $i < count($validated['players-name']); $i++) {
            array_push($players, [
                 'name' => $validated['players-name'][$i],
                 'age' => $validated['players-age'][$i],
                 'medical' => $validated['players-medical'][$i],
                  'level'=> $request->input('player_level')[$i],
                  'prefrences' => $request->input('player_preference')[$i]
            ]);
        }

        DB::transaction(function() use ($validated, $players) {

            $token = Arr::has($validated, 'stripeToken') ? $validated['stripeToken'] : null;

            $billingAddress = BillingAddress::create([
                'first_name' => $validated['firstName'],
                'last_name' => $validated['lastName'],
                'street_address' => $validated['streetAddress'],
                'locality' => $validated['locality'],
                'country' => $validated['country'],
                'state' => $validated['state'],
                'postcode' => $validated['postcode'],
            ]);

            $paymentHandler = new PaymentHandler($token, $billingAddress, $players);

            $paymentHandler->fromCart(Auth::user()->player, count($validated['players-name']), $validated['payment-method']);

        });

        return view('cart.purchase-complete');
    }
}
