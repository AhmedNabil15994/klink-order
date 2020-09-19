<!--header-->
<header class="header rale">
    <!--start nav-->
    <nav class="dashnav">
        <!--dashNav Header-->
        <div class="dashnav__header">
            <!--logo-->
            <div class="logo">
                <a href="#">
                    <img src="{{asset('assets/images/logo3.png')}}" alt="logo">
                </a>
            </div>
            <!--logo-->
            <!--navButton-->
            <div class="navButton">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <!--navButton-->
        </div>
        <!--dashNav Header-->

        <!--main navigation-->
        <div class="topnav">
            <ul class="topnav__list">
                <!--language switcher-->
                <select class="selectpicker" data-width="fit" id="select_lang">
                    <option value="en" data-content='<img src="{{asset('assets/images/flags/en.png')}}"/>English'></option>
                    <option value="de" data-content='<img src="{{asset('assets/images/flags/de.png')}}"/>German' selected></option>
                </select>
                <!--language switcher-->

                <li class="listItem route">
                    <a href="#" class="list-link" style="position: relative;">
                        <span class="fas fa-tachometer-alt
                        "></span>
                       
                    </a>
                </li>    
              
                <!--notification-->
                <li class="listItem  notification">
                    <a href="#" class="list-link" style="position: relative;">
                        <span class="fas fa-bell
                        "></span>
                    </a>

                    <!--notification control-->
                    <ul class="dropDown notification-control">
                        <li class="dropDown__list">
                            <div class="notification-heading">
                                <h4>{{trans('frontend/dashboard.you_have')}} 0 {{trans('frontend/dashboard.new_noti')}}</h4>
                            </div>
                        </li>
                       
                        <!--notification container-->
                        <div class="notification-container">
                            <li class="dropDown__list">
                                <div class="notification-img">
                                    <span class="fas fa-bell
                                    " style="width: 50px;">
                                    </span>
                                </div>
                                <div class="notification-info">
                                    <p class="notification-name">{{trans('frontend/dashboard.answered')}}</p>
                                    <p class="notification-text" style="white-space: nowrap;"></p>
                                    <p class="notification-time"></p>
                                </div>
                            </li>
                        </div>
                        <!--notification container-->
                        <a href="#" class="seeall">{{trans('frontend/dashboard.see_all')}}</a>
                    </ul>
                    <!--notification control-->
                </li>
                <!--notification-->

                <!--message-->
                <li class="listItem message">
                    <a href="#" class="list-link">
                        <span class="fas fa-envelope
                        "></span>
                    </a>

                    <!--message control-->
                    <ul class="dropDown message-control">
                        <li class="dropDown__list">
                            <div class="message_number">
                                <h3>{{trans('frontend/dashboard.you_have')}} <span>3</span> {{trans('frontend/dashboard.new_msg')}}</h3>
                            </div>
                        </li>
                    </ul>
                    <!--message control-->

                </li>
                <!--message-->
                
                
                
            </ul>
        </div><!--mainNav-->
        <!--main navigation-->

    </nav><!--nav-->
    <!--end nav-->
</header><!--header-->
<!--header-->
