@if (session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Pronto!', "{{ session('success') }}", 'success');
        })
    </script>
@endif

@if (session()->has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Erro!', "{{ session('error') }}", 'error');
        })
    </script>
@endif
@if ($errors->any())
    @php
        $mensagem = '';
        foreach ($errors->all() as $error) {
            $mensagem .= $error . '<br>';
        }
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Error!', "{!! $mensagem !!}", 'error');
        })
    </script>
@endif
