<?php

namespace App\Http\Controllers;

use App\MerchantLocation;
use Excel;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;

class HeatMapController extends Controller
{
    public function actions()
    {
        return view('manageBuckets.home');
    }

    public function uploadIndex()
    {
        // dd(DB::table('heat_maps')->get());
        return view('heatmap.uploadExcel');
    }
    public function indexBucket()
    {
        // dd(DB::table('heat_maps')->get());
        return view('heatmap.uploadBucketExcel');
    }

    public function uploadExcel(Request $request)
    {
        //validate the xls file
        $this->validate($request, array(
            'file' => 'required',
        ));

        if ($request->hasFile('file')) {
            // dd($request->hasFile('file'));
            $extension = File::extension($request->file->getClientOriginalName());
            // dd($extension);
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                // dd($extension == "xls");
                $path = $request->file->getRealPath();
                // dd($path); = "C:\xampp\tmp\phpE695.tmp"
                $data = Excel::load($path, function ($reader) {
                })->get();
                // dd($data);
                if (!empty($data) && $data->count()) {

                    foreach ($data as $key => $value) {
                        // dd($value->Bucket_Nmae);
                        $insert[] = [
                            'bucket_name' => $value->bucket_name,
                            'data_throughput' => $value->data_throughput,
                            'throughput_date' => $value->throughput_date,
                        ];
                    }

                    if (!empty($insert)) {

                        $insertData = DB::table('heat_maps')->insert($insert);
                        if ($insertData) {
                            Session::flash('success', 'Your Data has successfully imported');
                        } else {
                            Session::flash('error', 'Error inserting the data..');
                            return back();
                        }
                    }
                }

                return back();

            } else {
                Session::flash('error', 'File is a ' . $extension . ' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
    }

    public function uploadBucket(Request $request)
    {
        //validate the xls file
        $this->validate($request, array(
            'file' => 'required',
        ));

        if ($request->hasFile('file')) {
            // dd($request->hasFile('file'));
            $extension = File::extension($request->file->getClientOriginalName());
            // dd($extension);
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                // dd($extension == "xls");
                $path = $request->file->getRealPath();
                // dd($path); = "C:\xampp\tmp\phpE695.tmp"
                $data = Excel::load($path, function ($reader) {
                })->get();
                // dd($data);
                if (!empty($data) && $data->count()) {

                    foreach ($data as $key => $value) {
                        // dd($value->Bucket_Nmae);
                        $insert[] = [
                            'bucket_name' => $value->bucket_name,
                            'latitude' => $value->latitude,
                            'longitude' => $value->longitude,
                        ];
                    }

                    if (!empty($insert)) {

                        $insertData = DB::table('merchant_locations')->insert($insert);
                        if ($insertData) {
                            Session::flash('success', 'Your Data has successfully imported');
                        } else {
                            Session::flash('error', 'Error inserting the data..');
                            return view('welcome');
                        }
                    }
                }

                return view('welcome');

            } else {
                Session::flash('error', 'File is a ' . $extension . ' file.!! Please upload a valid xls/csv file..!!');
                return view('welcome');
            }
        }
    }

    // show heatmap
    public function index()
    {
        return view('mawingu.heatMap');
    }

    public function create()
    {
        // return view('mawingu.createBucket');
        return view('manageBuckets.createMerchantBucket');
    }

    // create bucket
    // public function store(Request $request)
    // {
    //     // validation
    //     $this->validate(request(), [
    //         'bucket_name' => 'required',
    //         'latitude' => 'required',
    //         'longitude' => 'required',

    //     ]);
    //     // save item to database
    //     $bucket = new MerchantLocation();
    //     $bucket->bucket_name = $request->input('bucket_name');
    //     $bucket->client_type = $request->input('client_type');
    //     $bucket->latitude = $request->input('latitude');
    //     $bucket->longitude = $request->input('longitude');
    //     $bucket->bs_name = $request->input('bs_name');
    //     $bucket->save();

    //     return view('welcome');
    // }

    public function displaySearch()
    {
        $search = Input::get("search");
        if ($search != "") {
            $buckets = MerchantLocation::where('bucket_name', 'LIKE', '%' . $search . '%')->get();

        }

        if (count($buckets) > 0) {
            return view('welcome')->withDetails($buckets)->withQuery($search);
        } else {
            return view('welcome')->withMessage('Your search for' . $search . 'was not found');
        }

    }

    public function displayForm()
    {
        return view("manageBuckets.searchBucket");
    }

    // public function readData(Request $request)
    // {
    //     //get data
    //     $sales = DB::table('heat_maps')->get();
    //     foreach($sales as $sale){
    //         $date = $sale->throughput_date;
    //         $d = date_parse_from_format("Y-m-d", $date);
    //     }
    //     // $heatmaps = DB::table('heat_maps')->select('latitude', 'longitude')->get();
    //     $heatmaps = DB::join('heat_maps', 'heat_maps.bucket_name', '=', 'merchant_locations.bucket_name')
    //     ->selectRaw('heat_maps.data_throughput', 'merchant_locations.latitude', 'merchant_locations.longitude')
    //     ->where($d["month"] == $request->month) && ($d["year"] == $request->year)
    //     ->get();
    //     // dd($heatmaps);
    //     // echo json_encode($heatmaps);
    //     return response($heatmaps);
    // }

    public function edit($id)
    {
        //
        $bucket = MerchantLocation::find($id);

        return view('manageBuckets.edit', compact('bucket'));
    }

    public function update(Request $request, $id)
    {
        //
        $this->validate(request(), [
            'bucket_name' => 'required',

        ]);
        //posting to database
        MerchantLocation::where('id', $id)->update(request(['bucket_name']));
        $this->validate(request(), [
            'bucket_name' => 'required',
            'district' => 'required',
            'bs_name' => 'required',
            'equipment' => 'required',
            'client_type' => 'required',
            'first_name' => 'required',
            'second_name' => 'required',
            'address' => 'required',
            'equipment1' => 'required',
            'ip_address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'bucket_name_ip' => 'required',

        ]);
        //posting to database

        MerchantLocation::where('id', $id)->update(request(['bucket_name', 'district', 'bs_name', 'equipment', 'client_type', 'first_name', 'second_name', 'address', 'equipment1', 'ip_address', 'latitude', 'longitude', 'bucket_name_ip']));

        return redirect('/search/Bucket');
    }

    public function destroy($id)
    {
        //
        MerchantLocation::where('id', $id)->update([
            'deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s'),
        ]);
        return redirect('/search/Bucket');
    }

    public function salesIndex()
    {
        return view('heatmap.salesReport');
    }

    public function salesReport(Request $request)
    {
        // dd($request);
        $sales = DB::table('heat_maps')->get();
        $totalSales = array();
        $totalTraffic = 0;
        foreach ($sales as $sale) {
            $date = $sale->throughput_date;
            $d = date_parse_from_format("Y-m-d", $date);
            if (($d["month"] == $request->month) && ($d["year"] == $request->year)) {
                array_push($totalSales, $sale->bucket_name);
                $totalTraffic += $sale->data_throughput;
                // dd($totalTraffic);
            } else {
                Session::flash("error", "Data for " . $request->year . "/" . $request->month . " is not available");
                // echo ("Data for ".$request->year ."/". $request->month." is not available");
            }
        }

        $allBuckets = sizeof($totalSales);
        //    echo ("Hello Modal");
        return view('welcome', compact('allBuckets', 'request', 'totalSales', 'totalTraffic'));
    }

    public function map()
    {
        if (Input::get('month') == null) {

            $coordinates = DB::table('merchant_locations')->get();
            // dd($coordinates);
            foreach ($coordinates as $coordinate) {
                // echo ('new.google.map.LatLng('.$coordinate->latitude.',' .$coordinate->longitude.')');
            }
            return view('heatmap.coordinates');
        } else {
            // dd(Input::get('month'));
            $coordinates = DB::table('merchant_locations')->join('heat_maps', 'merchant_locations.bucket_name', '=', 'heat_maps.bucket_name')->get();
            // $traffic = DB::table('heat_maps')->get();
            foreach ($coordinates as $sale) {;
                $date = $sale->throughput_date;
                $d = date_parse_from_format("Y-m-d", $date);
                if (($d["month"] == Input::get('month')) && ($d["year"] == Input::get('year'))) {
                    echo json_encode($coordinates);
                } else {
                    Session::flash('error', 'No data available here. Change the month or year');
                    return back();
                }
            }
        }
    }

    public function mapCoordinates($month = null, $year = null)
    {
        // dd($month);
        if ($month == "13") {
            $coordinates = DB::table('merchant_locations')
                ->join('heat_maps', 'merchant_locations.bucket_name', '=', 'heat_maps.bucket_name')
                ->whereIn(DB::raw('MONTH(heat_maps.throughput_date)'), [1, 2, 3])
                ->get();
        } elseif ($month == "14") {
            $coordinates = DB::table('merchant_locations')
                ->join('heat_maps', 'merchant_locations.bucket_name', '=', 'heat_maps.bucket_name')
                ->whereIn(DB::raw('MONTH(heat_maps.throughput_date)'), [4, 5, 6])
                ->get();
        } elseif ($month == "15") {
            $coordinates = DB::table('merchant_locations')
                ->join('heat_maps', 'merchant_locations.bucket_name', '=', 'heat_maps.bucket_name')
                ->whereIn(DB::raw('MONTH(heat_maps.throughput_date)'), [7, 8, 9])
                ->get();
        } elseif ($month == "16") {
            $coordinates = DB::table('merchant_locations')
                ->join('heat_maps', 'merchant_locations.bucket_name', '=', 'heat_maps.bucket_name')
                ->whereIn(DB::raw('MONTH(heat_maps.throughput_date)'), [10, 11, 12])
                ->get();
        } else {
            $coordinates = DB::table('merchant_locations')
                ->join('heat_maps', 'merchant_locations.bucket_name', '=', 'heat_maps.bucket_name')
                ->whereMonth('heat_maps.throughput_date', $month)
                ->get();
        }
        echo json_encode($coordinates);

    }
}
