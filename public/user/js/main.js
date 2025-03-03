
$(document).ready(function(){ // Every Password input add icon to show password when clicked
  $('.password-with-icon input[type="password"]').after(`<span class="eye password_eye" > <i class="fa-solid fa-eye icon"></i></span>`);
});


    //Show Passowrd when Click on  Eye icon
    $(document).ready(function(){
      let passwords = $('.password_eye');
      passwords.each( function(i , ele) {
        $(ele).on('click', () =>{
          $(this).attr('type')
          let type =  $(this).siblings('input').attr('type');
          type == 'password' ? $(this).siblings('input').attr('type', 'text')             : $(this).siblings('input').attr('type', 'password');
          type == 'password' ? $(this).html(`<i class="fa-solid fa-eye-slash icon"></i>`) : $(this).html(`<i class="fa-solid fa-eye icon"></i>`);
        })
      } )
    });







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