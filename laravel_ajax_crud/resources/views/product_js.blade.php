    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
     <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Toastr Message -->
    <!-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click','.add_product',function(e){
                e.preventDefault();
                let name = $('#name').val();
                let price = $('#price').val();
                // alert(name + price);
                $.ajax({
                    url:"{{ route('add.product') }}",
                    method:"post",
                    data:{name:name,price:price},
                    success:function(res){
                        if(res.status=='success'){
                            $("#addModal").modal('hide');
                            $("#addProductFrom")[0].reset();
                            $('.table').load(location.href+' .table ');
                            Command: toastr["success"]("Product save!")
                                toastr.options = {
                                      "closeButton": true,
                                      "debug": false,
                                      "newestOnTop": false,
                                      "progressBar": true,
                                      "positionClass": "toast-top-right",
                                      "preventDuplicates": false,
                                      "onclick": null,
                                      "showDuration": "300",
                                      "hideDuration": "1000",
                                      "timeOut": "5000",
                                      "extendedTimeOut": "1000",
                                      "showEasing": "swing",
                                      "hideEasing": "linear",
                                      "showMethod": "fadeIn",
                                      "hideMethod": "fadeOut"
                                    }
                        }
                    },error:function(err){
                        let error = err.responseJSON;
                        $.each(error.errors,function(index,value){
                            $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'<br />');
                        });
                    }
                });
            });

            //edit  product form
            $(document).on('click','.update_product_form',function(){
                let id = $(this).data('id');
                let name = $(this).data('name');
                let price = $(this).data('price');

                $("#up_id").val(id);
                $('#up_name').val(name);
                $('#up_price').val(price);
            });
            //update product form
            $(document).on('click','.update_product',function(e){
                e.preventDefault();
                let up_id = $('#up_id').val();
                let up_name = $('#up_name').val();
                let up_price = $('#up_price').val();
                // alert(up_name + up_price);
                $.ajax({
                    url:"{{ route('update.product') }}",
                    method:"post",
                    data:{up_id:up_id,up_name:up_name,up_price:up_price},
                    success:function(res){
                        if(res.status=='success'){
                            $("#updateModal").modal('hide');
                            $("#updateProductFrom")[0].reset();
                            $('.table').load(location.href+' .table ');
                            Command: toastr["success"]("Product update!")
                                toastr.options = {
                                      "closeButton": true,
                                      "debug": false,
                                      "newestOnTop": false,
                                      "progressBar": true,
                                      "positionClass": "toast-top-right",
                                      "preventDuplicates": false,
                                      "onclick": null,
                                      "showDuration": "300",
                                      "hideDuration": "1000",
                                      "timeOut": "5000",
                                      "extendedTimeOut": "1000",
                                      "showEasing": "swing",
                                      "hideEasing": "linear",
                                      "showMethod": "fadeIn",
                                      "hideMethod": "fadeOut"
                                    }
                        }
                    },error:function(err){
                        let error = err.responseJSON;
                        $.each(error.errors,function(index,value){
                            $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'<br />');
                        });
                    }
                });
            });
            //delete product form
            $(document).on('click','.delete_product',function(e){
                e.preventDefault();
                let product_id = $(this).data('id');
                // alert(product_id);
                if(confirm('Are you sure you want to delete product ?')){
                    $.ajax({
                        url:"{{ route('delete.product') }}",
                        method:"post",
                        data:{product_id:product_id},
                        success:function(res){
                            if(res.status=='success'){
                                $('.table').load(location.href+' .table ');
                                Command: toastr["success"]("Product delete!")
                                toastr.options = {
                                      "closeButton": true,
                                      "debug": false,
                                      "newestOnTop": false,
                                      "progressBar": true,
                                      "positionClass": "toast-top-right",
                                      "preventDuplicates": false,
                                      "onclick": null,
                                      "showDuration": "300",
                                      "hideDuration": "1000",
                                      "timeOut": "5000",
                                      "extendedTimeOut": "1000",
                                      "showEasing": "swing",
                                      "hideEasing": "linear",
                                      "showMethod": "fadeIn",
                                      "hideMethod": "fadeOut"
                                    }   
                            }
                        }
                    });
                }
            });
            //Pagination
            $(document).ready(".pagination a",function(e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1]
                product(page)
            });

            function product(page){
                $.ajax({
                    url:"/pagination/paginate-data?page="+page,
                    success:function(res){
                        // console.log(res);
                        $('.table-data').html(res);
                    }   

                });
            }
            //search product
            $(document).on('keyup',function(e){
                e.preventDefault();
                let search_string = $("#search").val();
                $.ajax({
                    url:"{{route('search.product')}}",
                    method:"GET",
                    data:{search_string:search_string},
                    success:function(res){
                        $('.table-data').html(res);
                        if(res.status=='nothing_found'){
                            $('.table-data').html('<span class="text-danger">'+'nothing found'+'</span>');
                        }
                    }
                });
                // console.log(search_string);


            });
        });
        
    </script>