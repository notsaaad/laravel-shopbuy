@if(Session::has('success'))
<script>

  let timerInterval;
Swal.fire({
  title: " {{Session::get('success')}}",
  timer: 2500,
  timerProgressBar: true,
  icon: "success",
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
