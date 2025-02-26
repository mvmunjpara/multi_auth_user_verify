<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Product</title>
  </head>
  <body>
    <div class="container mt-5">
      @if(session()->has('success'))
        <div class="alert alert-success">
          {{session()->get('success')}}
        </div>
      @endif
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title"><h4>Product</h4></div>
              <div class="offset-10">
                <a href="{{route('product.create')}}" class="btn btn-primary">Add Product</a>
              </div>
            </div>
             <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Manufatured Date</th>
                                <th>Expiry Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        //Add product
          $.ajaxSetup({
            headers:{
              "X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr('content')
            }
          });

          //product display
          fetchproduct();

        function fetchproduct() {
            $.ajax({
                type: "GET",
                url: "/fetchproduct",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.fetchproduct, function (key, item) {
                        $('tbody').append('<tr>\
                            <td>' + item.id + '</td>\
                            <td>' + item.category.name + '</td>\
                            <td>' + item.name + '</td>\
                            <td>' + item.description + '</td>\
                            <td>' + item.image + '</td>\
                            <td>' + item.price + '</td>\
                            <td>' + item.quantity + '</td>\
                            <td>' + item.manufatured_date + '</td>\
                            <td>' + item.expiry_date + '</td>\
                            <td><a href="/product/edit/' + item.id + '" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Edit</a></td>\
                            <td><button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
                        \</tr>');
                    });
                }
            });
        }

        //Delete category
        $(document).on('click','.deletebtn',function(e){
          e.preventDefault();
          let id = $(this).val();
          
          $.ajaxSetup({
            headers:{
              "X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:'POST',
            url:"category/destroy/"+id,
            data:id,
            dataType:'json',
            success:function(response){
              // console.log(response);
            window.location = '{{route("category")}}';

            }
          });
        });

      });
    </script>
  </body>
</html>