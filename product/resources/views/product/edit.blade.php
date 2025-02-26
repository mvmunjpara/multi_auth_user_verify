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

    <title>Edit Product</title>
  </head>
  <body>
    <div class="container mt-5">
      <ul id="save_msgList"></ul>

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title"><h4>Edit Product</h4></div>
              <div class="offset-10">
                <a href="{{route('product')}}" class="btn btn-primary">List</a>
              </div>
            </div>
            <div class="card-body">
             <form id="productForm" name="productForm" enctype="multipart/form-data">
              <div class="form-group">
                <label>Select Category</label>
                <select name="cat_id" id="cat_id" class="form-control">
                 <option>Select Category</option> 
                 @foreach($categories as $category)
                 <option value="{{$category->id}}" {{($category->id==$product->cat_id)?'selected':''}}>{{$category->name}}</option> 
                 @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Product name</label>
                <input type="text" name="name" id="name" value="{{$product->name}}" class="form-control" placeholder="Product name">
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea type="text" name="description" id="description" class="form-control" placeholder="Description">{{$product->description}}</textarea>
              </div>
              <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" id="image" class="form-control" >
              </div>
              <div class="form-group">
                <label>Product price</label>
                <input type="text" name="price" id="price" value="{{$product->price}}" class="form-control" placeholder="Product price">
              </div>  
              <div class="form-group">
                <label>Product Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{$product->quantity}}" class="form-control" placeholder="Product quantity">
              </div>
              <div class="form-group">
                <label>Product Manufatured Date</label>
                <input type="date" name="manufatured_date" id="manufatured_date" value="{{$product->manufatured_date}}" class="form-control">
              </div>
             <div class="form-group">
                <label>Product Expiry Date</label>
                <input type="date" name="expiry_date" id="expiry_date" value="{{$product->expiry_date}}" class="form-control">
              </div>
              <div class="form-group mt-2">
                <button type="submit" name="productSubmit" id="productSubmit" class="productSubmit btn btn-primary">Submit</button>
              </div>
             </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    
    <script type="text/javascript">
      $(document).ready(function(){

        //Add Category
        $("#productForm").on('submit',function(e){
          e.preventDefault();
          // alert('hello');
          
          // var data = {
          //   cat_id :$('#cat_id').val(),
          //  name:$('#name').val(),
          //  description:$('#description').val(),
          //   image:$('#image').val(),
          //   price:$('#price').val(),
          //   quantity:$('#quantity').val(),
          //   manufatured_date:$('#manufatured_date').val(),
          //   expiry_date:$('#expiry_date').val(),
          // }
         
          $.ajaxSetup({
            headers:{
              "X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr('content')
            }
          });

          $.ajax({
            type:"post",
            url:"{{route('product.update',$product->id)}}",
            data:new FormData(this),
            dataType:'json',
            contentType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(response){
              console.log(response);
              if (response.status == 400) {
                        $('#save_msgList').html("");
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        
              }else{
                 window.location = '{{route("product")}}';

              }

            }
          })
        }); 
      });
    </script>




  </body>
</html>