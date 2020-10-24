
@extends('admin.app')
@section('content')

<div class="data-table-area">
       <div class="container">
           <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="data-table-list">
                       <div class="basic-tb-hd">
                           <h2>All Users</h2>

                       </div>
                       <div class="modal fade" id="myModaltwo" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                      <form method="POST" action="{{ route('add.admin') }}">
                                					@csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <h2>Add Admin User</h2>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group float-lb">
                                                            <div class="nk-int-st">
                                                                	<input id="name" placeholder="First Name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group float-lb">
                                                            <div class="nk-int-st">
                                                                		<input id="name" placeholder="Last Name" type="text" class="form-control" name="lname" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group float-lb">
                                                            <div class="nk-int-st">
                                                              	<input placeholder="Email" id="name" type="text" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group float-lb">
                                                            <div class="nk-int-st">
                                                                	<input placeholder="Password" id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group float-lb">
                                                            <div class="nk-int-st">
                                                                   <input type="hidden" name="role" value="admin">
                                                                	<input placeholder="Repassword" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            <div class="modal-footer">
                                                 <button class="btn btn-success notika-btn-success">Save</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                  </form>
                                </div>

                       <div class="table-responsive">
                           <table id="data-table-basic" class="table table-striped">
                               <thead>
                                   <tr>
                                       <th>S/L</th>
                                       <th>Date</th>
                                       <th>User ID</th>
                                       <th>Profile</th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Number</th>
                                   </tr>
                               </thead>
                               <tbody>
                                 @php $i=1; @endphp
                                 @foreach($users as $user)
                                   <tr>
                                       <td>{{$i++}}</td>
                                       <td>{{$user->created_at}}</td>
                                       <td>  {{$user->user_id}} </td>
                                       <td><img style="border-radius: 50%;height: 55px;width: 55px;margin-top: 16px;margin-left: 10px" src="{{asset($user->photo)}}" alt=""> </td>
                                       <td>{{$user->first_name}}{{$user->last_name}}</td>
                                       <td>{{$user->email}}</td>
                                       <td>{{$user->number}}</td>
                                       <td><button style="background: #00BCD4;color:white;" class="btn notika-btn-teal waves-effect"><i class="notika-icon notika-edit"></i></button>
                                        <a href="#"> <button class="btn btn-danger danger-icon-notika waves-effect"><i class="notika-icon notika-trash"></i></button></td>
                                   </tr>
                                   @endforeach
                               </tbody>
                           </table>
                       </div>
                       <div class="modal fade" id="myModalthree" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                    <form action="{{route('slider.save')}}" method="post" enctype="multipart/form-data">
                                          {{csrf_field() }}
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <h2>Add Slide Image</h2>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group float-lb">
                                                            <div class="nk-int-st">
                                                                <input name="slider_image" type="file" class="form-control">
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            <div class="modal-footer">
                                                 <button class="btn btn-success notika-btn-success">Save</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                  </form>
                                </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <script>

     $('#edit').on('show.bs.modal', function (event) {
         var button = $(event.relatedTarget)
         var title = button.data('mytitle')
         console.log(title);

         var modal = $(this)
         modal.find('.modal-body #title').val(title);
         modal.find('.modal-body #des').val(description);
         modal.find('.modal-body #cat_id').val(cat_id);
   })
   </script>
@endsection
