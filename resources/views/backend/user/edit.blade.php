@extends('backend.layouts.main')
@section('title', __('label.users.edit'))
@section('content')
<section class="content-header">
  <h1>
    {{__('label.users.edit')}}
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('backend.user.index')}}">{{__('label.users.list')}}</a></li>
    <li class="active">{{__('label.users.edit')}}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{Auth::user()->introimage != '' ? asset(Auth::user()->introimage) : asset('backend/dist/img/user2-160x160.jpg')}}" alt="User profile picture">

          <h3 class="profile-username text-center">{{Auth::user()->fullname}}</h3>

          <p class="text-muted text-center">{{Auth::user()->email}}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Phone:</b> <a class="pull-right">{{Auth::user()->tel}}</a>
            </li>
            <li class="list-group-item">
              <b>Address</b> <a class="pull-right">{{Auth::user()->address}}</a>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#addAccount" data-toggle="tab">{{__('label.users.edit')}}</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="addAccount">
            <form class="form-horizontal" action="{{route('backend.user.pEdit', ['id'=>$model->id])}}" method="POST">
              <div class="form-group {{$errors->has('fullname') ? 'has-error' : ''}}">
                <label for="inputName" class="col-sm-2 control-label">{{__('label.users.name')}}</label>
                <div class="col-sm-10">
                  <input type="text" name="fullname" class="form-control" id="inputName" value="{{$model->fullname}}" placeholder="{{__('label.users.name')}}">
                  <span class="help-block">{{$errors->first("fullname")}}</span>
                </div>
              </div>
              <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                <label for="inputEmail" class="col-sm-2 control-label required">{{__('label.users.email')}}</label>
                <div class="col-sm-10">
                  <input type="email" name="email" class="form-control" id="inputEmail" value="{{$model->email}}" placeholder="{{__('label.users.email')}}">
                  <span class="help-block">{{$errors->first("email")}}</span>
                </div>
              </div>
              <div class="form-group">
                <label for="tel" class="col-sm-2 control-label">{{__('label.users.tel')}}</label>
                <div class="col-sm-10">
                  <input type="text" name="tel" class="form-control" id="tel" value="{{$model->tel}}" placeholder="{{__('label.users.tel')}}">
                </div>
              </div>
              <div class="form-group">
                <label for="address" class="col-sm-2 control-label">{{__('label.users.address')}}</label>
                <div class="col-sm-10">
                  <input type="text" name="address" class="form-control" id="address" value="{{$model->address}}" placeholder="{{__('label.users.address')}}">
                </div>
              </div>
              <div class="form-group">
                <label for="address" class="col-sm-2 control-label">{{__('label.users.status')}}</label>
                <div class="col-sm-10">
            			<select class="form-control" style="width: 50%" name="status">
            				@if($listStatus)
            				@foreach($listStatus as $key => $status)
            				<option value="{{$key}}" {{$model->status == $key ? 'selected' : ''}}>{{$status}}</option>
            				@endforeach
            				@endif
            			</select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </form>   
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->
@stop