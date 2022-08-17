<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Log;

class SalesController extends Controller
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
            $sales = Penjualan::with([
                'detail' => function($q) {
                    $q->select('penjualan_detail.*','b.nama')
                    ->join('barang as b', 'b.id', '=', 'penjualan_detail.barang_id');
                }
            ])->where('nama','like','%'.$search.'%')->paginate(10);
        }else{
            $sales = Penjualan::with([
                'detail' => function($q) {
                    $q->select('penjualan_detail.*','b.nama')
                    ->join('barang as b', 'b.id', '=', 'penjualan_detail.barang_id');
                }
            ])->paginate(10);
        }
        
        $titlebar = 'Sales List';
        $describebar = 'Transaction / Sales';

        // load the view and pass the sharks
        return view('sales.index',compact('sales','search','titlebar','describebar'));
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
            'barang' => Barang::get(),
            'action' => url('transaction/sales'),
            'titlebar' => 'Add Sales Transaction',
            'describebar' => 'Transaction / Sales',
        ];
        return view('sales.form',$data);
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
            'total'    => 'required',
            'bayar'         => 'required',
        ]);

        $data = $request->only(['total','bayar']);
        $data['selisih'] = $data['bayar'] - $data['total'];
        $data['user_id'] = Auth::user()->id;
        
        //Generate no_transaksi
        $no_transaksi      = 0;
        $cur_transaksi   = Penjualan::selectRaw('max(no_transaksi) as no_transaksi')->whereRaw("date(created_at) = '".date('Y-m-d')."'")->first();
        if($cur_transaksi){
            if($cur_transaksi->no_transaksi != ''){
                $no_transaksi = substr($cur_transaksi->no_transaksi,8,4);
                $no_transaksi++;
            }else{
                $no_transaksi = 1;
            }
        }else{
            $no_transaksi = 1;
        }
        $new_transaksi = 'P'.date('y').date('m').date('d').'_'.$this->formating_number($no_transaksi,4,'0');
        $data['no_transaksi'] = $new_transaksi;

        DB::beginTransaction();
        try{
            //Insert penjualan
            Penjualan::create($data);

            $product = $request->post('product');
            $jumlah = $request->post('jumlah');
            $harga_jual = $request->post('harga_jual');
            $dataProduct = [];
            foreach($product as $key => $pr){
                $dataProduct[] = [
                    'barang_id' => $pr,
                    'jumlah' => $jumlah[$key],
                    'harga_jual' => $harga_jual[$key],
                    'no_transaksi' => $new_transaksi,
                ];
            }
            
            //Insert penjualan detail product
            if(isset($dataProduct)){
                if(sizeof($dataProduct) > 0)
                    PenjualanDetail::insert($dataProduct);
            }

            DB::commit();

            return redirect('/transaction/sales')->with('success', 'Transaction added successfully');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/transaction/sales')->withErrors('error', 'Transaction added failed');
        }

    }
    
    function formating_number($value, $width, $prefix, $left = true){
        $set_value = (string)$value;
        $len_value = strlen((string)$value);
        $left_width = $width - $len_value;

        for($index = 1; $index <= $left_width; $index++){
            if($left){
                $set_value = $prefix.$set_value;
            }else{
                $set_value = $set_value.$prefix;
            }
        }
        return $set_value;
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
        $penjualan = Penjualan::with([
            'detail' => function($q) {
                $q->select('penjualan_detail.*','b.nama')
                ->join('barang as b', 'b.id', '=', 'penjualan_detail.barang_id');
            }
        ])->find($id);
        if($penjualan){
            
            $data = [ 
                'method' => 'PUT',
                'action' => url('transaction/sales/'.$id),
                'penjualan' => $penjualan,
                'titlebar' => 'Edit Sales Transaction',
                'describebar' => 'Transaction / Sales',
            ];
            return view('sales.form',$data);
        }else{
         
            return Redirect::to("transaction/sales")->withErrors(['error' => 'Transaction not found']);
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
        $penjualan = Penjualan::find($id);
        if($penjualan){
            $data = $request->only(['total','bayar']);
            $data['selisih'] = $data['bayar'] - $data['total'];

            DB::beginTransaction();
            try{

                Penjualan::where('id','=',$id)->update($data);
                
                $product = $request->post('product');
                $jumlah = $request->post('jumlah');
                $harga_jual = $request->post('harga_jual');
                $dataProduct = [];
                foreach($product as $key => $pr){
                    $dataProduct[] = [
                        'barang_id' => $pr,
                        'jumlah' => $jumlah[$key],
                        'harga_jual' => $harga_jual[$key],
                        'no_transaksi' => $penjualan->no_transaksi,
                    ];
                }
                //delete product sebelumnya
                PenjualanDetail::where('no_transaksi',$penjualan->no_transaksi)->delete();
                //Insert penjualan detail product
                if(isset($dataProduct)){
                    if(sizeof($dataProduct) > 0)
                        PenjualanDetail::insert($dataProduct);
                }

                DB::commit();

                return redirect('/transaction/sales')->with('success', 'Transaction updated successfully');
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong

                return redirect('/transaction/sales')->withErrors('error', 'Transaction updated failed');
            }
        }else{
            return redirect('/transaction/sales')->withErrors('error', 'Transaction not found');
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
        $penjualan = Penjualan::find($id);
        if($penjualan){
            PenjualandETAIL::where('no_transaksi','=',$penjualan->no_transaksi)->delete();
            Penjualan::where('id','=',$id)->delete();
            return redirect('/transaction/sales')->with('success', 'Transaction deleted successfully');
        }else{
            return redirect('/transaction/sales')->withErrors('error', 'Transaction not found');
        }
    }

    public function searchProduct($search){
        $search = strtolower($search);
        $product = Barang::where(DB::raw('lower(nama)'),'like','%'.$search.'%')
        ->orWhere(DB::raw('lower(kode)'),'like','%'.$search.'%')
        ->get();

        return response()->json(['data' => $product], 200);
    }
}
