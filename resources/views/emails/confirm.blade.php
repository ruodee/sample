<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>确认注册链接</title>
  </head>
  <body>
    <h1>感谢您的注册，欢迎加入学习旅程</h1>
    <p>
请点击后面链接确认注册：
<a href="{{route('confirm_email',$user->activation_token)}}">
{{route('confirm_email',$user->activation_token)}}
</a>
    </p>
    <p>如果这不是你本人操作，请忽略此邮件。</p>
  </body>
</html>
