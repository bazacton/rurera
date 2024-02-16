<style>
    .emoji-icons {display: flex; gap: 20px; flex-wrap: wrap; max-width: 610px; }
    .emoji-icons .emoji-icon {border-radius: 100%; display: inline-block; object-fit: contain; height: 43px; width: 43px; }
    .emoji-icons .emoji-icon img {max-width: 100%; }
</style>
@if( $users->count() > 0)
    @foreach( $users as $studentObj)
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

        <h3>{{$studentObj->full_name}}</h3>

        Username: {{$studentObj->username}}<br>
        Login Pin: {{$studentObj->login_pin}}<br>
        Emoji: <div class="emoji-icons"> {!! $emoji_response !!}</div><br>
        Website: https://rurera.com<br>
        <br>
        <br>
        <br>
    @endforeach
@endif