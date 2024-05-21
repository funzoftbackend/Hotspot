<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            ©
            <script>
                document.write(new Date().getFullYear());
            </script>
            , made with ❤️ by
            <a href="https://funzoft.com" target="_blank" class="footer-link fw-medium">Funzoft Pvt. Ltd</a>
        </div>

    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>


@if (session('success'))
    <script>
        Swal.fire(
            'Good job!',
           {{ session()->get('success') }},
            'success'
        )
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: {{ session()->get('error') }},
        })
    </script>

@endif
