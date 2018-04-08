@foreach($tasks as $task)
    <p>할 일 : {{ $task['name'] }}, 기 한 : {{ $task['due_date'] }}</p>
@endforeach

<br/><br/><br/>
@foreach($tasks2 as $task)
    <p>할 일 : {{ $task['name'] }}, 기 한 : {{ $task['due_date'] }}</p>
@endforeach

<br/><br/><br/>

@for($i =0; $i < count($tasks); $i++)
    <p>할 일 : {{ $tasks[$i]['name'] }}, 기 한 : {{ $tasks[$i]['due_date'] }}</p>
@endfor

<br/><br/><br/>

@for($i =0; $i < count($tasks2); $i++)
    <p>할 일 : {{ $tasks2[$i]['name'] }}, 기 한 : {{ $tasks2[$i]['due_date'] }}</p>
@endfor
