<label>Тема сообщения:</label> <span>{{$contact -> theme ? $contact -> tneme : 'none'}}</span><br>
<label>Имя:</label> <span>{{$contact -> name ? $contact -> name : 'none'}}</span><br>
<label>E-mail:</label> <span>{{$contact -> email}}</span><br>
<label>Тип пользователя:</label> <span>{{$contact -> type}}</span><br>
<label>Комментарий:</label>
<p>{{$contact -> text}}</p> <br>
