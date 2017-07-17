@extends('cache.index')

@section('page_heading','Gestione aziende')

@section('action_button')
    @role('admin')
    <div class="push-right">
        <a class="btn btn-tanit btn-xs "   href="/societa/create"><i class="fa fa-plus-square "></i>Nuova Azienda</a>
    </div>
    @endrole
@stop

@section('body')

    <div class="row">
        <div class="col-sm-12">
            <input type="text" id="search" onkeyup="cercaItem()" placeholder="Cerca azienda..." class="form-control">
            <br>

            <table id="tabella" class="table table-striped">

                <thead>  <tr>
                    <th>Ragione Sociale</th>
                    <th align="center">Tot Dipendenti </th>
                </tr>
                </thead>
                <tbody>

                @foreach($societa as $single)

                    <tr>
                        <td>{{ Str::upper($single->ragione_sociale) }}</td>
                        <td align="center"><b>{{$single->user->count()}}</b></td>

                        <td>
                            @role(['admin' ,'superuser' , 'gestoremultiplo' ,'azienda'])
                            <a class="btn btn-tanit btn-xs "   href="/societa/{{$single->id}}/edit">modifica</a>
                            @endrole
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