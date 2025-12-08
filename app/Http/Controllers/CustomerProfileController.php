<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class CustomerProfileController extends Controller
{
    // TAMPILKAN PROFIL
    public function show()
    {
        $customer = Auth::guard('customer')->user();

        return view('pelanggan.page.profile', [
            'title'    => 'Profil Saya',
            'count'    => 0, // kalau mau pakai cart badge
            'customer' => $customer,
        ]);
    }

    // FORM EDIT PROFIL
    public function edit()
    {
        $customer = Auth::guard('customer')->user();

        return view('pelanggan.page.profile-edit', [
            'title'    => 'Edit Profil',
            'count'    => 0,
            'customer' => $customer,
        ]);
    }

    // SIMPAN PERUBAHAN PROFIL (TERMASUK FOTO)
    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:customers,email,' . $customer->id,
            'phone'      => 'required|string|max:20',
            'address1'   => 'required|string|max:255',
            'address2'   => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'lat'        => 'nullable|numeric',
            'lng'        => 'nullable|numeric',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $customer->name       = $request->name;
        $customer->email      = $request->email;
        $customer->phone      = $request->phone;
        $customer->address1   = $request->address1;
        $customer->address2   = $request->address2;
        $customer->birth_date = $request->birth_date;
        $customer->lat        = $request->lat;
        $customer->lng        = $request->lng;

        // HANDLE FOTO PROFIL
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            // hapus foto lama kalau ada
            if ($customer->photo && File::exists(public_path('storage/customer/'.$customer->photo))) {
                File::delete(public_path('storage/customer/'.$customer->photo));
            }

            $filename = date('YmdHis') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/customer'), $filename);

            $customer->photo = $filename;
        }

        $customer->save();

        return redirect()->route('customer.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    // UPDATE PASSWORD
    public function updatePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $customer->password = Hash::make($request->password);
        $customer->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}
