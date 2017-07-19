@if($target_user->id != \Illuminate\Support\Facades\Auth::id())
    <div>
        @if(\Illuminate\Support\Facades\Auth::user()->hasStar($target_user->id))
            <button class="btn btn-default like-button" like-value="1" like-user="{{$target_user->id}}" type="button">
                取消关注
            </button>
        @else
            <button class="btn btn-default like-button" like-value="0" like-user="{{$target_user->id}}" type="button">关注
        @endif
    </div>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".like-button").click(function(event){
            var target=$(event.target);
            var like_value=target.attr('like-value');
            var user_id=target.attr('like-user');
            if (like_value ==1){
                //取消关注
                $.ajax(
                        {
                            url:'/user/unfan/'+user_id,
                            method:'POST',
                            dataType:'json',
                            success:function(data){
                                if (data.error!=0){
                                    alert(data.msg);
                                    return;
                                }

                                target.attr('like-value',0);
                                target.text('关注');
                            }
                        }
                );
            }else {
                //关注
                $.ajax(
                        {
                            url:'/user/fan/'+user_id,
                            method:'POST',
                            dataType:'json',
                            success:function(data){
                                if (data.error!=0){
                                    alert(data.msg);
                                    return;
                                }

                                target.attr('like-value',1);
                                target.text('取消关注');
                            }
                        }
                );
            }

        });
    </script>
@endif