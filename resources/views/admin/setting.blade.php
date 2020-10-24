
@extends('admin.app')
@section('content')
<div class="form-element-area">
       <div class="container">
         <form action="{{route('setting.update')}}" method="post" enctype="multipart/form-data">
               {{csrf_field() }}

           <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="form-element-list">
                       <div class="basic-tb-hd">
                           <h2>All Settings </h2>
                         </div>

                         <div class="row">
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-group float-lb">
                                     <div class="nk-int-st" >
                                          <a href="#"><img style="background-color: #00c292;" src="{{asset($settings->logo)}}" alt="" /></a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-group float-lb">
                                     <div class="nk-int-st">
                                         <input name="logo" type="file" value="{{$settings->logo}}" class="form-control">
                                         <input name="id" type="hidden" value="{{$settings->id}}" class="form-control">
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-group float-lb">
                                     <div class="nk-int-st" >
                                          <a href="#"><img style="background-color: #00c292;height:30px;width:30px;" src="{{asset($settings->favicon)}}" alt="" /></a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-group float-lb">
                                     <div class="nk-int-st">
                                         <input name="favicon" type="file" value="{{$settings->favicon}}" class="form-control">
                                     </div>
                                 </div>
                             </div>
                         </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="title" value="{{$settings->title}}" class="form-control"><br/>
                                       <label style="top: -14px;" class="nk-label">Site Title</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="header1" value="{{$settings->header1}}" class="form-control"><br/>
                                       <label style="top: -14px;" class="nk-label">Bold Heading</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="header2" value="{{$settings->header2}}" class="form-control">
                                       <label style="top: -14px;" class="nk-label">Small Heading</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="facebook" value="{{$settings->facebook}}" class="form-control">
                                       <label style="top: -14px;" class="nk-label">Facebook Link</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="youtube" value="{{$settings->youtube}}" class="form-control">
                                       <label style="top: -14px;" class="nk-label">Youtube Link</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="twitter" value="{{$settings->twitter}}" class="form-control">
                                       <label style="top: -14px;" class="nk-label">Twitter Lingk</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="gmail" value="{{$settings->gmail}}" class="form-control">
                                       <label style="top: -14px;" class="nk-label">Gmail</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="phone" value="{{$settings->phone}}" class="form-control">
                                       <label style="top: -14px;" class="nk-label">Phone Number</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="form-group float-lb">
                                   <div class="nk-int-st">
                                       <input type="text" name="address" value="{{$settings->address}}" class="form-control">
                                       <label style="top: -14px;" class="nk-label">Address</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                  <div class="nk-int-st">
                                      <textarea style=" padding-left: 21px;" name="description" class="form-control" rows="5">{{$settings->description}}</textarea>

                                  </div>
                              </div>
                          </div>
                      </div>
                   <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                  <div class="nk-int-st">
                                      <textarea name="footer"  style=" padding-left: 21px;" class="form-control" rows="5">{{$settings->footer}}</textarea>

                                  </div>
                              </div>
                          </div>
                      </div>
                   <div class="row"  style="float:right;">
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
