<?php

namespace App\Http\Controllers;

use App\Models\InformasiDesa;
use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\ProfilDesa;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    private function getProfilDesa(): ProfilDesa
    {
        return ProfilDesa::getSingleton();
    }

    /** Homepage */
    public function index()
    {
        $profil   = $this->getProfilDesa();
        $layanan  = JenisSurat::where('is_active', true)->take(6)->get();
        $berita   = InformasiDesa::published()
            ->whereIn('kategori', ['berita', 'pengumuman'])
            ->latest('published_at')
            ->take(3)
            ->get();
        $totalPenduduk = Penduduk::where('is_aktif', true)->count();

        return view('public.home', compact('profil', 'layanan', 'berita', 'totalPenduduk'));
    }

    /** Halaman profil desa */
    public function profil()
    {
        $profil = $this->getProfilDesa();
        return view('public.profil', compact('profil'));
    }

    /** Halaman layanan surat */
    public function layanan()
    {
        $profil  = $this->getProfilDesa();
        $layanan = JenisSurat::where('is_active', true)->get();
        return view('public.layanan', compact('profil', 'layanan'));
    }

    /** Halaman daftar informasi/berita */
    public function informasi(Request $request)
    {
        $profil    = $this->getProfilDesa();
        $kategori  = $request->get('kategori');
        $query     = InformasiDesa::published()->latest('published_at');
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        $berita = $query->paginate(9);
        return view('public.informasi.index', compact('profil', 'berita', 'kategori'));
    }

    /** Detail berita/informasi */
    public function showInformasi(string $slug)
    {
        $profil  = $this->getProfilDesa();
        $artikel = InformasiDesa::published()->where('slug', $slug)->firstOrFail();
        $artikel->increment('view_count');

        $related = InformasiDesa::published()
            ->where('kategori', $artikel->kategori)
            ->where('id', '!=', $artikel->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.informasi.show', compact('profil', 'artikel', 'related'));
    }
}
