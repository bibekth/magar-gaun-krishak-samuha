<?php

namespace App\Http\Controllers;

use App\Traits\ImportExcelTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    use ImportExcelTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function excelImport(Request $request)
    {
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls,csv'
        ]);
        try{
            // DB::beginTransaction();
            $file = $request->file('excel');
            $filetype = $file->getClientOriginalExtension();
            $filename = 'excel.'.$filetype;
            $path = 'excel/imports/';
            $exist = Storage::disk('public')->exists($filename);
            if ($exist) {
                Storage::disk('public')->delete($filename);
            }
            $storage = Storage::disk('public')->putFileAs($path, $file,$filename);

            if (!$storage) {
                return response()->json('Failed to store the file');
            }
            $result = $this->getCollection($path, $filename);
            // DB::commit();
            return $result;
        }catch(Exception $e){
            // DB::rollBack();
            return 'failed';
        }

    }
}
