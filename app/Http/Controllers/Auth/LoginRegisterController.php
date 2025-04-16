<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use  Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class LoginRegisterController extends Controller
{
    public function index()
    {
        //get Data db
        $users = User::latest()->paginate(10);

        return view('admin.akun.index',compact('users'));

    }
    public function create()
    {
        return view('admin.akun.create');
    }
    
    public function register()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'usertype' => 'required'                                                                 

        ]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   

        User::create([
            'name' => $request->name,
            'email' => $request->email,                                                                                                                                          
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype
        ]);
        return redirect()->route('akun.index')->with(['success'=>'data berhasil disimpan']);
        // $credentials = $request->only('email','password');
        // Auth::attempt($credentials);
        // $request->session()->regenerate();

        // if ($request->user()->usertype == 'admin'){
        //     return redirect('admin/dashboard')->withSuccess('You have successfully registered & logged in!');
        // }

        // return redirect()->intended(route('dashboard'));
    }
     public function login()
     {
        return view('auth.login');
     }

     public function authenticate(request $request)
     {
        $crendentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($crendentials)){
            $request->session()->regenerate();
            if ($request->user()->usertype == 'admin') {
                return redirect('admin/dashboard')->withSuccess('You have successfully logged in!');
            }
        }

        return back()->withErrors([
            'email' => 'Your provided crendentials do not match in our records.',
        ])->onlyInput('email');
     }
     public function logout(Request $request)
     {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
        ->withSuccess('You have logged out successfully!');;
     }

     public function update(Request $request, $id): RedirectResponse
     {
        //validate form
        $validate = $request->validate([
            'name' => 'require|string|max:250px',
            'usertype' =>'required'
        ]);

        //get post by id
        $datas = User::fidOrFail($id);
        //edit akun

        $datas->update ([
            'name' =>$request->name,
            'usertype' => $request->usertype
        ]);

        //redirect to index
        return redirect()->route ('akun.index',$id)->with(['success' => 'data berhasil di ubah!']);

     }
     public function updateEmail( Request $request,$id) :RedirectResponse
     {
        //validate form
        $validate = $request->validate([
            'email' => 'require|email|max:250|unique:users'
            
        ]);

        //get post by id
        $datas = User::fidOrFail($id);
        //edit akun

        $datas->update ([
            'email' =>$request->email,
            
        ]);

        //redirect to index
        return redirect()->route ('akun.index',$id)->with(['success' => 'email berhasil di ubah!']);
    }
    public function updatePassword( Request $request,$id) :RedirectResponse
     {
        //validate form
        $validate = $request->validate([
            'password' => 'require|min:8|confirmed'
            
        ]);

        //get post by id
        $datas = User::fidOrFail($id);
        //edit akun

        $datas->update ([
            'password' =>$request->password,
            
        ]);

        //redirect to index
        return redirect()->route ('akun.index',$id)->with(['success' => 'password berhasil di ubah!']);
    }
    public function edit($id)                                                                                                                                                                                                                                                               
    {
        $akun = User:: findOrFail($id);
        return view('admin.akun.edit',compact('akun'));
    }
     //hapus data
     public function destroy($id): RedirectResponse
     {
        //cari id siswa
        $siswa =DB::table('siswas')->where('id_user',$id)->value('id');

        //jika siswa
        if ($siswa){
            //delete siswa
            $this->destroySiswa($siswa);
        }
        //get post by id
        $post =User ::findOrFail($id);

        //delete post
        $post ->delete();

        //redirect to index
        return redirect ()->route('akun.index')->with(['success' => 'akun berhasil di ubah']);
        
     } 
     public function destroySiswa(string $id)
     {
        //get id siswa
        $post = Siswa ::findOrFail($id);

        //delete image
        Storage::delete('public/siswas/'.$post->image);

        //delete post
        $post->delete();
     }
}