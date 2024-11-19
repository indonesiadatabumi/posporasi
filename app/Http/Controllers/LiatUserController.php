<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  

class LiatUserController extends Controller
{
    public function index()
    {
        return view('liatuser.index');
    }

    public function data(Request $request)
    {
        $users = User::with('restoran')
            ->where('role', '!=', 'admin') 
            ->select('users.id', 'users.nama', 'users.email', 'users.role', 'users.nomor_identitas', 'users.id_resto');
        
        if ($request->has('order') && $request->input('order.0.column') == 5) {
            $users->join('restoran', 'restoran.id', '=', 'users.id_resto')
                  ->orderBy('restoran.nama_resto', $request->input('order.0.dir'));
        }
        
        return DataTables::of($users)
            ->addIndexColumn()  
            ->editColumn('role', function ($user) {
                return ucfirst($user->role);  
            })
            ->editColumn('restoran.nama_resto', function ($user) {
                return $user->restoran ? $user->restoran->nama_resto : '-';  
            })
            ->make(true);
    }
    
    
}
