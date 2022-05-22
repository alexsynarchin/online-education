@extends('site.base.base')
@section('content')

    <form method="post" action="/test/sms" target="ifr">

    <table>
        <tr><td>Номер телефона<td><input name="phone">
        <tr><td><br/>

        <tr><td>Код подтверждения<td><input name="code" size="6">&nbsp;
                <input type="submit" name="sendsms" value="Выслать код">
        <tr><td><br/>

        <tr><td><input type="submit" name="ok" value="Подтвердить"><td colspan="2" id="_out">
    </table>

    </form>
    <iframe name="ifr" frameborder="0" height="0" width="0" style="visibility:hidden"></iframe>
@endsection
