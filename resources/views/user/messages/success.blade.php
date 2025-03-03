@if(Session::has('success'))

    <script>
      toastr['options'] = {
        "progressBar" : true,
      }
      toastr['success']("Test Work");
    </script>

@endif
