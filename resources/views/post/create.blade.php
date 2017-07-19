@extends('layout.main')

@section('content')
    <div class="col-sm-8 blog-main">
        <form  id="submitPost" action="/posts/store" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label>标题</label>
                <input name="title" type="text" class="form-control" placeholder="这里是标题" value="{{old('title')?:''}}">
            </div>
            <div class="form-group">
                <label>内容</label>
                {{--<textarea id="content" style="height:400px;max-height:500px;" name="content" class="form-control"--}}
                          {{--placeholder="这里是内容"></textarea>--}}
                <input type="hidden" name="content" value="" id="content_post">
                <input type="hidden" name="content_text" value="" id="content_post_text">
                <div id="wangeditor">

                </div>
            </div>

            @include('layout.errorhint')


            <button type="button" class="btn btn-default"  onclick="submitPost()">提交</button>
        </form>
        <br>

    </div><!-- /.blog-main -->


    <!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
    <script type="text/javascript" src="/js/wangEditor.min.js"></script>
    <script type="text/javascript">
//        $.ajaxSetup({
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            }
//        });
        var E = window.wangEditor;
        var editor = new E('#wangeditor');
        // 或者 var editor = new E( document.getElementById('#editor') )

        // 配置服务器端地址
        editor.customConfig.uploadImgServer = '/posts/upload/images';
        editor.customConfig.uploadImgParams = {
            'from': 'creat_editor'
        };
        editor.customConfig.uploadImgHeaders = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
        editor.create();
        {{--console.log(HTMLDecode("{{ old('content') }}"));--}}
        editor.txt.html(HTMLDecode("{{ old('content') }}"));
        {{--@if(old('content'))--}}
        {{--alert({{ old('content') }});--}}
       {{----}}
        {{--@endif--}}
        function submitPost(){
            document.getElementById("content_post").value=editor.txt.html();
            document.getElementById("content_post_text").value=editor.txt.text();
            document.getElementById("submitPost").submit();
        }


    </script>
@endsection
