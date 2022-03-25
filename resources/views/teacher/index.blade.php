<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax Crud </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{--  <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">  --}}

    {{--  <link rel="stylesheet" href="{{ asset('css')}}/app.css">
    <script src="{{ asset('js/jquery.min.js')}}" type="text/javascript"></script>  --}}

</head>
<body>

    <div style="paddding: 30px;"></div>
    <div class="container">

        <h2 style="color: red;">
            <marquee behavior="" direction=""> Laravel ajax crud</marquee>
        </h2>

        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        All Teacher List
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--  <tr>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary mr-2">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>

                                </tr>  --}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <span id="Add">Add New Teacher </span>
                        <span id="Update"> Update Teacher </span>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputname">Name:</label>
                            <input type="text" class="form-control"id="name" aria-describedby="nameHelp" placeholder="Enter name">
                            <span class="text-danger" id="nameError"></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputTitle">Title:</label>
                            <input type="text" class="form-control"id="title" aria-describedby="nameHelp" placeholder="job position">
                            <span class="text-danger" id="titleError"></span>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputTitle">Phone No:</label>
                            <input type="text" class="form-control"id="phone" aria-describedby="nameHelp" placeholder="phone no">
                            <span class="text-danger" id="phoneError"></span>

                        </div>

                        <input type="hidden" id="id">

                        <button type="submit" id="addbutton" onclick="addData()" class="btn btn-primary">Add</button>
                        <button type="submit" id="updatebutton" onclick="updateData()" class="btn btn-primary">update</button>



                    </div>

                </div>
            </div>
        </div>

    </div>

<script>
    $('#Add').show();
    $('#addbutton').show();
    $('#Update').hide();
    $('#updatebutton').hide();

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }

    })

    {{--start all data show in table --}}

    function allData(){
        $.ajax({
            type: "GET",
            dataType:'json',
            url:"/teacher/all",
            success:function(response){
                var data = ""
               $.each(response, function(key,value){
                data = data + "<tr>"
                data = data + "<td>"+value.id+"</td>"
                data = data + "<td>"+value.name+"</td>"
                data = data + "<td>"+value.title+"</td>"
                data = data + "<td>"+value.phone+"</td>"
                data = data + "<td>"
                data = data + "<button class='btn btn-sm btn-primary mr-2' onclick='editData("+value.id+")'>Edit</button>"
                data = data + "<button class='btn btn-sm btn-danger' onclick='deleteData("+value.id+")'>Delete</button>"
                data = data + "</td>"
                data = data + "</tr>"

               })
               $('tbody').html(data);
            }
        })
    }
    allData();
    {{--end all data show in table --}}


{{-- start clear data from inputs  --}}
    function clearData(){

        $('#name').val('');
        $('#title').val('');
        $('#phone').val('');
        $('#nameError').text('');
        $('#titleError').text('');
        $('#phoneError').text('');
    }

{{-- end clear data from inputs  --}}


{{-- Insert  data start --}}
    function addData(){
       var name = $('#name').val();
        var title = $('#title').val();
       var phone = $('#phone').val();
       $.ajax({
           type:"POST",
           dataType:"json",
           data:{name:name,title:title,phone:phone},
           url:"/teacher/store",
           success:function(data){
               clearData();
               {{--  all data relod call that function  --}}
               allData();
           {{--  aleart start  --}}
        const msg = Swal.mixin({
                    toast:true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                    })

        msg.fire({
            type: 'success',
            title: 'data added successful',

            })

       {{--  aleart end  --}}


           },
           {{--  validation  --}}
           error:function(error){
               $('#nameError').text(error.responseJSON.errors.name);
               $('#titleError').text(error.responseJSON.errors.title);
               $('#phoneError').text(error.responseJSON.errors.phone);


           }

       })

    }
{{--  end insert data  --}}


{{--  start edit data  --}}

function editData(id){
    {{--  alert(id);  --}}
    $.ajax({
        type: "GET",
        dataType: "json",
        url:"/teacher/edit/"+id,
        success: function(data){
            $('#Add').hide();
            $('#addbutton').hide();
            $('#Update').show();
            $('#updatebutton').show();

            $('#nameError').text('');
        $('#titleError').text('');
        $('#phoneError').text('');

        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#title').val(data.title);
        $('#phone').val(data.phone);


        }

    })
}


{{--  end edit data  --}}

{{--  start update data  --}}

function updateData(){
    var id = $('#id').val();
    var name = $('#name').val();
    var title = $('#title').val();
    var phone = $('#phone').val();


    $.ajax({
        type: "POST",
        dataType: "json",
        data:{name:name,title:title,phone:phone},
        url:"/teacher/update/"+id,

        success:function(data){

            $('#Add').show();
            $('#addbutton').show();
            $('#Update').hide();
            $('#updatebutton').hide();

             clearData();
               {{--  all data relod call that function  --}}
               allData();
            {{--  console.log('data updated');  --}}

            {{--  aleart start  --}}
        const msg = Swal.mixin({
                    toast:true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                    })

        msg.fire({
            type: 'success',
            title: 'data update successful',

            })

       {{--  aleart end  --}}



        },
        error:function(error){
            $('#nameError').text(error.responseJSON.errors.name);
            $('#titleError').text(error.responseJSON.errors.title);
            $('#phoneError').text(error.responseJSON.errors.phone);

        }

    })
}


{{--  end update data  --}}

{{--  delete data start  --}}


function deleteData(id){

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {

        $.ajax({
            type:"GET",
            dataType:"json",
            url:"/teacher/delete/"+id,

            success:function(data){

                $('#Add').show();
                $('#addbutton').show();
                $('#Update').hide();
                $('#updatebutton').hide();

                clearData();
                allData();

            }
        })



      swalWithBootstrapButtons.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
      {{--  aleart start  --}}
      const msg = Swal.mixin({
                  toast:true,
                  position: 'top-end',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 1500
                  })

      msg.fire({
          type: 'success',
          title: 'data delete successful',

          })

     {{--  aleart end  --}}
    } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
    ) {
      swalWithBootstrapButtons.fire(
        'Cancelled',
        'Your imaginary file is safe :)',
        'error'
      )
    }
  })



















    {{--  $.ajax({
        type:"GET",
        dataType:"json",
        url:"/teacher/delete/"+id,

        success:function(data){

            $('#Add').show();
            $('#addbutton').show();
            $('#Update').hide();
            $('#updatebutton').hide();

            clearData();
            allData();

        }
    })  --}}

}



{{--  delete data end  --}}


</script>

</body>
</html>
