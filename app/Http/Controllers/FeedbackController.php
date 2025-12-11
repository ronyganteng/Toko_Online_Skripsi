<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Simpan kritik & saran dari halaman Contact Us (user).
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'pesan' => 'required|string|min:5',
        ], [
            'pesan.required' => 'Pesan tidak boleh kosong.',
            'pesan.min'      => 'Pesan minimal 5 karakter.',
        ]);

        Feedback::create([
            'email'   => $request->email,
            'message' => $request->pesan,
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Terima kasih, kritik dan saran Anda sudah kami terima 🙏');
    }

    /**
     * Halaman admin: daftar semua kritik & saran.
     */
    public function index()
    {
        $feedback = Feedback::latest()->paginate(10);

        return view('admin.page.feedback', [
            'name'     => 'Feedback',
            'title'    => 'Kritik & Saran Pelanggan',
            'feedback' => $feedback,
        ]);
    }

    /**
     * Hapus satu feedback (admin).
     */
    public function destroy($id)
    {
        $data = Feedback::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('admin.feedback.index')
            ->with('success', 'Kritik & saran berhasil dihapus.');
    }
}
