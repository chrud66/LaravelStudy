
<!doctype html>
<html lang="ko">
 <head>
     <meta charset="UTF-8">
     <title>Ok</title>
 </head>
 <body>
     <h1>할일 정보</h1>

     <p> 인 사 : {{ $greeting }}</p>
     <p> 할 일: {{ $name }}</p>
     <p> 기 한: {{ $due_date }}</p>
     <p> comment: {{ $comment }}</p>
     <p> comment: {!! $comment !!}</p>
     <br/><br/>
     <p> 인 사 : <?=$greeting //$task['greeting']; ?></p>
     <p> 할 일: <?=$name //$task['name'] ?></p>
     <p> 기 한:   <?=$due_date //$task['due_date'] ?></p>
     <p> comment: <?=$comment ?></p>
 </body>
</html>
