

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



function SetPublishALLCheckids(action, message){
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
        $('#row_id'+val +' .Status').removeClass('SDraft');
        $('#row_id'+val +' .Status').addClass('SPublish');
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
        toastr.success(`All ${message}  Set to Publish`);
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

$('.setPublishbtn-checks').on('click', function(){
  let action = $(this).attr('action');
  let message = $(this).attr('message');
  SetPublishALLCheckids(action, message);
})

function SetDraftALLCheckids(action, message){
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
        $('#row_id'+val +' .Status').removeClass('SPublish');
        $('#row_id'+val +' .Status').addClass('SDraft');
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
        toastr.success(`All ${message}  Set to Publish`);
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

$('.setDrafthbtn-checks').on('click', function(){
  let action = $(this).attr('action');
  let message = $(this).attr('message');
  SetDraftALLCheckids(action, message);
})

// ================================================ Start Handel File Uploading Image ================================

const fileInput = document.getElementById('fileInput');
if(fileInput){
  const preview      = document.getElementById('preview');
  const previewImage = document.getElementById('previewImage');
  const progressContainer = document.getElementById('progressContainer');
  const progress          = document.getElementById('progress');
  const fileName          = document.getElementById('fileName');

  fileInput.addEventListener('change', function () {
    if (fileInput.files.length > 0) {
      progressContainer.style.display = 'block';
      progress.style.width = '0%';

      let percent = 0;
      const interval = setInterval(() => {
        percent += 10;
        progress.style.width = percent + '%';

        if (percent >= 100) {
          clearInterval(interval);
          progressContainer.style.display = 'none';

          const file = fileInput.files[0];
          fileName.textContent = file.name;

          const reader = new FileReader();
          reader.onload = function(e) {
            previewImage.src = e.target.result;
          }
          reader.readAsDataURL(file);

          preview.style.display = 'flex';
        }
      }, 200);
    }
  });

  function removeFile() {
    fileInput.value = '';
    preview.style.display = 'none';
    progressContainer.style.display = 'none';
    progress.style.width = '0%';
    previewImage.src = '';
  }

}


// ================================================ End Handel File Uploading Image ================================


// ================================================ Start Gallary ============================================
const galleryInput = document.getElementById('galleryInput');

if (galleryInput) {
    const galleryPreview = document.getElementById('gallarypreview');
    let filesArray = [];

    galleryInput.addEventListener('change', function () {
        const newFiles = Array.from(galleryInput.files);

        newFiles.forEach(file => {
            filesArray.push(file);
            const reader = new FileReader();

            // إنشاء عناصر المعاينة
            const previewContainer = document.createElement('div');
            previewContainer.classList.add('previewContainer');

            const img = document.createElement('img');
            img.src = '';
            img.alt = file.name;

            const removeBtn = document.createElement('span');
            removeBtn.textContent = 'X';
            removeBtn.classList.add('GallaryRemoveImage');

            const progressBarContainer = document.createElement('div');
            progressBarContainer.classList.add('progressBarContainer');

            const progressBar = document.createElement('div');
            progressBar.classList.add('progressBar');
            progressBar.style.width = '0%';

            progressBarContainer.appendChild(progressBar);

            removeBtn.addEventListener('click', function () {
                // حذف الصورة من الملفات
                const index = filesArray.indexOf(file);
                if (index > -1) {
                    filesArray.splice(index, 1);
                }
                previewContainer.remove();
                updateFileInput();
            });

            reader.onloadstart = function () {
                progressBar.style.width = '0%';
            };

            reader.onprogress = function (event) {
                if (event.lengthComputable) {
                    const percent = (event.loaded / event.total) * 100;
                    progressBar.style.width = percent + '%';
                }
            };

            reader.onloadend = function (e) {
                img.src = e.target.result;
                progressBar.style.width = '100%';
                setTimeout(() => {
                    progressBarContainer.style.display = 'none';
                }, 500);
            };

            reader.readAsDataURL(file);

            previewContainer.appendChild(img);
            previewContainer.appendChild(removeBtn);
            previewContainer.appendChild(progressBarContainer);
            galleryPreview.appendChild(previewContainer);
        });

        updateFileInput(); // تحديث input بملفاتك الفعلية
    });

    function updateFileInput() {
        // تحويل array إلى FileList جديدة
        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => {
            dataTransfer.items.add(file);
        });
        galleryInput.files = dataTransfer.files;
    }
}


// ================================================ End Gallary ===============================================
