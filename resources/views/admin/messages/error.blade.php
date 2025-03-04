@if(Session::has('error'))
  <script>
$(document).ready(function onDocumentReady() {
  toastr.options = {
    "closeButton": true,
    "newestOnTop": true,
    "progressBar": true,
    "showDuration": "100",
    "preventDuplicates": false,
    "hideDuration": "2500",
    "timeOut": "2000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  toastr.error("{{Session::get('error')}}");
});
  </script>
@endif
