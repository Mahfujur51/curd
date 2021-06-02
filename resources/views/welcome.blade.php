<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"  />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-header bg-primary">
                    <h3 class="float-left text-white">Customer CURD system</h2>
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#customer_add">
                            <i class="fas fa-user-plus"></i> Customer
                        </button>
                </div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Name</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th>Gender</th>
                            <th>Status</th>

                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                         @forelse ($customers as $key=>$customer)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$customer->name}}</td>
                            <td><img src="{{asset('customer/'.$customer->image)}}" alt="" width="100" height="100"></td>
                            <td>{{$customer->email}}</td>
                            <td>{{$customer->phone}}</td>
                            <td>
                                @if($customer->gender=='male')
                                    <span class="badge badge-success">Male</span>
                                @else
                                    <span class="badge badge-primary">Female</span>
                                @endif
                            </td>
                            <td>
                                @if($customer->status=='active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#view_customer{{$customer->id}}"><i class="fas fa-eye"></i></a>
                               @if($customer->status=='active')
                                    <a href="{{route('inactive',$customer->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-arrow-down"></i></a>

                                @else
                                    <a href="{{route('active',$customer->id)}}" class="btn btn-success btn-sm"><i class="fas fa-arrow-up"></i></a>

                                @endif

                                <a  href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_customer{{$customer->id}}"><i class="fas fa-edit"></i></a>
                                <a href="{{route('delete',$customer->id)}}" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @empty
                             <tr>
                                 <td colspan="10" class="text-center"><h6 class="text-danger">No Data Avilable !! Please Customer Insert Fast</h6></td>
                             </tr>
                         @endforelse
                        </tbody>
                    </table>
                    {{$customers->links()}}

                </div>
            </div>
        </div>
    </div>

</div>
<!-- Modal customer add  -->
<div class="modal fade" id="customer_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="emailHelp" placeholder="Enter name" name="name">
                                @error('name')
                                <span class="invalid-feedback " role="alert">
                                   <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Phone</label>
                                <input type="number" class="form-control  @error('phone') is-invalid @enderror" placeholder="Enter Phone number"  name="phone">
                                @error('phone')
                                <span class="invalid-feedback " role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Enter Email" id="email" name="email">
                        @error('email')
                        <span class="invalid-feedback " role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="btn-group">
                        <p class="mr-4">Gender :</p> <br>
                        <input type="radio" class="btn-check @error('gender') is-invalid @enderror" name="gender" id="name" autocomplete="off" value="male">
                        <label for="male" class="mr-4">Male</label>

                        <input type="radio" class="btn-check @error('gender') is-invalid @enderror" name="gender" id="female" autocomplete="off" value="female">
                        <label  for="female">Female</label>
                        @error('gender')
                        <span class="invalid-feedback " role="alert">
                                       <strong class="text-danger">{{ $message }}</strong>
                                   </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p>Status:</p>
                        <input name="status" class=" @error('active') is-invalid @enderror" type="checkbox" value="active">
                        @error('status')
                        <span class="invalid-feedback " role="alert">
                                       <strong class="text-danger">{{ $message }}</strong>
                                   </span>
                        @enderror
                        <label for="">Active</label>
                    </div>
                    <div class="form-group">
                        <label for="email">Photo</label>
                        <input type="file" class="form-control  @error('image') is-invalid @enderror"  id="email" name="image" oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                        <img id="pic"  height="100px" width="100px"  alt="image preview"/>
                        @error('image')
                        <span class="invalid-feedback " role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success float-right"> <i class="fas fa-user-plus"></i> Add Customer</button>
                </form>

            </div>
        </div>
    </div>
</div>
{{-- modal customer add end --}}

@foreach($customers as $customer)
<!-- Modal customer view  -->
<div class="modal fade" id="view_customer{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="card">
                   <div class="card-body">
                       <div class="row">

                              <div class="col-md-6">

                                          <img src="{{asset('customer/'.$customer->image)}}" alt="">

                              </div>
                              <div class="col-md-6">
                                   <table class="table">
                                       <tr>
                                           <th>Name:</th>
                                           <td>{{$customer->name}}</td>
                                       </tr>
                                       <tr>
                                           <th>Email:</th>
                                           <td>{{$customer->email}}</td>
                                       </tr>
                                       <tr>
                                           <th>Phone:</th>
                                           <td>{{$customer->phone}}</td>
                                       </tr><tr>
                                           <th>Gender</th>
                                           <td>{{$customer->gender}}</td>
                                       </tr><tr>
                                           <th>Status</th>
                                           <td>{{$customer->status}}</td>
                                       </tr>


                                   </table>

                              </div>

                       </div>
                   </div>
               </div>

            </div>
        </div>
    </div>
</div>
@endforeach
{{-- modal customer veiw --}}
@foreach($customers as $customer)
<!-- Modal customer edit  -->
<div class="modal fade" id="edit_customer{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit  Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('update',$customer->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="emailHelp" value="{{$customer->name}}" name="name">
                                @error('name')
                                <span class="invalid-feedback " role="alert">
                                   <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Phone</label>
                                <input type="number" class="form-control  @error('phone') is-invalid @enderror" value="{{$customer->phone}}"  name="phone">
                                @error('phone')
                                <span class="invalid-feedback " role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" value="{{$customer->email}}" id="email" name="email">
                        @error('email')
                        <span class="invalid-feedback " role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="btn-group">
                        <p class="mr-4">Gender :</p> <br>
                        <input type="radio" class="btn-check @error('gender') is-invalid @enderror" name="gender" id="name" autocomplete="off" value="male" @if($customer->gender=='male') checked @endif>
                        <label for="male" class="mr-4">Male</label>

                        <input type="radio" class="btn-check @error('gender') is-invalid @enderror" name="gender" id="female" autocomplete="off" value="female"  @if($customer->gender=='female') checked @endif>
                        <label  for="female">Female</label>
                        @error('gender')
                        <span class="invalid-feedback " role="alert">
                               <strong class="text-danger">{{ $message }}</strong>
                         </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p>Status:</p>
                        <input name="status" class=" @error('active') is-invalid @enderror" type="checkbox" value="active" @if($customer->status=='active') checked @endif>
                        @error('status')
                        <span class="invalid-feedback " role="alert">
                                       <strong class="text-danger">{{ $message }}</strong>
                                   </span>
                        @enderror
                        <label for="">Active</label>
                    </div>
                    <div class="form-group">
                        <label for="email">Photo</label>
                        <input type="file" class="form-control  @error('image') is-invalid @enderror"  id="email" name="image" oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                        <img id="pic" src="{{asset('customer/'.$customer->image)}}"  height="100px" width="100px"  alt="image preview"/>
                        @error('image')
                        <span class="invalid-feedback " role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success float-right"> <i class="fas fa-user-plus"></i> Add Customer</button>
                </form>

            </div>
        </div>
    </div>
</div>
{{-- modal customer edit end--}}
@endforeach


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>


<script>
    @if (Session::has('success'))
    toastr.success("{{Session::get('success')}}")
    @endif
    @if (Session::has('info'))
    toastr.info("{{Session::get('info')}}")
    @endif
</script>
<script>

    $(document).on("click", "#delete", function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        swal({
            title: "Are You Sure Want to Delete?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = link;
                } else{
                    swal("Safe Data!");
                }

            });
    });
</script>
</body>
</html>
