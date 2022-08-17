<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Log;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : '';
        if($search != ''){
            $barang = Barang::where('nama','like','%'.$search.'%')->paginate(10);
        }else{
            $barang = Barang::paginate(10);
        }
        
        $titlebar = 'Product List';
        $describebar = 'Seting / Product';

        // load the view and pass the sharks
        return view('product.index',compact('barang','search','titlebar','describebar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [ 
            'method' => 'POST',
            'action' => url('seting/product'),
            'titlebar' => 'Add Product',
            'describebar' => 'Seting / Product',
        ];
        return view('product.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang = Barang::find($id);
        if($barang){
            
            $data = [ 
                'method' => 'PUT',
                'action' => url('seting/product/'.$id),
                'barang' => $barang,
                'titlebar' => 'Edit Product',
                'describebar' => 'Seting / Product',
            ];
            return view('product.form',$data);
        }else{
         
            return Redirect::to("seting/product")->withErrors(['error' => 'Product not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);
        if($barang){
            Barang::where('id','=',$id)->delete();
            return redirect('/seting/product')->with('success', 'Product deleted successfully');
        }else{
            return redirect('/seting/product')->withErrors('error', 'Product not found');
        }
    }

    public function generateBarcode(){
        
        $titlebar = 'Print Product Barcode';
        $describebar = 'Seting / Product Barcode';

        $product = Barang::select('kode','nama')->orderBy('kode','asc')->get();
        if($product){
            return view('product.barcode_list',compact('product','titlebar','describebar'));
        }
    }
}
