@if(Session::has('error') || $errors->any())

<script>

  let timerInterval;
Swal.fire({
  title: "{{Session::get('error')}} ",

  timer: 2500,
  timerProgressBar: true,
  icon: "error",
  didOpen: () => {
    Swal.showLoading();
    // const timer = Swal.getPopup().querySelector("b");
    timerInterval = setInterval(() => {
      // timer.textContent = `${Swal.getTimerLeft()}`;
    }, 100);
  },
  willClose: () => {
    clearInterval(timerInterval);
  }
}).then((result) => {

});
</script>

@endif
