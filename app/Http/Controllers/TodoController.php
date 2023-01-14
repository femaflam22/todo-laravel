<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('dashboard.register');
    }

    public function index()
    {
        //menampilkan halaman awal atau menampilkan banyak data
        return view('dashboard.login');
    }

    public function registerAccount(Request $request)
    {
        // dd($request->all());
        // validasi input
        $request->validate([
            'email' => 'required|email:dns',
            'username' => 'required|min:4|max:8',
            'password' => 'required|min:4',
            'name' => 'required|min:3',
        ]);
        // input data ke db
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        // redirect kemana setelah berhasil tambah data + dikirim pemberitahuan
        return redirect('/')->with('success', 'Berhasil menambahkan akun! silahkan login');
    }

    public function auth(Request $request)
    {
        // array ke2 sbgai custom msg
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ],[
            'username.exists' => 'username ini belum tersedia',
            'username.required' => 'username harus diisi',
            'password.required' => 'password harus diisi',
        ]);

        $user = $request->only('username', 'password');
        // authentication
        if (Auth::attempt($user)) {
            return redirect()->route('todo.index');
        }else {
            return redirect()->back()->with('error', 'Gagal login, silahkan cek dan coba lagi!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function profile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('dashboard.profile', compact('user'));
    }

    public function userData()
    {
        $users = User::all();
        return view('dashboard.users', compact('users'));
    }

    public function error()
    {
        return view('dashboard.error');
    }

    public function profileUpload()
    {
        return view('dashboard.upload-profile');
    }

    public function changeProfile(Request $request)
    {
        // validasi mimes : menentukan ekstensi file yang boleh di upload
        // image : menentukan bahwa file yg di upload hanya boleh berbentuk image
        $request->validate([
            'image_profile' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        // memasukkan file yg di upload ke input yg name nya image_profile ke dalam variable
        $image = $request->file('image_profile');
        // mengubah nama file yg di upload menjadi waktu random.ekstensinya
        $imgName = time().rand().'.'.$image->extension();
        // cek apakah pada public/assets/img/ sudah terdapat file yang di upload
        // jika tidak ( ! ) maka di dalam if akan dijalankan
        // $image->getClientOriginalName() mengambil nama original dr file yg di upload
        if(!file_exists(public_path('/assets/img/'.$image->getClientOriginalName()))){ 
            // set tempat untuk menyimpan file nya  
            $destinationPath = public_path('/assets/img/');
            // memindahkan file yg diupload ke directory yg telah ditentukan sebelumnya
            $image->move($destinationPath, $imgName);
            $uploaded = $imgName;
        }else {
            $uploaded = $image->getClientOriginalName();
        }
        // kirim nama file ke column image_profile di db, jika berhasil akan diarahkan kembali ke hlaman profile
        User::where('id', Auth::user()->id)->update([
            'image_profile' => $uploaded,
        ]);
        return redirect()->route('todo.profile')->with('successUploadImg', 'Foto profil berhasil diperbarui!');
    }

    public function home()
    {
        // ambil data dari table todos dengan model Todo
        // filter data di database -> where('column', 'perbandingan', 'value')
        // get() -> ambil data 
        // filter data di table todos yang isi column user_id nya sama dengan data history login bagian id
        $todos = Todo::where('user_id', '=', Auth::user()->id)->get();
        // kirim data yang sudah diambil ke file blade / ke file yang menampilkan halaman
        // kirim melalui compact()
        // isi compact sesuaikan dengan nama variable
        return view('dashboard.index', compact('todos'));
    }

    public function complated()
    {
        return view('dashboard.complated');
    }

    public function updateComplated($id)
    {
        // cari data yg mau diubah statusnya jadi 'complated' dan column 'done_time' yang tadinya null, diisi dengan tanggal sekarang (tgl ketika data todo di ubah statusnya)
        // karena status boolean, dan 0 itu untuk kondisi todo on-progress, jd 1 nya untuk kondisi todo complated
        Todo::where('id', '=', $id)->update([
            'status' => 1,
            'done_time' => \Carbon\Carbon::now(),
        ]);
        // apabila berhasil, akan dikembalikan ke halaman awal dengan pemberitahuan
        return redirect()->back()->with('done', 'Todo telah selesai dikerjakan!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //menampilkan halaman input form tambah data
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //menyimpan data ke database
        // tes koneksi blade dengan controller
        // dd($request->all());
        // validasi data
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:5',
        ]);
        // mengirim data ke database table todos dengan model Todo
        // '' = nama column di table db
        // $request-> = value attribute name pada input
        // kenapa yg dikirim 5 data? karena table pada db todos membutuhkan 6 column input
        // salah satunya column 'done_time' yang tipenya nullable, karna nullable jd ga perlu dikirim nilai
        // 'user_id' untuk memberitahu data todo ini milik siapa, diambil melalui fitur Auth
        // 'status' tipenya boolean, 0 = blm dikerjakan, 1 = sudah dikerjakan (todonya)
        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => Auth::user()->id,
            'status' => 0,
        ]);
        return redirect('/todo/')->with('successAdd', 'Berhasil menambahkan data ToDo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //menampilkan satu data spesifik
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //menampilkan halaman input form edit
        //mengambil data satu baris ketika column id pada baris tersebut sama dengan id dari parameter route
        $todo = Todo::where('id', $id)->first();
        //kirim data yang diambil ke file blade dengan compact
        return view('dashboard.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //mengubah data di database
        //validasi
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:5',
        ]);
        //cari baris data yg punya id sama dengan data id yg dikirim ke parameter route
        //kalau uda ketemu, update column-column datanya
        Todo::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => Auth::user()->id,
            'status' => 0,
        ]);
        //kalau berhasil, halaman bakal di redirect ulang ke halaman awal todo dengan pesan pemberitahuan
        return redirect('/todo/')->with('successUpdate', 'Data todo berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //menghapus data di database
        // filter / cari data yang mau dihapus, baru jalankan perintah hapusnya
        Todo::where('id','=', $id)->delete();
        // kalau uda, balik lagi ke halaman awalnya dengan pemberitahuan
        return redirect()->back()->with('deleted', 'Berhasil menghapus data ToDo!');
    }
}
