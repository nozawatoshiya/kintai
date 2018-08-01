@extends('layout.app')
@section('content')
<div class="container">
  <div class="font">
    <div class="card">
      <h1></h1>
      <form class="form-area" role="form" action="{{route('dakoku')}}" method="post">
        {{csrf_field()}}
        <p>
          <button type="submit" class="btn btn-primary btn-circle" style="width: 100px;" name="flag" value="出勤">出勤</button>
          <button type="submit" class="btn btn-primary btn-circle" style="width: 100px;" name="flag" value="退勤">退勤</button>
        </p>
        <p>
          <button type="submit" class="btn btn-primary btn-outline" style="width: 90px; padding:5px;" name="flag" value="直行">直行</button>
          <button type="submit" class="btn btn-info btn-outline" style="width: 90px; padding:5px;" name="flag" value="直帰">直帰</button>
          <button type="submit" class="btn btn-primary btn-outline" style="width: 90px; padding:5px;" name="flag" value="振替出勤">振替出勤</button>
          <button type="submit" class="btn btn-info btn-outline" style="width: 90px; padding:5px;" name="flag" value="電車遅延">電車遅延</button>
        </p>
      </form>
      <h5><b>@if(Session::has('date')){{session('date')}}@else{{'本日'}}@endif</b>の打刻</h5>
      <p>出勤：<b>@if(Session::has('sTime')){{session('sTime')}}@endif</b></p>
      <p>退勤：<b>@if(Session::has('fTime')){{session('fTime')}}@endif</b></p>
      <p>勤怠区分：@if(Session::has('kintaiCategoty')){{session('kintaiCategoty')}}@endif</p>
    </div>
    @if(Session::has('completeMessage'))
    <div class="alert alert-success alert-dismissible" id="alertfadeout">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      {{session('completeMessage')}}
    </div>
    @endif
    @if(Session::has('errorMessage'))
    <div class="alert alert-danger alert-dismissible" id="alertfadeout">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      {{session('errorMessage')}}
    </div>
    @endif
    @if(Session::has('warningMessage'))
    <div class="alert alert-warning alert-dismissible" id="alertfadeout">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      {{session('warningMessage')}}

      <form class="form-area" role="form" action="{{route('dakoku')}}" method="post">
        {{csrf_field()}}
        <p>
          <button type="submit" class="btn btn-danger btn-border" style="width: 90px; padding:5px;" name="flag" value="退勤反映">退勤反映</button>
        </p>
      </form>
    </div>

    @endif
  </div>
</div>
@endsection
