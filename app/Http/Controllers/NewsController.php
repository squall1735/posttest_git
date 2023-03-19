<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Categories;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rs_backend = News::select('*');

        $time_active = 999;
        $update_status = false;
        //$now_time = Carbon::now()->tz('Asia/Bangkok')->timestamp;   // unix time
        $now_time = Carbon::now()->tz('Asia/Bangkok')->format('Y-m-d H:i:s');

        foreach($rs_backend->get() as $val) {
            // เช็ควันปัจจุบัน อยู่ระหว่างช่วงเวลา ที่กำหนด

            $now_time_unix = strtotime($now_time);
            $s_date_unix = strtotime($val->start_date);
            $e_date_unix = strtotime($val->end_date);

            $carbonA = Carbon::createFromTimestamp($now_time_unix);
            $carbonB = Carbon::createFromTimestamp($s_date_unix);
            $carbonC = Carbon::createFromTimestamp($e_date_unix);

            if ($carbonA->between($carbonB, $carbonC)) {
            //if ($now_time_unix >= $s_date_unix && $now_time_unix <= $e_date_unix) {
                $time_active = 1;
            } else {
                $time_active = 0;
            }

            // เช็คข้อมูล แบบร่าง = 1 สถานะ = 0 และ ถึงช่วงเวลาที่กำหนด => สถานะ = 1 เพื่อ active การใช้งาน
            if($val->is_draft == 1 && $val->is_enabled == 0 && $time_active == 1) {
                $update_status = true;
            }
            // เช็คข้อมูล สถานะ = 1 และ เกินช่วงเวลาที่กำหนด => สถานะ = 0 เพื่อปิด inactive การใช้งาน
            if($val->is_enabled == 1 && $time_active == 0) {
                $update_status = true;
            }

            if($update_status) {
                $news_update = News::findOrFail($val->id);
                $news_update->is_enabled = $time_active;
                $news_update->save();
            }
        }

        if (!empty(@$_GET['keyword'])) {
            $rs_backend = $rs_backend ->where('header', 'like', '%'.$_GET['keyword'].'%')
            ->Orwhere('detail', 'like', '%'.$_GET['keyword'].'%');
        }
        if (!empty(@$_GET['keyword_2'])) {
            $rs_backend = $rs_backend->where('category_id', $_GET['keyword_2']);
        }
        if (!empty(@$_GET['keyword_3'])) {
            $rs_backend = $rs_backend->where('start_date','>' ,$_GET['keyword_3']);
        }
        if (!empty(@$_GET['keyword_4'])) {
            $rs_backend = $rs_backend->where('end_date','<' ,$_GET['keyword_4']);
        }
        if (!empty(@$_GET['keyword_5'])) {
            $rs_backend = $rs_backend->where('is_draft', $_GET['keyword_5']);
        }
        if (!empty(@$_GET['keyword_6'])) {
            $rs_backend = $rs_backend->where('is_enabled', $_GET['keyword_6']);
        }
        $rs_backend = $rs_backend->orderBy('category_id', 'asc')->orderBy('id', 'desc')->get();




        $cacheKey = 'news-' . md5(json_encode($_GET));
        //dd($cacheKey);
        $cacheDuration = 60; // cache duration in minutes
        $rs_frontend = Cache::remember($cacheKey, $cacheDuration, function () {
            //dd($request->keyword);
            $query = News::select('*');
            if (!empty(@$_GET['keyword'])) {
                $query = $query ->where('header', 'like', '%'.$_GET['keyword'].'%')
                ->Orwhere('detail', 'like', '%'.$_GET['keyword'].'%');
            }
            if (!empty(@$_GET['keyword_2'])) {
                $query = $query->where('category_id', $_GET['keyword_2']);
            }
            if (!empty(@$_GET['keyword_3'])) {
                $query = $query->where('start_date','>' ,$_GET['keyword_3']);
            }
            if (!empty(@$_GET['keyword_4'])) {
                $query = $query->where('end_date','<' ,$_GET['keyword_4']);
            }
            if (!empty(@$_GET['keyword_5'])) {
                $query = $query->where('is_draft', $_GET['keyword_5']);
            }
            if (!empty(@$_GET['keyword_6'])) {
                $query = $query->where('is_enabled', $_GET['keyword_6']);
            }

            $query = $query->orderBy('category_id', 'asc')->orderBy('id', 'desc')->get();

            return $query;
        });

        return view('news.form', compact('rs_backend', 'rs_frontend'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        $requestData = $request->all();
        $imageName = time().'.'.$request->preview_picture->extension();
        // Public Folder
        $request->preview_picture->move(public_path('images'), $imageName);

        $requestData['preview_picture'] = $imageName;
        News::create($requestData);

        set_notify('success', 'บันทีกข้อมูลสำเร็จ');


        return redirect('news');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //dd($id);
        $rs = News::findOrFail($id);
        return view('news.show', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //dd($id);
        $rs = News::findOrFail($id);
        return view('news.edit', compact('rs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($id);
        //dd($request->all());

        $requestData = $request->all();
        $requestData['is_draft'] = @$request->is_draft ? 1 : 0;
        $requestData['is_enabled'] = @$request->is_enabled ? 1 : 0;

        if(!empty(@$request->preview_picture)) {
            // ลบรูปเก่า
            if(File::exists(public_path('images/'.$request->preview_picture_tmp))){
                File::delete(public_path('images/'.$request->preview_picture_tmp));
            }

            // จัดเก็บรูปใหม่
            $imageName = time().'.'.$request->preview_picture->extension();
            $request->preview_picture->move(public_path('images'), $imageName);

            $requestData['preview_picture'] = $imageName;
        } else {
            $requestData['preview_picture'] = $request->preview_picture_tmp;
        }
        //dd($requestData);

        $rs = News::findOrFail($id);
        $rs->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        //return back();
        return redirect('news');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rs = News::findOrFail($id);
        if(File::exists(public_path('images/'.$rs->preview_picture))){
            File::delete(public_path('images/'.$rs->preview_picture));
        }
        News::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('news');
    }
}
