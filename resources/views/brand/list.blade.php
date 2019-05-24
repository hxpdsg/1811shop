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
            <h3>品牌展示</h3>
                <p><input type="text" name="brand_name" placeholder="请输入品牌名称" ><input type="text" name="brand_url" placeholder="请输入品牌网址"><button>搜索</button></p>
                <tr>
                    <td>品牌id</td>
                    <td>品牌名字</td>
                    <td>品牌描述</td>
                    <td>品牌地址</td>
                    <td>品牌logo</td>
                    <td>操作</td>
                </tr>
                @if($data)
                @foreach($data as $v)
                <tr>
                    <td>{{$v->brand_id}}</td>
                    <td>{{$v->brand_name}}</td>
                    <td>{{$v->brand_desc}}</td>
                    <td>{{$v->brand_url}}</td> 
                    <td>
                    <!-- <img src="http://www.image.com/{{$v->brand_logo}}" width="50px"> -->
                    <img src="{{config('app.img_url')}}{{$v->brand_logo}}" width="50px">

                    </td>
                    <!-- {{$v->brand_logo}} -->
                    <td>
                        <a href="edit/{{$v->brand_id}}">修改</a>
                        <a href="del/{{$v->brand_id}}">删除</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </table>    
            {{ $data->appends($query)->links() }} 
            </form>
       </div>
       
    </body>
</html>
