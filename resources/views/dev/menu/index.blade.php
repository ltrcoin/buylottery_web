@extends('backend.layouts.main')
@section('title', 'Menu')
@section('content')
@if (Session::has('msg_menu'))
    <script type="text/javascript">
    $(function() {
      jAlert('{{Session::get("msg_menu")}}', 'Thông báo');
    });
    </script>
@endif
<section class="content-header">
  <h1>
    Menu
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Menu</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-body">
          <div class="col-sm-6">
            <div class="box-header with-border">
              <h3 class="box-title">Danh sách menu</h3>
            </div>
            <div class="dd">
              {!!$menu!!}
            </div>
          </div>
          <div class="col-sm-6">
            <div class="box-header with-border">
              <h3 class="box-title">Thêm menu mới</h3>
              <input type="hidden" id="delUrl" value="{{url('admin/menu/delete')}}">
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            @if(isset($model))
            <form class="form-horizontal" action="{{route('backend.menu.pEdit',['id'=>$model->id])}}" method="POST">
              {{csrf_field()}}
              <div class="box-body">
                <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                  <label for="name" class="col-sm-3 col-md-2 control-label required">Tên menu</label>
                  <div class="col-sm-9 col-md-10">
                    <input class="form-control" id="name" placeholder="Nhập tên menu" type="text" name="name" value="{{$model->name}}">
                  </div>
                  <span class="help-block">{{$errors->first("name")}}</span>
                </div>
                <div class="form-group {{$errors->has('url') ? 'has-error' : ''}}">
                  <label for="url" class="col-sm-3 col-md-2 control-label required">Url</label>
                  <div class="col-sm-9 col-md-10">
                    <input class="form-control" id="url" placeholder="Nhập url" type="text" name="url" value="{{$model->url}}">
                  </div>
                  <span class="help-block">{{$errors->first("url")}}</span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 col-md-2 control-label">Menu cha</label>
                  <div class="col-sm-9 col-md-10">
                    <select class="form-control" id="parent_id" name="parent_id" style="width: 50%;">
                        <option value="0">Chọn menu cha</option>
                        @if(isset($options) && !empty($options))
                          {!!$options!!}
                        @endif
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="url" class="col-sm-3 col-md-2 control-label">Trạng thái</label>
                  <div class="col-sm-9 col-md-10">
                    <select class="form-control" id="status" name="status" style="width: 50%;">
                      @if(isset($listStatus) && is_array($listStatus))
                        @foreach($listStatus as $key=>$type)
                        <option value="{{$key}}" {{$model->status == $key ? "selected='selected'" : ''}}>{{$type}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
            @else 
            <form class="form-horizontal" action="{{route('backend.menu.pAdd')}}" method="POST">
              {{csrf_field()}}
              <div class="box-body">
                <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                  <label for="name" class="col-sm-3 col-md-2 control-label required">Tên menu</label>
                  <div class="col-sm-9 col-md-10">
                    <input class="form-control" id="name" placeholder="Nhập tên menu" type="text" name="name">
                  </div>
                  <span class="help-block">{{$errors->first("name")}}</span>
                </div>
                <div class="form-group {{$errors->has('url') ? 'has-error' : ''}}">
                  <label for="url" class="col-sm-3 col-md-2 control-label required">Url</label>
                  <div class="col-sm-9 col-md-10">
                    <input class="form-control" id="url" placeholder="Nhập url" type="text" name="url">
                  </div>
                  <span class="help-block">{{$errors->first("url")}}</span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 col-md-2 control-label">Menu cha</label>
                  <div class="col-sm-9 col-md-10">
                    <select class="form-control" id="parent_id" name="parent_id" style="width: 50%;">
                        <option value="0">Chọn menu cha</option>
                        @if(isset($options) && !empty($options))
                          {!!$options!!}
                        @endif
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="url" class="col-sm-3 col-md-2 control-label">Trạng thái</label>
                  <div class="col-sm-9 col-md-10">
                    <select class="form-control" id="status" name="status" style="width: 50%;">
                      @if(isset($listStatus) && is_array($listStatus))
                        @foreach($listStatus as $key=>$type)
                        <option value="{{$key}}">{{$type}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
            @endif
          </div>        
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<style type="text/css">
  .dd {
      position: relative;
      display: block;
      margin: 0;
      padding: 0;
      max-width: 600px;
      list-style: none;
      font-size: 13px;
      line-height: 20px;
      width: 80%;
  }
  .dd-handle {
    display: block;
    height: 30px;
    margin: 5px 0;
    padding: 5px 10px;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
    border-radius: 3px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
  }
  .dd-handle:hover {
    color: #2ea8e5;
    background: #fff;
  }
  .dd-item {
    display: block;
    position: relative;
    margin: 0;
    padding: 0;
    min-height: 20px;
    font-size: 13px;
    line-height: 20px;
  }
  .dd-list {
    list-style: none;
  }
  .deleteItem {
    position: absolute;
    top: 4px;
    right: -50px;
    cursor: pointer;
  }
  .editItem {
    position: absolute;
    top: 4px;
    right: -25px;
  }
</style>
@stop