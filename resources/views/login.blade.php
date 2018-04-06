<form method="post"  action="{{route('login')}}" >
    {{csrf_field()}}
    <input type="text" name="username">
    <input type="text" name="password">
    <button type="submit"> 提交 </button>
</form>