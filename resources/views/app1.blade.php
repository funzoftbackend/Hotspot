<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('title')
    @include('include.style')
    @yield('css')
    <style>
        @media (min-width:1200px){
        .bg-footer-theme{
            margin-top: auto;
            margin-left: 5%;
        }
        .table-responsive{
            overflow-x:auto;
        }
    }
    </style>
    
    
</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            
          

            <div class="layout-page">
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                            <div class="app-brand demo">
                                <a href="{{ route('dashboard') }}" class="app-brand-link">
                                    <span class="app-brand-logo demo">
                                    </span>
                                    <img src="{{ asset('/public/Vector.png') }}" alt="" width="200">
                                </a>
                        
                                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                                </a>
                            </div>
                        @yield('content')
                    </div>
                    
                </div>
                <!-- Content wrapper -->
                
            </div>
            <!-- / Layout page -->
           
        </div>
      
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    @include('include.script')

    @if (session('success'))
        <script>
            Swal.fire(
                'Good job!',
                '{{ session()->get('success') }}',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session()->get('error') }}',
            })
        </script>
        
    @endif
    @stack('js')
  
</body>

</html>
