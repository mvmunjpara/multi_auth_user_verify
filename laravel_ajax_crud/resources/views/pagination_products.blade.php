   <table class="table table-boardered">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($products as $key=>$product)
                        <tr>
                          <th>{{$product->id}}</th>
                          <td>{{$product->name}}</td>
                          <td>{{$product->price}}</td>

                          <th>
                              <a href="" class="btn btn-success update_product_form" 
                              data-bs-toggle="modal"
                              data-bs-target="#updateModal"
                              data-id="{{$product->id}}"
                              data-name="{{$product->name}}"
                              data-price="{{$product->price}}"
                              ><i class="las la-edit"></i></a>
                              <a href="" class="delete_product"  data-id="{{$product->id}}"><i class="btn btn-danger las la-times"></i></a>
                          </th>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {!!$products->links()!!}