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

    <title>Add Category</title>
  </head>
  <body>
    <div class="container mt-5">
      <ul id="save_msgList"></ul>

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title"><h4>Add Category</h4></div>
              <div class="offset-10">
                <a href="{{route('category')}}" class="btn btn-primary">List</a>
              </div>
            </div>
            <div class="card-body">
             <form id="categoryForm" name="categoryForm">
             	<div class="form-group">
             		<label>Category name</label>
             		<input type="text" name="name" id="name" class="form-control" placeholder="Category name">
             	</div>
             	<div class="form-group">
             		<label>Description</label>
             		<textarea type="text" name="description" id="description" class="form-control" placeholder="Description"></textarea>
             	</div>
             	<div class="form-group mt-2">
             		<button  name="categorySubmit" id="categorySubmit" class="categorySubmit btn btn-primary">Submit</button>
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
    		$(document).on('click','.categorySubmit',function(e){
    			e.preventDefault();
    			
    			var data = {
    				name:$('#name').val(),
    				description:$('#description').val()
    			}
    			$.ajaxSetup({
    				headers:{
    					"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr('content')
    				}
    			});

    			$.ajax({
    				type:"post",
    				url:"{{route('category.store')}}",
    				data:data,
    				dataType:'json',
    				success:function(response){
    					// console.log(response);
              if (response.status == 400) {
                        $('#save_msgList').html("");
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        $('.add_student').text('Save');
              }else{
    					   window.location = '{{route("category")}}';

              }

    				}
    			})
    		}); 
    	});
    </script>




  </body>
</html>