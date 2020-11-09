@if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    {{Toastr::error($error) }}
                @endforeach                    
                @endif
                @if (session('status'))
                {{Toastr::success(session('status')) }}
                @endif