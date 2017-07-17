@extends('cache.index')

@section('page_heading','Elenco Mansioni')


@section('action_button')
    @role('admin')
    <div class="push-right">
        <a class="btn btn-tanit btn-xs "   href="/mansioni/create"><i class="fa fa-plus-square "></i>Nuova Mansione</a>
    </div>
    @endrole
@stop

@section('body')

    <div class="row">
        <div class="col-sm-12">

            <input type="text" id="search" onkeyup="cercaItem()" placeholder="Cerca mansione..." class="form-control">
            <br>
            <table id="tabella" class="table table-striped">

                <thead>  <tr>
                    <th>Nome</th>
                    <th>Numero corsi</th>
                    <th>Settore</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                @foreach($mansioni as $single)

                    <tr>
                        <td>{{ $single->nome}}</td>
                        <td>{{ $single->_corsi->count()}}</td>
                        <td>{{ $single->_settore['settore']}}</td>
                        <td>
                            <a class="btn btn-tanit btn-xs "   href="/mansioni/{{$single->id}}/edit">modifica</a>
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@stop


@section('script')

    <script type="text/javascript">

        function cercaItem() {
            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabella");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

@stop