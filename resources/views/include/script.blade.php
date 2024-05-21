 <!-- Core JS -->
 <!-- build:js assets/vendor/js/core.js -->

 <script src=" {{ asset('/public/assets/vendor/libs/jquery/jquery.js') }}"></script>
 <script src=" {{ asset('/public/assets/vendor/libs/popper/popper.js') }} "></script>
 <script src=" {{ asset('/public/assets/vendor/js/bootstrap.js') }}"></script>
 <script src=" {{ asset('/public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
 <!-- <script src=" {{ asset('/public/assets/vendor/js/menu.js') }}"></script> -->

 <!-- endbuild -->

 <!-- Vendors JS -->
 <script src=" {{ asset('/public/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

 <!-- Main JS -->
 <script src=" {{ asset('/public/assets/js/main.js') }}"></script>

 <!-- Page JS -->
 <script src=" {{ asset('/public/assets/js/dashboards-analytics.js') }}"></script>

 {{-- Select2 --}}
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <!-- Place this tag in your head or just before your close body tag. -->
 <script async defer src="https://buttons.github.io/buttons.js"></script>
 {{-- Google Map Key link --}}
 <script type="text/javascript"
     src="https://maps.google.com/maps/api/js?key=AIzaSyA2UzxBRympTMK_OyDW0gIz5p5ZHbXi_9c&libraries=places"></script>

 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

 <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
 {{-- <link rel="stylesheet" href="{{ asset('/public/assets/dataTable/dataTable.css') }}"> --}}
 {{-- <script src="{{ asset('/public/assets/dataTable/dataTable.js') }}"></script> --}}
 <script>
     $(document).ready(function() {
         $('#admin').DataTable();
        
     });
 </script>



 {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}

