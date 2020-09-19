<!--cookies popup-->
    <div class="cookies">
        <div class="container rale">
            <div class="row">

                <div class="col-xs-12">
                    <div class="cookies-popup">
                        <p>
                            {{trans('frontend/main.cookie') }}<span class="accept-cookies">{{trans('frontend/main.accept')}}</span>
                        </p>
                    </div><!--cookies popup-->
                </div><!--col-->

            </div>
        </div><!--container-->
    </div>
    <!--cookies popup-->

    <header class="header rale">
        <nav class="navbar navbar-default">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="{{URL::to('/')}}">
                  <img src="{{asset('/assets/images/logo3.png')}}" class="img-responsive" alt="logo" draggable="false">
              </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li ><a href="{{URL::to('/login')}}" class="{{Active(URL::to('/login'))}}">{{trans('frontend/main.login')}}</a></li>
                <li ><a href="{{URL::to('/business_customer')}}" class="{{Active(URL::to('/business_customer'))}}">{{trans('backend/customer_business.title')}}</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
            

          </div><!-- /.container-fluid -->
        </nav>
    </header>