
@extends('admin.app')
@section('content')
<div class="form-element-area">
       <div class="container">
         <form action="{{route('update.terms')}}" method="post" enctype="multipart/form-data">
               {{csrf_field() }}

           <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 @if (Session::has('danger'))
                   <div class="alert alert-danger">
                     <p>{{Session::get('danger')}}</p>
                   </div>
                 @endif
                 @if (Session::has('success'))
                   <div class="alert alert-success">
                     <p>{{Session::get('success')}}</p>
                   </div>
                 @endif
                   <div class="form-element-list">
                       <div class="basic-tb-hd">
                           <h2>Update Terms And Conditions </h2>
                         </div>

                         <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="nk-int-st">
                                             <input type="hidden" name="id" value="{{$terms->id}}">
                                            <textarea style=" padding-left: 21px;" name="text" class="form-control" rows="40">{{$terms->text}}</textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>

                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="float:right;">
                             <div class="form-example-int">
                                 <button class="btn btn-success notika-btn-success">Update</button>
                             </div>
                         </div>
                      </div>
               </div>
           </div>

        </form>
       </div>
   </div>
@endsection
