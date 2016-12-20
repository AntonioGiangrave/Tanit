WELCOME

@role('user')
    modifica
@endrole()

<br><br><br>


@foreach($users as $user)
    {{$user->nome}}    @can('user') [+] @endcan  <br>
@endforeach