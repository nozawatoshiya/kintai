<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kintai;

/***********************************
*勤怠テーブルに接続するコントローラー
***********************************/
class KintaiController extends Controller
{
  public function index(){
    $id = session('id');
    $name = session('name');
    $department = session('department');

    //ログイン時に勤怠データをチェック
    $date = date('m/d/Y',strtotime('now'));
    $time = date('H:i:s',strtotime('now'));

    $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->first();
    if($result){
      $sTime = $result->出勤時間;
      $fTime = $result->退勤時間;
      $kintaiCategoty = $result->勤怠区分;
      //$sTime = date('H:i',strtotime($result->出勤時間));
      //$fTime = date('H:i',strtotime($result->退勤時間));

      if($sTime!="" or $fTime!=""){
        //当日の勤怠レコードあり、データあり
        $date = date('Y年m月d日',strtotime($date));
        \Session::put('date',$date);
        \Session::put('sTime',$sTime);
        \Session::put('fTime',$fTime);
        \Session::put('kintaiCategoty',$kintaiCategoty);

      }
      if($sTime=="" and $fTime=="" and strtotime($time)<strtotime('6:00:00')){
        //当日の勤怠レコードあり、データなし
        //ログインした時間が6：00前の場合は昨日のレコードを検索する。
        $date = date('m/d/Y',strtotime('yesterday'));

        $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->first();

        if($result){
          //昨日の勤怠レコードあり、データあり
          $sTime = $result->出勤時間;
          $fTime = $result->退勤時間;
          $kintaiCategoty = $result->勤怠区分;
          //$sTime = date('H:i',strtotime($result->出勤時間));
          //$fTime = date('H:i',strtotime($result->退勤時間));

          if($sTime!="" and $fTime==""){
            $date = date('Y年m月d日',strtotime($date));
            \Session::put('date',$date);
            \Session::put('sTime',$sTime);
            \Session::put('fTime',$fTime);
            \Session::put('kintaiCategoty',$kintaiCategoty);
          }
        }

      }
    }else{
      if( strtotime($time)<strtotime('6:00:00')){
        //当日の勤怠レコードなし
        //ログインした時間が6：00前の場合は昨日のレコードを検索する。
        $date = date('m/d/Y',strtotime('yesterday'));

        $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->first();

        if($result){
          //昨日の勤怠レコードあり、データあり
          $sTime = $result->出勤時間;
          $fTime = $result->退勤時間;
          $kintaiCategoty = $result->勤怠区分;

          if($sTime!="" and $fTime==""){
            $date = date('Y年m月d日',strtotime($date));
            \Session::put('date',$date);
            \Session::put('sTime',$sTime);
            \Session::put('fTime',$fTime);
            \Session::put('kintaiCategoty',$kintaiCategoty);
          }
        }

      }


    }

    return view('mypage');
  }

  public function store(Request $request){
    $flag = $request['flag'];
    $time = date('H:i:s',strtotime('now'));
    $date = date('m/d/Y',strtotime('now'));
    $id = session('id');

    $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->first();
    //打刻状況をフラグ化する
    if($result){
      $sTime = $result->出勤時間;
      $fTime = $result->退勤時間;
      $kintaiCategoty = $result->勤怠区分;
      //$sTime = date('H:i',strtotime($result->出勤時間));

      if($sTime=="" and $fTime==""){
        //当日の勤怠レコードあり、データなし
        $flagDakoku = '当日レコードありデータなし';
      }elseif($sTime!="" and $fTime==""){
        $flagDakoku = '当日レコードあり出勤のみあり';
      }elseif($sTime=="" and $fTime!=""){
        $flagDakoku = '当日レコードあり退勤のみあり';
      }elseif($sTime!="" and $fTime!=""){
        $flagDakoku = '当日レコードあり出勤退勤あり';
      }
      if($sTime=="" and $fTime=="" and strtotime($time)<strtotime('6:00:00')){
        //当日の勤怠レコードあり、データなし
        //ログインした時間が6：00前の場合は昨日のレコードを検索する。
        $date = date('m/d/Y',strtotime('yesterday'));

        $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->first();

        if($result){
          //昨日の勤怠レコードあり、データあり
          $sTime = $result->出勤時間;
          $fTime = $result->退勤時間;
          $kintaiCategoty = $result->勤怠区分;
          //$sTime = date('H:i',strtotime($result->出勤時間));
          //$fTime = date('H:i',strtotime($result->退勤時間));

          if($sTime!="" and $fTime==""){
            $flagDakoku = '昨日レコードあり出勤のみあり';
          }
        }

      }
    }else{
      if( strtotime($time)<strtotime('6:00:00')){
        //当日の勤怠レコードなし
        //ログインした時間が6：00前の場合は昨日のレコードを検索する。
        $date = date('m/d/Y',strtotime('yesterday'));

        $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->first();

        if($result){
          //昨日の勤怠レコードあり、データあり
          $sTime = $result->出勤時間;
          $fTime = $result->退勤時間;
          $kintaiCategoty = $result->勤怠区分;

          if($sTime!="" and $fTime==""){
            $flagDakoku = '昨日レコードあり出勤のみあり';
          }
        }

      }
      $flagDakoku = '当日レコードなし';
    }

    if($flag=="出勤"){
      if($flagDakoku == '当日レコードありデータなし' ){
        $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['出勤時間' => $time]);
        \Session::flash('completeMessage', date("H:i",strtotime($time)).' で出勤打刻しました。');

      }elseif($flagDakoku == '当日レコードなし' ){
        $result = Kintai::create(["出勤日"=>$date,
                                  "社員番号"=>$id,
                                  "出勤時間"=>$time,
                                ]);
        \Session::flash('completeMessage', date("H:i",strtotime($time)).' で出勤打刻しました。');
      }elseif($flagDakoku == '当日レコードあり退勤のみあり' ){
        \Session::flash('errorMessage', '退勤打刻されているため、打刻できません。');

      }else{
        \Session::flash('errorMessage', 'すでに打刻されています。');
      }
    }elseif($flag=="退勤"){
      if($flagDakoku == '当日レコードあり出勤のみあり' ){
        $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['退勤時間' => $time]);
        \Session::flash('completeMessage', date("H:i",strtotime($time)).' で退勤打刻しました。');
      }elseif($flagDakoku == '昨日レコードあり出勤のみあり'){
        $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['退勤時間' => $time]);
        \Session::flash('completeMessage', date("H:i",strtotime($time)).' で退勤打刻しました。');
      }elseif($flagDakoku == '当日レコードあり退勤のみあり' or $flagDakoku == '当日レコードあり出勤退勤あり'){
        \Session::flash('errorMessage', 'すでに打刻されています。');
      }else{
        \Session::flash('warningMessage', '出勤打刻がされていません。このまま退勤打刻しますか？');
      }
    }elseif($flag=="直行"){
      //dd($flagDakoku);
      if(strpos($kintaiCategoty,$flag) !== false){
        //勤怠区分のなかに$flagが含まれている場合
        \Session::flash('errorMessage', date('Y年m月d日',strtotime($date)).'の勤怠に'.$flag.'はすでに反映されています。');

      }else{
        if($flagDakoku == '当日レコードなし'){
          $result = Kintai::create(["出勤日"=>$date,
                                    "社員番号"=>$id,
                                    "勤怠区分"=>$flag,
        ]);
      }else{
        if($kintaiCategoty!=""){
          $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['勤怠区分' => $kintaiCategoty."\n".$flag]);
        }else{
          $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['勤怠区分' => $flag]);
        }
      }
      \Session::flash('completeMessage', date('Y年m月d日',strtotime($date)).'の勤怠に'.$flag.'を反映しました');

      }

    }elseif($flag=="直帰"){
      if(strpos($kintaiCategoty,$flag) !== false){
        //勤怠区分のなかに$flagが含まれている場合
        \Session::flash('errorMessage', date('Y年m月d日',strtotime($date)).'の勤怠に'.$flag.'はすでに反映されています。');

      }else{
        if($flagDakoku == '当日レコードなし'){
          $result = Kintai::create(["出勤日"=>$date,
                                    "社員番号"=>$id,
                                    "勤怠区分"=>$flag,
                                  ]);
      }else{
        if($kintaiCategoty!=""){
          $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['勤怠区分' => $kintaiCategoty."\n".$flag]);
        }else{
          $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['勤怠区分' => $flag]);
        }
      }
      \Session::flash('completeMessage', date('Y年m月d日',strtotime($date)).'の勤怠に'.$flag.'を反映しました');

    }

    }elseif($flag=="振替出勤"){
      if(strpos($kintaiCategoty,$flag) !== false){
        //勤怠区分のなかに$flagが含まれている場合
        \Session::flash('errorMessage', date('Y年m月d日',strtotime($date)).'の勤怠に'.$flag.'はすでに反映されています。');

      }else{
        if($flagDakoku == '当日レコードなし'){
          $result = Kintai::create(["出勤日"=>$date,
                                    "社員番号"=>$id,
                                    "勤怠区分"=>$flag,
                                  ]);
        }else{
          if($kintaiCategoty!=""){
            $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['勤怠区分' => $kintaiCategoty."\n".$flag]);
          }else{
            $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['勤怠区分' => $flag]);
          }
        }
        \Session::flash('completeMessage', date('Y年m月d日',strtotime($date)).'の勤怠に'.$flag.'を反映しました');
      }

    }elseif($flag=="電車遅延"){
      if(strpos($kintaiCategoty,$flag) !== false){
        //勤怠区分のなかに$flagが含まれている場合
        \Session::flash('errorMessage', date('Y年m月d日',strtotime($date)).'の勤怠に'.$flag.'はすでに反映されています。');

      }else{
        if($flagDakoku == '当日レコードなし'){
          $result = Kintai::create(["出勤日"=>$date,
                                    "社員番号"=>$id,
                                    "勤怠区分"=>$flag,
                                  ]);
        }else{
          if($kintaiCategoty!=""){
            $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['勤怠区分' => $kintaiCategoty."\n".$flag]);
          }else{
            $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['勤怠区分' => $flag]);
          }
        }
        \Session::flash('completeMessage', date('Y年m月d日',strtotime($date)).'の勤怠に'.$flag.'を反映しました');

      }

    }elseif($flag=="退勤反映"){
      if($flagDakoku == '当日レコードありデータなし' ){
        $result = Kintai::where('出勤日',$date)->where('社員番号',$id)->update(['退勤時間' => $time]);
        \Session::flash('completeMessage', date("H:i",strtotime($time)).' で退勤打刻しました。');

      }elseif($flagDakoku == '当日レコードなし' ){
        $result = Kintai::create(["出勤日"=>$date,
                                  "社員番号"=>$id,
                                  "退勤時間"=>$time,
                                ]);
        \Session::flash('completeMessage', date("H:i",strtotime($time)).' で退勤打刻しました。');

      }

    }
    return redirect()->route('mypage');

  }
  public function archives(){
    $date=date('Ym');
    return redirect()->route('archiveslist',['ym'=>$date]);

  }

  public function archivesUpdate(Request $request){
    $input=$request->input();
    $category=$input['submit'];
    $date=date('Y/m/d',strtotime($input['date'].'01'));

    if($category=='back'){
      $date=date('Ym', strtotime("$date -1 month"));

    }else{
      $date=date("Ym", strtotime("$date +1 month"));
    }
    return redirect()->route('archiveslist',['ym'=>$date]);
  }

  public function getArchivesList($ym){
    $date=date('m/*/Y',strtotime($ym.'01'));
    $id = session('id');

    $datas=Kintai::where('社員番号',$id)->where('出勤日',$date)->orderBy('出勤日','asc')->get();
    //$datas=Kintai::where('社員番号',$id)->where('出勤日',$date)->get();
    //dd($datas);

    $date=date('m/d/Y',strtotime($ym.'01'));
    $year = date('Y',strtotime($date));
    $month = date('m',strtotime($date));

    if(!$datas->isempty()){
      $message = "";

//      return view('archives.archives',compact('datas','date','message'));
      return view('archives',compact('datas','year','month','message'));
    }else{
      //\Session::flash('message', date('Y年m月',strtotime($date)).' のデータは存在しません。');
      $message = date('Y年m月',strtotime($date)).' のデータは存在しません。';
      return view('archives',compact('datas','year','month','message'));
//      return view('archives.archives',compact('date','message'));
    }
  }
}
