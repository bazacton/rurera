<style>
    /* Extra small devices (phones, less than 768px) */
    /* No media query since this is the default in Bootstrap */
    @media (max-width: 767px) {
        .flexible-progress-bar {
            width:100%;
            font-size: 21px;
        }
        .col-xs-12 .stepline {
           display: none;
        }
        .col-xs-9 .stepline {
            display: none;
        }
        .col-xs-8 .stepline {
            display: none;
  
        }
        .flexible-progress-bar li span.stepname {
            display: none;
        }
        .flexible-progress-bar li {
            padding: 0;
        }
    }
    
  
    /* Small devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .flexible-progress-bar {
            width:100%;
            font-size: 32px;
        }
        .col-xs-12 .stepline {
            left: -62%;
        }
        .col-xs-9 .stepline {
            left: -67%;
        }
        .col-xs-8 .stepline {
            left: -70%;
        }
        .col-xs-9 .flexible-progress-bar li span.stepname {
            font-size: 12px;
        }
        .col-xs-8 .flexible-progress-bar li span.stepname {
            font-size: 11px;
        }
    }
    
  
    /* Medium devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .flexible-progress-bar {
            width:100%;
            font-size: 2.5em;
        }
        .col-xs-12 .stepline {
            left: -60%;
        }
        .col-xs-9 .stepline {
            left: -63%;
        }
        .col-xs-8 .stepline {
            left: -64%;
        }
        .col-xs-9 .flexible-progress-bar li span.stepname {
            font-size: 13px;
        }
        .col-xs-8 .flexible-progress-bar li span.stepname {
            font-size: 13px;
        }
        .flexible-progress-bar li.active i {
            margin-left: 1px;
        }
    }
    
  
    /* Large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .flexible-progress-bar {
            width:100%;
            font-size: 2.5em;
        }
        .col-xs-12 .stepline {
            left: -58%;
        }
        .col-xs-9 .stepline {
            left: -60.6%;
        }
        .col-xs-8 .stepline {
            left: -62%;
        }
        .flexible-progress-bar li.active i {
            margin-left: 1px;
        }
    }
   
  
  
    #progbar {
        position: relative;
        width: 100%;
        text-align: center;
    }
    .flexible-progress-bar {
        display: inline-block;
        margin-left, margin-right: auto;
        padding: 0;
        white-space:nowrap;
        text-align:center;
    }
    .flexible-progress-bar li {
        list-style:none;
        display:inline-block;
        width: 20%;
        text-overflow:ellipsis;
        padding:.3em;
        color: #c7c7c7;
        font-weight:normal;
        line-height: .95em;
    }
    .flexible-progress-bar li i {
        position: relative;
        z-index: 10000;
    }
  
    .flexible-progress-bar li span.stepname {
        font-size: 13px;
        margin-bottom: -3px;
    }
    .flexible-progress-bar li.active span.stepname {
        font-weight: bold;
    }
  
  
    .stepline {
        height: 2px;
        overflow: visible;
        position: relative;
        bottom: .59em;
        display: block;
        z-index: 1;
        width: 101.5%;
        background: #c7c7c7;
  
    }
  
     /* this hides the first stepline, allowing the html for all steps to be identical */
    .flexible-progress-bar li:first-child .stepline {
        display: none;
    }
    
    /* these are the colors of the active steps icons, text, and stepline */
    .flexible-progress-bar li.active {
        color: #666666;
    }
    .flexible-progress-bar li.active .stepline {
        background: -moz-linear-gradient(left, #c7c7c7 13%, #004C1A 100%);
        /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right top, color-stop(13%, #c7c7c7), color-stop(100%, #666666));
        /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(left, #c7c7c7 13%, #666666 100%);
        /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(left, #c7c7c7 13%, #666666 100%);
        /* Opera 11.10+ */
        background: -ms-linear-gradient(left, #c7c7c7 13%, #666666 100%);
        /* IE10+ */
        background: linear-gradient(to right, #c7c7c7 13%, #666666 100%);
        /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#c7c7c7', endColorstr='#666666', GradientType=1);
        /* IE6-9 */
    }
    
    /* these are the colors of the completed steps icons, text, and stepline */
    .flexible-progress-bar li.complete {
        color: #c7c7c7;
    }
    .flexible-progress-bar li.complete .stepline {
        background: #c7c7c7;
    }
    
  
    /* this converts the icons from numbers to checkmark when they are complete */
    .flexible-progress-bar li.complete .icon-brankic-number11:before {
        content:"\e614";
    }
    .flexible-progress-bar li.complete .icon-brankic-number12:before {
        content:"\e614";
    }
    .flexible-progress-bar li.complete .icon-brankic-number13:before {
        content:"\e614";
    }
    .flexible-progress-bar li.complete .icon-brankic-number14:before {
        content:"\e614";
    }
    .flexible-progress-bar li.complete .icon-brankic-number15:before {
        content:"\e614";
    }
    
  .icon-brankic-number:before {
  	content: "\e600";
  }
  .icon-brankic-number2:before {
  	content: "\e601";
  }
  .icon-brankic-number3:before {
  	content: "\e602";
  }
  .icon-brankic-number4:before {
  	content: "\e603";
  }
  .icon-brankic-number5:before {
  	content: "\e604";
  }
  .icon-brankic-number6:before {
  	content: "\e605";
  }
  .icon-brankic-number7:before {
  	content: "\e606";
  }
  .icon-brankic-number8:before {
  	content: "\e607";
  }
  .icon-brankic-number9:before {
  	content: "\e608";
  }
  .icon-brankic-number10:before {
  	content: "\e609";
  }
  .icon-brankic-number11:before {
  	content: "\e60a";
  }
  .icon-brankic-number12:before {
  	content: "\e60b";
  }
  .icon-brankic-number13:before {
  	content: "\e60c";
  }
  .icon-brankic-number14:before {
  	content: "\e60d";
  }
  .icon-brankic-number15:before {
  	content: "\e60e";
  }
  .icon-brankic-number16:before {
  	content: "\e60f";
  }
  .icon-brankic-number17:before {
  	content: "\e610";
  }
  .icon-brankic-number18:before {
  	content: "\e611";
  }
  .icon-brankic-number19:before {
  	content: "\e612";
  }
  .icon-brankic-number20:before {
  	content: "\e613";
  }

</style>
  <div class="col-xs-12">
    <div id="progbar">

         <ul class="flexible-progress-bar">
          @php $liClass = ( $activeStep == 'packages' || $activeStep == 'payment' || $activeStep == 'finished')? 'complete' : ''; @endphp
          @php $liClass = ( $activeStep == 'student')? 'active' : $liClass; @endphp
          <li class="{{$liClass}}">
            <span class="stepname">Student Information</span><br>
            <i class="icon-box">
                <img src="/assets/default/svgs/student-reading.svg" alt="">
            </i>
            <div class="stepline"></div>
          </li>
           @php $liClass = ( $activeStep == 'payment' || $activeStep == 'finished')? 'complete' : ''; @endphp
           @php $liClass = ( $activeStep == 'packages')? 'active' : $liClass; @endphp
           <li class="{{$liClass}}">
            <span class="stepname">Choose Plan</span><br>
            <i class="icon-box">
                <img src="/assets/default/svgs/choose-plan.svg" alt="">
            </i>
            <div class="stepline"></div>
          </li>

         @php $liClass = ( $activeStep == 'finished')? 'complete' : ''; @endphp
         @php $liClass = ( $activeStep == 'payment')? 'active' : $liClass; @endphp
         <li class="{{$liClass}}">
            <span class="stepname">Payment Options</span><br>
            <i class="icon-box">
                <img src="/assets/default/svgs/payment-method.svg" alt="">
            </i>
            <div class="stepline"></div>
          </li>

         @php $liClass = ( $activeStep == 'finished')? 'complete' : ''; @endphp
         @php $liClass = ( $activeStep == 'finished')? 'active' : $liClass; @endphp
         <li class="{{$liClass}}">
            <span class="stepname">Finished</span><br>
            <i class="icon-box">
                <img src="/assets/default/svgs/finish.svg" alt="">
            </i>
            <div class="stepline"></div>
          </li>
        </ul>

    </div>
</div>