
<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="post" id="updateProductFrom">
    @csrf
    <input type="hidden" name="up_id" id="up_id" >
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="errMsgContainer">
          
        </div>
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" class="form-control" name="up_name" id="up_name" placeholder="Product Name">
        </div>
        <div class="form-group my-2">
          <label>Product Price</label>
          <input type="text" class="form-control" name="up_price" id="up_price" placeholder="Product Price">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_product">Update Product</button>
      </div>
    </div>
  </div>
  </form>
</div>