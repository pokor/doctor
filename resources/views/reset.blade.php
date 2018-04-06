<form method="post"  action="{{route('reset')}}" >
    {{csrf_field()}}
    <input type="text" name="username">
    <input type="text" name="password">
    <button type="submit"> 提交 </button>
</form>