      <div class="navbar navbar-inverse" role="navigation">
        <div class="container">
          <div class="font">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">
                  Toggle navigation
                </span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="{{route('logout')}}"><font color="white">Ascend勤怠管理システム</font></a>
            </div>
            @if(Session::has('name'))
            <div class="collapse navbar-collapse" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <!--<li class="active"><a href="{{url('/mypage')}}">Home</a></li>-->
                <li><a href="{{route('mypage')}}">打刻</a></li>
                <li><a href="{{route('archives')}}">過去データ</a></li>
              </ul>
              <p class="navbar-text navbar-right"><a href="{{route('logout')}}" class="navbar-link">ログアウト</a></p>
              <p class="navbar-text navbar-right">ようこそ  <font color="white">{{session('name')}} </font> さん</p>
            </div>

            @endif
          </div>
          <!--/.nav-collapse -->
        </div>
      </div>
      <div class="container">
        <div class="font">
          <h2 id="Realdate">----/--/--(--) --:--:--</h2>
        </div>
      </div>
