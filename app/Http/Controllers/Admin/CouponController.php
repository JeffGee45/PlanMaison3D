<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the coupons.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created coupon in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0.01',
            'min_cart_amount' => 'nullable|numeric|min:0',
            'starts_at' => 'required|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        // Generate a unique code if not provided
        if (empty($validated['code'])) {
            $validated['code'] = strtoupper(Str::random(8));
        } else {
            $request->validate([
                'code' => 'required|string|max:50|unique:coupons,code',
            ]);
            $validated['code'] = strtoupper($validated['code']);
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['usage_count'] = 0;

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Le coupon a été créé avec succès.');
    }

    /**
     * Display the specified coupon.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\View\View
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified coupon.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\View\View
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0.01',
            'min_cart_amount' => 'nullable|numeric|min:0',
            'starts_at' => 'required|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['code'] = strtoupper($validated['code']);

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Le coupon a été mis à jour avec succès.');
    }

    /**
     * Remove the specified coupon from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Le coupon a été supprimé avec succès.');
    }

    /**
     * Toggle the active status of the coupon.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update([
            'is_active' => !$coupon->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $coupon->is_active,
            'message' => $coupon->is_active ? 'Le coupon est maintenant actif.' : 'Le coupon est maintenant inactif.'
        ]);
    }
}
