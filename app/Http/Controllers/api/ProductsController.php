<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Log;

class ProductsController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : '';
        if($search != ''){
            $barang = Barang::where('nama','like','%'.$search.'%')->paginate(10);
        }else{
            $barang = Barang::paginate(10);
        }

        // load the view and pass the sharks
        return response()->json($barang,200);
    }

    public function store(Request $request)
    {
        request()->validate([
            'kode'   => 'required',
            'nama'   => 'required',
            'harga_beli'   => 'required',
            'harga_jual'   => 'required',
        ]);

        $data = $request->only(['kode','nama','deskripsi','harga_beli','harga_jual']);
        Barang::insert($data);
        return redirect('/seting/product')->with('success', 'Product added successfully');
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        if($barang){
            $data = $request->only(['kode','nama','deskripsi','harga_jual','harga_beli']);

            Barang::where('id','=',$id)->update($data);
            return redirect('/seting/product')->with('success', 'Product updated successfully');
        }else{
            return redirect('/seting/product')->withErrors('error', 'Product not found');
        }
    }

}
