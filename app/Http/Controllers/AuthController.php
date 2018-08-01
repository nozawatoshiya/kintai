<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;

use App\UsersMaster;
use App\Kintai;

/***********************************
*ユーザーテーブルに接続するコントローラー
***********************************/
class AuthController extends Controller
{
  public function check(AuthRequest $request){
    $id = $request['ID'];

    $result = UsersMaster::where('社員番号',$id)->get();

    if($result->isempty()){
      \Session::flash('Error','アカウントは存在しません。');
      return back()->withInput();
    }
    $delFlg = $result[0]->削除フラグ;

    if(!$result->isempty() and $delFlg!="削除"){
      $id = $result[0]->社員番号;
      $name = $result[0]->氏名;
      $department = $result[0]->配属部署;

      \Session::put('id',$id);
      \Session::put('name',$name);
      \Session::put('department',$department);

      return redirect()->route('mypage');

    }elseif(!$result->isempty() and $delFlg=="削除"){
      \Session::flash('Error','アカウントは削除されています。');
      return back()->withInput();
    }else{
      \Session::flash('Error','管理者に問い合わせしてください。');
      return back()->withInput();
    }
  }

  public function logout(){
    \Session::flush();
    return redirect('/');
  }
}
