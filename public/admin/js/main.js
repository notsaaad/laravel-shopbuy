

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


    //Search table
function SearchTable(ele){
  SearchValue       = ele.value.toUpperCase()
  let TableRows     = document.querySelectorAll('tbody tr');

  for(let i=0; i<TableRows.length; i++){
    Tds = TableRows[i].querySelectorAll('td');
    let Found = false;
    Tds.forEach((value) => {
      let innerText = value.innerText.toUpperCase();
      if(innerText.indexOf(SearchValue) >= 0){
        Found = true;
      }
    })
    console.log(Found);

    if(Found){
      TableRows[i].style.display = "";
    }else{
      TableRows[i].style.display = "none";
    }

  }
}


//toggle submenu

$(document).ready(function(){
  let DropDowns = $('.Aside .DropDown');
  DropDowns.each(function(i,ele){
    $(ele).on('click', function(){
      $(ele).toggleClass('Active')
    })
  })
});



$('#check_all_ids').on('click', function(){
  $('table tbody input[type="checkbox"]').prop('checked', $(this).prop('checked'));
})

$('.clear-btn').on('click', function(){
  $('table input[type="checkbox"]').prop('checked', false);
});


$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

function DeleteALLCheckids(action, message){
  let all_ids = [];
  $('input:checkbox[name=row_id]:checked').each(function(){
    all_ids.push($(this).val());
  });

  $.ajax({
    type: "post",
    url: action,
    data: {
      ids: all_ids,
    },
    success: function (response) {
      $.each(all_ids, function(key, val){
        $('#row_id'+val).remove();
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
        toastr.success(`Delete ${message} ${val}`);
      });
    },
    error: function (response){
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
      toastr.error(`something went wrong`);
    }
  });

}

$('.Deletebtn-checks').on('click', function(){

  let action = $(this).attr('action');
  let message = $(this).attr('message');
  DeleteALLCheckids(action, message);
})
