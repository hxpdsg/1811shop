<!doctype html>
<html lang="{{ app()->getLocale() }}">
<script src="/js/jquery-3.2.1.min.js"></script>
<!-- <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script> -->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        
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
       <h3>学生信息管理添加</h3>
           <form>
            @if ($errors->any())    
                <div class="alert alert-danger">         
                <ul>             
                @foreach ($errors->all() as $error)                 
                <li>{{ $error }}</li>             
                @endforeach         
                </ul>     
                </div> 
                @endif
           <p>姓名:<input type="text" name="student_name" id="student_name"></p>
           <p>年龄:<input type="text" name="student_age" id="student_age"></p>
           <p>年龄:<input type="text" name="student_tel" id="student_tel"></p>
            <input type="submit" value="提交" id="tian">
       </form>
       </div>
       
    </body>
</html>
<script>
     $(function(){
    // #在要发起post请的ajax前加上这几行代码
   
   $("#tian").click(function(){

         $.ajaxSetup({
     headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
}); 
         var student_name=$('#student_name').val();
        console.log(student_name);
    // console.log($('#student_name').val());
    $.ajax({
           url:'/student/add_do',
           type:"get",  
           dataType:"json",  
           data:{"student_name":$('#student_name').val(),"student_age":$('#student_age').val(),"student_tel":$('#student_tel').val()},
           success:function(data){
            // console.log(data);
            if (data.code==1) {
            alert('添加成功');

            };
            }
        });
   
   return false;
   });
 })

</script>