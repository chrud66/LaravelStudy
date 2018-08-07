
@extends('layouts.master')
@section('content')
@endsection

@section('script')
<script>
        $.ajax({
            type: "GET",
            url: "http://api.kcklaravel.com:8080/api/v1/articles",
            success: function(data) {
                console.log(data);
            },
            error: function(e1, e2, e3) {
                flash("danger", "{{ __('common.msg_whoops') }}", 2500);
                console.log(e1);
                console.log(e2);
                console.log(e3);
            }
        });
</script>

@endsection