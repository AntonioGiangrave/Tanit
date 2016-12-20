<button type="button"
        @if (isset($id)) id= "{{{$id}}}" @endif
        class="btn btn-{{{ isset($class) ? $class : 'default' }}}
         {{{ isset($rounded) ? 'btn-rounded' : ''}}} {{{ isset($bordered) ? 'btn-bordered' : ''}}}
         @if (isset($size)) btn-{{$size}} @endif  {{{ isset($disabled) ? 'disabled' : '' }}}">{{ $value }}</button>

