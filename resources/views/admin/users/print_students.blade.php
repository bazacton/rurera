<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    @import url(https://fonts.googleapis.com/css?family=Merriweather+Sans:300,800);
    * {margin: 0;}
    body {font-family:  'Merriweather Sans', sans-serif; over}
    .profile-container {max-width: 1000px; margin: 0 auto; padding-top: 50px;}
    .student-profile-holder {width: 50%; display: inline-block; margin-right: -4px; padding: 0 8px 15px; box-sizing: border-box;}
    .profile-inner {border: 1px dashed #ddd; border-radius: 5px; padding: 20px;}
    .student-profile-holder h3 {font-size: 20px; color: #868686; text-transform: capitalize; margin: 0;}
    .student-info ul {margin: 0; padding: 0;}
    .student-info ul li {list-style: none; margin-bottom: 8px; display: flex; align-items: center; gap: 15px; color: #343434; font-weight: 600; font-size: 14px;}
    .student-info ul li:last-child {margin-bottom: 0;}
    .student-info ul li.user-name {color: #7750f9;}
    .student-info ul li.user-name span {color: #343434;}
    .student-info ul li > a {color: #343434; text-decoration: none;}
    .student-info ul li > span {min-width: 78px; max-width: 78px;}
    .emoji-icons {display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-start; }
    .emoji-icons .emoji-icon {border-radius: 100%; display: inline-block; object-fit: contain; height: 28px; width: 28px; }
    .emoji-icons .emoji-icon img {max-width: 100%; }
    .profile-header {display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; margin: 0 0 10px;}
    .student-qrCode {height: 35px;width: 35px;}
    .student-qrCode img {max-width: 100%;object-fit: contain;}
    @media print {
        body {
            font-family:  'Merriweather Sans', sans-serif;
        }
        .profile-container {
            padding-top: 0;
        }
        .profile-inner {
            padding: 15px;
        }
        .student-profile-holder h3 {
            font-size: 18px;
            color: #868686;
        }
        .emoji-icons .emoji-icon {
            height: 25px;
            width: 25px; 
        }
        .student-info ul li {
            margin-bottom: 6px;
            font-size: 14px;
        }
        .student-info ul li.user-name span {
            color: #343434;
        }
        @page {
            size: letter;
            margin: 50px 0 0;
        }
    }

    @media screen and (max-width: 767px) {
        .student-profile-holder {width: 100%; padding-bottom: 15px;}
    }
    .profile-container .row {
        page-break-before: always;
        margin: 0 0 50px;
    }
</style>
<div class="profile-container">
@php $userCount = 0; @endphp
<div class="row">
    @if( $users->count() > 0)
        @foreach( $users as $studentObj)
		@if( $userCount == 10)
			</div>
			<div class="row">
			@php $userCount = 0; @endphp
		@endif
		@php $userCount++; @endphp
            @php
            $emoji_response = '';
            $emojisArray = explode('icon', $studentObj->login_emoji);
                if( !empty( $emojisArray ) ){
                    foreach( $emojisArray as $emojiCode){
                        if( $emojiCode != ''){
                            $emoji_response .= '<a id="icon1" href="javascript:;" class="emoji-icon"><img src="/assets/default/svgs/emojis/icon'.$emojiCode.'.svg"></a>';
                        }
                    }
                }
            @endphp
            <div class="student-profile-holder">
                <div class="profile-inner">
                    <div class="profile-header">
                        <h3>{{$studentObj->get_full_name()}}</h3>
                        <a href="#" class="student-qrCode"><img src="/store/1/default_images/qr-code.png" alt=""></a>
                    </div>
                    <div class="student-info">
                        <ul>
                            <li class="user-name">
                                <span>Username:</span> {{$studentObj->username}}
                            </li>
                            <li>
                                <span>Login Pin:</span>
                                {{$studentObj->login_pin}}
                            </li>
                            <li>
                                <span>Emoji:</span>
                                <div class="emoji-icons"> {!! $emoji_response !!}</div>
                            </li>
                            <li>
                                <span>Website:</span>
                                <a href="https://rurera.com">https://rurera.com</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
        @endforeach
    @endif
</div>
</div>