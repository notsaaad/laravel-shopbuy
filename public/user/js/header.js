
const menuButton = document.getElementById('menuButton');
const sidebar = document.getElementById('sidebar');

menuButton.addEventListener('click', () => {
  $(document).ready(function () {
    $('.aside-overlay').show();
  });
  sidebar.classList.toggle('active'); // Toggle the 'active' class to show or hide the sidebar
});
  //HandelAside
$(document).ready(function () {
  $('.aside-overlay .close').on('click', function(){
    $('.aside-overlay').hide();
    $('.sidebar').removeClass('active');
  })
  //Handel Aside DropDown menu
  $(document).ready(function () {
    $('#sidebar .DropDown > .menu-item').on('click', function(){
        $(this).parent().toggleClass('active');
    })
  });
});