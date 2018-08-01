@extends('layout.app')
@section('content')
  <!--
      you can substitue the span of reauth email for a input with the email and
      include the remember me checkbox
      -->
      <div class="container">
              <div class="card card-container">
                  <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
                  <p id="profile" class="profile-name-card"></p>
                  <form class="form-area" role="form" action="{{route('login')}}" method="post">
                      {{csrf_field()}}
                      <div class="font">
                          <div class="form-group{{$errors->has('ID')?'has-error':''}}">
                              <label for="id">社員番号</label>
                              <input type="text" class="form-control" name="ID" value="">

                              @if(Session::has('Error'))
                                  <span class="help-box">
                                      <font color="red"><strong>{{Session('Error')}}</strong></font>
                                  </span>
                              @endif
                              @if($errors->has('ID'))
                                  <span class="help-box">
                                      <font color="red"><strong>{{$errors->first('ID')}}</strong></font>
                                  </span>
                              @else
                                  <br>
                                  @endif
                              @if($errors->has('session'))
                                  <span class="help-box">
                                      <font color="red"><strong>{{$errors->first('session')}}</strong></font>
                                  </span>
                              @endif
                          </div>
                          <div class="btnset">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="1" onclick="setChars('1')">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="2" onclick="setChars('2')">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="3" onclick="setChars('3')">
                          </div>
                          <div class="btnset">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="4" onclick="setChars('4')">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="5" onclick="setChars('5')">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="6" onclick="setChars('6')">
                          </div>
                          <div class="btnset">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="7" onclick="setChars('7')">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="8" onclick="setChars('8')">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="9" onclick="setChars('9')">
                          </div>
                          <div class="btnset">
                              <input type="reset" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="C" />
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="0" onclick="setChars('0')">
                              <input type="button" class="btn btn-default btn-lg" style="width: 60px; padding:5px;" value="BS" onclick="delChars()">
                          </div>
                          <div class="btnset">
                              <button type="submit" class="btn btn-primary btn-block" name="button">ログイン</button>
                          </div>
                      </div>
                  </form><!-- /form -->
              </div><!-- /card-container -->
      </div><!-- /container -->

      <script><!--
          function setChars(text){
              var myTextElement = document.getElementsByName("ID").item(0);
              myTextElement.value += text;
          }
//--></script>
     <script><!--
          function delChars(){
              var myTextElement = document.getElementsByName("ID").item(0);
              myTextElement.value = myTextElement.value.slice(0,-1);
          }
//--></script>
@endsection
