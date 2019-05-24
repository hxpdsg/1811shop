<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

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
       <h3>文章</h3>
           <form action="add_do" method="post" enctype="multipart/form-data">
               @if ($errors->any())    
                <div class="alert alert-danger">         
                <ul>             
                @foreach ($errors->all() as $error)                 
                <li>{{ $error }}</li>             
                @endforeach         
                </ul>     
                </div> 
                @endif
           {{csrf_field()}}
           <p>文章标题:<input type="text" name="article_title"></p>
           <p>文章分类:
             <select name="classify_id" >
             @if($res)
             @foreach ($res as $k=>$v)
                <option value="{{$v->classify_id}}">{{$v->classify_name}}</option>
            @endforeach         
            @endif
            </select>
            </p>
           <p>文章重要性:
           <input type="radio" name="is_sign" value="普通" checked>普通
           <input type="radio" name="is_sign" value="置顶">置顶
           </p>
           <p>是否显示:
           <input type="radio" name="is_show" value="显示" checked>显示
           <input type="radio" name="is_show" value="不显示">不显示
           </p>
           <p>文章作者:<input type="text" name="article_name"></p>
           <p>作者email:<input type="text" name="article_email"></p>
           <p>关键字:<input type="text" name="article_keyword"></p>
           <p>描述: <textarea name="article_desc" cols="20" rows="3"></textarea> 
           <p>上传文件:<input type="file" name="article_img"></p>

                <input type="button" value="添加" class="btn">
       </form>
       </div>
       
    </body>
<script src="/js/jquery-3.2.1.min.js"></script>
<script>
  $(function(){
    $('input[name=article_title]').blur(function(){
      var article_title = $(this).val();
      var reg = /^[\u4e00-\u9fa5\w]{3,30}$/;
      if(article_title==''){
        alert('标题不能为空');
      }else if(!reg.test(article_title)) {
        alert('由数字字母下划线组成3-30位');
      }else{
              $.ajax({
               url:'/article/checkname',
               type:"get",  
               dataType:"json",  
               data:{"article_title":article_title},
               success:function(data){
                // console.log(data);

                if (data.code==1) {
                    alert(data.msg);
                };
                
                }

            });
      }
    })

    $('.btn').click(function(){
      var _this = $('input[name=article_title]')
      var article_title = _this.val();
      var reg = /^[\u4e00-\u9fa5\w]{3,30}$/;
      if(article_title==''){
        alert('标题不能为空');
      }else if(!reg.test(article_title)) {
        alert('由数字字母下划线组成3-30位');
      }else{
              $.ajax({
               url:'/article/checkname',
               type:"get",  
               dataType:"json",  
               data:{"article_title":article_title},
               success:function(data){
                // console.log(data);

                if (data.code==1) {
                    alert(data.msg);
                };
                
                }

            });
      }
    })
  })
</script>
</html>
