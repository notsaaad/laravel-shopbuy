@if(Session::has('error'))

<script>

  let timerInterval;
Swal.fire({
  title: "Test",

  timer: 2000,
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
