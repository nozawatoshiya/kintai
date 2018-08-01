@extends('layout.app')
@section('content')
<div class="container">
  <div class="font">
    <div class="card">
      @if($message != "")
      <div class="alert alert-danger alert-dismissible" id="alertfadeout">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        {{$message}}
      </div>
      @endif
      <div class="form-group">
        <div class="input-group">
          <form class="" action="{{route('archivesupdate')}}" method="get">
            <button type="submit" class="btn btn-default" name="submit" value="back">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              {{date('Y年m月',strtotime($year.$month.'01 -1 month'))}}
            </button>
            <button type="submit" class="btn btn-default" name="submit" value="next">
              {{date('Y年m月',strtotime($year.$month.'01 +1 month'))}}
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

            </button>
            <input type="hidden" name="date" value="{{$year}}{{$month}}">
          </form>
        </div>
        <h3>{{$year}}年{{$month}}月の勤怠データ</h3>
        <div class="card-archiveslist_h">
          <table class="table table-responsive">
            <thead>
              <tr>
                <td width="80">出勤日</td>
                <td width="120">出勤</td>
                <td width="120">退勤</td>
                <td width="120">稼働時間</td>
                <td width="120">区分</td>
                <td width="120">メモ</td>
                <td></td>
              </tr>
            </thead>
          </table>
        </div>
        <div class="card-archiveslist_d">
          @if($message=="")
          <table class="table table-striped table-hover table-condensed table-responsive">
            <tbody>
              @php $i=0 @endphp
              @foreach($datas as $data)
              <tr>
                <td width="80">{{date('n/j',strtotime($data['出勤日']))}}</td>
                <td width="120">@if($data['出勤時間']!=""){{date('H:i',strtotime($data['出勤時間']))}}@endif</td>
                <td width="120">@if($data['退勤時間']!=""){{date('H:i',strtotime($data['退勤時間']))}}@endif</td>
                <td width="120">@if($data['退勤時間']!=""){{date('H:i',strtotime($data['稼働時間']))}}@endif</td>
                <td width="120">{{$data['勤怠区分']}}</td>
                <td width="120">{{$data['メモ']}}</td>
                <td>
                  <a href="#" data-toggle="modal" data-target="#archivesModal{{$i}}" >
                    <button type="button" class="btn btn-info btn-outline" name="button" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></button>
                  </a>
                <!-- モーダル・ダイアログ -->

                <div class="modal fade" id="archivesModal{{$i}}" tabindex="-1">
                  <div class="modal-dialog modal-main">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                        <h3 class="modal-title">{{date('Y/m/d',strtotime($data['出勤日']))}}</h3>
                      </div>
                      <div class="modal-body">
                        <form class="form-group" action="#" method="post">
                          {{csrf_field()}}
                          <p>メモ：</p>
                          <textarea class="form-control" name="memo"  rows="8" style="width:100%">
                            @if($data['メモ']!=""){{$data['メモ']}}@endif
                          </textarea>
                          <input type="hidden" name="date" value="{{date('Y/m/d',strtotime($data['出勤日']))}}">
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-default" name="submit" value="">
                          <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                            更新
                        </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @php $i++ @endphp
            @endforeach
          </tbody>
        </table>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
