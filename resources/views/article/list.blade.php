<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{asset('css/page.css')}}" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: left;
                padding:25px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
       <div class="content">
            <form action="">
            <table border="">
                <p>
                <input type="text" name="article_title" placeholder="请输入标题" >
                <input type="text" name="classify_name" placeholder="请输入分类">
                <button>搜索</button></p>
                <tr>
                    <td>编号</td>
                    <td>文章标题</td>
                    <td>文章分类</td>
                    <td>文章重要性</td>
                    <td>是否显示</td>
                    <td>添加时间</td>
                    <td>操作</td>
                </tr>
                @if($data)
                @foreach($data as $v)
                <tr article_id={{$v->article_id}}>
                    <td>{{$v->article_id}}</td>
                    <td>{{$v->article_title}}</td>
                    <td>{{$v->classify_name}}</td>
                    <td>{{$v->is_sign}}</td>
                    <td>{{$v->is_show}}</td> 
                    <td>{{$v->created_at}}</td> 

                    <td>
                    <a href="/article/edit/{{$v->article_id}}">修改</a>
                    <!-- <input type="button" value="修改" class="edit" > -->
                    <input type="button" value="删除" class="del">

                       <!--  <a href="edit/{{$v->article_id}}">修改</a>
                        <a href="del/{{$v->article_id}}">删除</a> -->
                    </td>
                </tr>
                @endforeach
                @endif
            </table>    
            </form>
       </div>
            {{ $data->appends($query)->links() }} 
       
    </body>
</html>
<script src="/js/jquery-3.2.1.min.js"></script>

<script>
$(function(){
   $(".del").click(function(){
     // alert(111);
    var article_id = $(this).parents('tr').attr('article_id');


         $.ajax({
           url:'/article/del',
           type:"get",  
           dataType:"json",  
           data:{"article_id":article_id},
           success:function(data){
            // console.log(data);

            // if (data.code==1) {
            //     alert(data.msg);
            //     location.href="/article/list";
            // };
                alert(data.msg);
                window.location.reload();
            
            }

        });
        return false;
    });
   
   
})

</script>