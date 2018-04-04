<!doctype html>
<html lang="ko">
 <head>
     <meta charset="UTF-8">
     <title>Ok</title>
 </head>
 <body>
    <?php if ($num > 5) : ?>
    <p> <?=$num ?>은 5보다 큽니다.</p>
    <?php else : ?>
    <p> <?=$num ?>은 5보다 작습니다.</p>
    <?php endif ?>
    <br/><br/><br/>

    @if ($num > 5)
    <p>{{$num}}은 5보다 큽니다</p>
    @elseif ($num == 5)
    <p>{{ $num }}는 5와 같습니다.</p>
    @else
    <p>{{$num }}은 5보다 작습니다.</p>
    @endif
    <br/><br/><br/>


 </body>
</html>
