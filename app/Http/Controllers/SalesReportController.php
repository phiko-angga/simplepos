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

class SalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : '';
        $date_start = $request->get('date_start') ? date('Y-m-d',strtotime($request->get('date_start'))) : '';
        $date_end = $request->get('date_end') ? date('Y-m-d',strtotime($request->get('date_end'))) : '';

        $sales = Penjualan::select('penjualan.*')
        ->selectRaw('(select sum(pd.jumlah*b.harga_beli) from penjualan_detail pd join barang b on b.id = pd.barang_id where pd.no_transaksi = penjualan.no_transaksi) as total_beli');
        
        if($search != ''){
            $sales = $sales->where('no_transaksi','like','%'.$search.'%');
        }
        
        if($date_start != '' && $date_end != ''){
            $sales = $sales->whereRaw("date(created_at) between '".$date_start."' and '".$date_end."'");
        }

        $sales = $sales->paginate(10);
        if($date_start != '' && $date_end != '' )
            $date_range = $request->get('date_start').' - '.$request->get('date_end');
        else
            $date_range = '';

        $titlebar = 'Sales Report';
        $describebar = 'Report / Sales';

        // load the view and pass the sharks
        return view('sales.report',compact('sales','search','titlebar','describebar','date_range'));
    }

}
