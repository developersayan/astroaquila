@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Puja Order </title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
	#exits_title{
		display: none;
		color: red;
	}
  .custom_angle.angle {
    right: 32px;
}
.add_puja_link{
  cursor: pointer;
}
</style>
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
<!-- Left Sidebar End -->
 <!-- ============================================================== --> 
  <!-- Start right Content here --> 
  <!-- ============================================================== -->
  <div class="content-page"> 
    <!-- Start content -->
    <div class="content">
      <div class="container"> 
        
        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <h4 class="pull-left page-title">Manage Puja Order</h4>
            <ol class="breadcrumb pull-right">
              {{-- <li class="active"><a href="{{route('admin.manage.add-product-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li> --}}
              <li class="active"><a href="{{route('admin.order.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <div class="clearfix"></div>
            <div class="panel panel-default">
              
              <div class="panel-heading rm02 rm04">

                <form role="form" method="post" action="{{route('admin.manage.puja.order.search')}}" class="search_filter" id="search_form">
                  @csrf
                 
                  <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                    <label for="FullName">keyword</label>
                    <input type="text" placeholder="keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>


                  <div class="form-group">
                    <label for="FullName">From</label>
                   <input type="text" name="from_date" value="{{request('from_date')}}" id="datepicker" placeholder="{{__('profile.from_placeholder')}}" class="position-relative from_date">

                  </div>
                  <div class="form-group">
                    <label for="">To</label>
                   <input type="text" name="to_date" value="{{request('to_date')}}" id="datepicker1" placeholder="{{__('profile.to_placeholder')}}" class="position-relative to_date">

                  </div>

                  
               <div class="form-group">
                    <label for="FullName">Status</label>
                   <select class="form-control rm06 basic-select" name="status">
                   		<option value="">Select Status</option>
                      <option value="A" @if(request('status')=='A') selected @endif>Accepted</option>
                      <option value="C" @if(request('status')=='C') selected @endif>Complete</option>
                      <option value="I" @if(request('status')=='I') selected @endif>Incomplete</option> 
                      <option value="IP" @if(request('status')=='IP') selected @endif>Inprocess</option>
                        <option value="N" @if(request('status')=='N') selected @endif>New</option>
                        
                        
                        {{-- <option value="CA" @if(request('status')=='CA') selected @endif>Cancel</option> --}}
                        
                        
                    </select>
                  </div>

                  <div class="clearfix"></div>

                  <div class="form-group">
                    <label for="FullName">Order No</label>
                    <input type="text" placeholder="Order no" class="form-control" name="order_id" value="{{request('order_id')}}">
                  </div>

                  <div class="form-group">
                    <label for="FullName">Puja</label>
                   <select class="form-control rm06 basic-select" name="puja">
                      <option value="">Select Puja</option>
                      @foreach(@$puja_list as $value)
                      <option value="{{@$value->id}}" @if(request('puja')==@$value->id) selected @endif>{{@$value->puja_name}}</option>
                      @endforeach
                                                    
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="FullName">Pundit Assigned</label>
                   <select class="form-control rm06 basic-select" name="assigned" id="assigned">
                      <option value="">Pundit Assigned</option>
                        <option value="Y" @if(request('assigned')=='Y') selected @endif>Yes</option>
                        <option value="N" @if(request('assigned')=='N') selected @endif>No</option>                          
                    </select>
                  </div>
                  

                 

                  <div class="form-group" id="pundit_list" @if(request('assigned')=="Y") style="display: block;" @else style="display: none;" @endif>
                    <label for="FullName">Pundit List</label>
                   <select class="form-control rm06 basic-select" name="pundit_search">
                      <option value="">Select Pundit</option>
                      @foreach(@$pundits as $value)
                      <option value="{{@$value->id}}" @if(request('pundit_search')==@$value->id) selected @endif>{{@$value->first_name}} {{@$value->last_name}}</option>
                      @endforeach                          
                    </select>
                  </div>


                  <div class="clearfix"></div>
                  <div class="rm05 marl0">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Search</button>
                  </div>
                </form>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  	@include('admin.includes.message')
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order Id</th>
                            <th>Customer Name</th>
                            <th>Puja Title</th>
                            <th>Puja Type </th>
                            <th>Puja Date</th>
                            <th>Total Price</th>
                            <th>Assigned Pundit</th>
                            <th>Status</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$pujas->isNotEmpty())
                        @foreach(@$pujas as $value)
                          <tr>
                            <td><a href="{{route('admin.manage.puja.order-view',['id'=>@$value->id])}}">{{@$value->order_id}}</a></td>
                            <td>{{@$value->customer->first_name}} {{@$value->customer->last_name}}</td>
                            <td>{{@$value->pujas->puja_name}}</td>
                            <td>
                              @if(@$value->puja_type=="ONLINE")
                              Online
                              @elseif(@$value->puja_type=="OFFLINE")
                              Offline
                              @endif
                            </td>
                            <td>{{date('d/m/Y',strtotime(@$value->date))}}</td>
                            <td>{{@$value->currencyDetails->currency_code}} {{@$value->total_rate}}</td>
                            <td>
                              @if(@$value->user_id==null)
                              --
                              @else
                              {{@$value->pundit->first_name}} {{@$value->pundit->last_name}}
                              @endif
                            </td>
                            <td>
                              @if(@$value->status=="I")
                              Initiated
                              @elseif(@$value->status=="N")
                              New
                              @elseif(@$value->status=="C")
                              Completed
                              @elseif(@$value->status=="CA")
                              Canceled
                              @elseif(@$value->status=="IP")
                              Inprocess
                              @elseif(@$value->status=="A")
                              Accepted
                              @endif
                            </td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    @if(date('d/m/Y',strtotime(@$value->date))>=date('d/m/Y'))
                                    @if(@$value->user_id==null)
                                    <li><a data-id ="{{@$value->id}}" data-puja = "{{@$value->puja_id}}" data-zip="{{@$value->puja_zip}}" data-manner = "{{@$value->puja_type}}" class="assign_modal_click" style="cursor: pointer;">Assign Pundit</a></li>
                                    @endif

                                    @if(@$value->user_id!=null)
                                    @if(@$value->status=='A' || @$value->status=='N')
                                    <li><a data-id ="{{@$value->id}}" data-puja = "{{@$value->puja_id}}" data-zip="{{@$value->puja_zip}}" data-manner = "{{@$value->puja_type}}" class="re_assign_modal_click" style="cursor: pointer;">Reassign Pundit</a></li>
                                    @endif
                                    @endif

									                  @if(@$value->puja_type=="ONLINE")
                                    @if(@$value->user_id!=null)
                                    @if(@$value->final_puja_link=="" && @$value->final_puja_notes=="")
                                    <li ><a data-id ="{{@$value->id}}"  class="add_puja_link">Add Link</a></li>
                                    @endif
                                    @endif
                                    @endif
                                    @endif
                                    <li><a href="{{route('admin.manage.puja.order-view',['id'=>@$value->id])}}"
                                    	>View</a></li>
                                 </ul>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                          @else
                          <tr><td>No Order Found</td></tr>
                          @endif 
                        </tbody>
                      </table>
                    </div>
                    
                    
                    <ul class="pagination rtg">
                      {{@$pujas->links()}}
                    </ul>
                    
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End row --> 
  


   <div class="modal res-modal" id="myModal">
    <div class="modal-dialog"  style="width: 900px;">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Assign Pundit</h4>
          <button type="button" class="close" data-dismiss="modal" onclick="location.reload()" style="margin-top: -34px;">&times;</button>
        </div>
        
        <!-- Modal body -->

        <div class="form-group">
                    <label for="FullName">Code</label>
                    <input type="text" placeholder="Code" class="form-control" id="code_seach" >
                  </div>
                  
                  <div class="form-group">
                    <label for="FullName">Name</label>
                    <input type="text" placeholder="Name" class="form-control" id="name_seach" >
                  </div>

                  <div class="form-group">
                    <label for="FullName">Address</label>
                    <input type="text" placeholder="Address" class="form-control" id="address_seach" >
                  </div>

                  <div class="form-group">
                    <label for="FullName">Phone Number</label>
                    <input type="text" placeholder="Phone Number" class="form-control" id="number_seach">
                  </div>

                  <div class="rm05 marl0">
                    <a class="btn btn-primary waves-effect waves-light w-md" id="assign_search">Search</a>
                  </div>
        <form id="assignForm" method="post" action="{{route('admin.manage.puja.assign-pundit')}}">
          @csrf
          
          <input type="hidden" name="id" id="order_id" class="order_id">
          <input type="hidden" name="puja_id" id="puja_id" >
          <input type="hidden" name="zip_id" id="zip_id" >
          <input type="hidden" name="manner_id" id="manner_id" >
          
          <div class="modal-body">
                {{--  <div class="panel panel-default panel-fill">
                  <div class="panel-body" style=" max-height: 200px;overflow-x: auto;"> 

                  


                      <div class="about-info-p"> --}}
                            {{-- <strong>Pundit Assign</strong>
                                 <br> --}}
                                  <div class="form-group">
                                     <label for="FullName" style="margin-left: -123px;
    margin-top: 35px;">Pundit Assign</label>
                                  <select class="form-control rm06" name="pundit_id" id="pundit">

                                    <option value="">Select Pundit</option>
                                                              
                                  </select>
                                </div>
                               
                          {{-- </div>
                   </div>
                </div> --}}
         </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary waves-effect waves-light w-md" >Assign</button>
        </div>
        </form>
      </div>
    </div>
  </div>




  {{-- re-assign-pundit --}}
     <div class="modal res-modal" id="myModal_reassign">
    <div class="modal-dialog" style="width: 900px;">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Reassign Pundit</h4>
          <button type="button" class="close" data-dismiss="modal" onclick="location.reload()" style="margin-top: -34px;">&times;</button>
        </div>

          <div class="form-group">
                    <label for="FullName">Code</label>
                    <input type="text" placeholder="Code" class="form-control" id="re_code_seach" >
                  </div>
                  
                  <div class="form-group">
                    <label for="FullName">Name</label>
                    <input type="text" placeholder="Name" class="form-control" id="re_name_seach" >
                  </div>

                  <div class="form-group">
                    <label for="FullName">Address</label>
                    <input type="text" placeholder="Address" class="form-control" id="re_address_seach" >
                  </div>

                  <div class="form-group">
                    <label for="FullName">Phone Number</label>
                    <input type="text" placeholder="Phone Number" class="form-control" id="re_number_seach">
                  </div>

                  <div class="rm05 marl0">
                    <a class="btn btn-primary waves-effect waves-light w-md" id="re_assign_search">Search</a>
                  </div>
        
        <!-- Modal body -->
        <form id="reassignForm" method="post" action="{{route('admin.manage.puja.assign-pundit')}}">
          @csrf
          <input type="hidden" name="id" id="order_id" class="order_id">
          <input type="hidden" name="puja_id" id="re_puja_id" >
          <input type="hidden" name="zip_id" id="re_zip_id" >
          <input type="hidden" name="manner_id" id="re_manner_id" >
          <div class="modal-body">
                {{--  <div class="panel panel-default panel-fill">
                  <div class="panel-body" style=" max-height: 200px;overflow-x: auto;">  --}}
                      {{-- <div class="about-info-p"> --}}
                            {{-- <strong></strong> --}}
                                 <br>
                                  <div class="form-group">
                                    <label for="FullName" style="margin-left: -123px;
    margin-top: 25px;">Pundit Reassign</label>
                                  <select class="form-control rm06" name="pundit_id" id="repundit">
                                    <option value="">Select Pundit</option>
                                                              
                                  </select>
                                </div>
                               
                          {{-- </div> --}}
                   {{-- </div>
                </div> --}}
         </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary waves-effect waves-light w-md" >Assign</button>
        </div>
        </form>
      </div>
    </div>
  </div>





     <div class="modal res-modal" id="myModal_two">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Puja Link And Note</h4>
          <button type="button" class="close" data-dismiss="modal" onclick="location.reload()" style="margin-top: -34px;">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form id="linkForm" method="post" action="{{route('admin.manage.puja.order-assign-puja-link')}}">
          @csrf
          <input type="hidden" name="id" id="order_id_link">
          
          <div class="modal-body">
                 <div class="panel panel-default panel-fill">
                  <div class="panel-body" style=" max-height: 200px;overflow-x: auto;"> 
                      <div class="about-info-p">
                            <strong>Add Puja Link</strong>
                                 <br>
                                  <div class="form-group">
                                  <input type="text" name="link" class="form-control" placeholder="Place puja link">
                                </div>
                               
                          </div>

                          <div class="about-info-p">
                            <strong>Add Note</strong>
                                 <br>
                                  <div class="form-group">
                                  <textarea class="form-control" rows="5" name="note" placeholder="Add Note"></textarea>
                                </div>
                               
                          </div>
                   </div>
                </div>
         </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary waves-effect waves-light w-md" >Add</button>
        </div>
        </form>
      </div>
    </div>
  </div>
        
      </div>
      <!-- container --> 
      
    </div>
    <!-- content -->
    
    @include('admin.includes.footer')
  </div>
 @endsection

@section('script')
@include('admin.includes.script')

<script type="text/javascript">
      $(".rtg li a").click(function(){
      
      
      var url = $(this).attr('href');
      
      

      var vars = [], hash;
      var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
      for(var i = 0; i < hashes.length; i++)
      {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
      }
      // console.log(hash[1]);
      $('#page').val(hash[1]);
      $("#search_form").submit();
      return false;
    });
  @foreach (@$pujas as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
 </script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.add_puja_link').on('click',function(e){
       var order_id = $(this).data('id');
       $('#order_id_link').val(order_id);
      $("#myModal_two").modal("show");
    });
  });
</script>

 <script type="text/javascript">
  $(document).ready(function(){
    $('.assign_modal_click').on('click',function(e){
       // $('#name_seach').val();
       // $('#code_seach').val();
       // $('#address_seach').val();
       // $('#number_seach').val();
      var order_id = $(this).data('id');
      var puja_id = $(this).data('puja');
      var zip_id = $(this).data('zip');
      var manner = $(this).data('manner');
      $('#order_id').val(order_id);
      $('#puja_id').val(puja_id);
      $('#zip_id').val(zip_id);
      $('#manner_id').val(manner);

      // alert(zip_id);
      $.ajax({
        url:"{{route('admin.manage.puja.pundit-assign-list')}}",
        method:'GET',
        data:{order_id:order_id,puja_id:puja_id,zip_id:zip_id,manner:manner},
        success:function(data){
          console.log(data);

          $('#pundit').html(data.pundit);
          $("#myModal").modal("show");
          return false;
        }
      });
      
    })
  })
</script>

 <script type="text/javascript">
  $(document).ready(function(){
    $('.re_assign_modal_click').on('click',function(e){
      // $('#re_name_seach').val('');
      // $('#re_code_seach').val('');
      // $('#re_address_seach').val('');
      // $('#re_number_seach').val('');
      var order_id = $(this).data('id');
      var puja_id = $(this).data('puja');
      var zip_id = $(this).data('zip');
      var manner = $(this).data('manner');
      var re = 're'; 
      $('.order_id').val(order_id);
      $('#re_puja_id').val(puja_id);
      $('#re_zip_id').val(zip_id);
      $('#re_manner_id').val(manner);

      // alert(zip_id);
      $.ajax({
        url:"{{route('admin.manage.puja.pundit-assign-list')}}",
        method:'GET',
        data:{order_id:order_id,puja_id:puja_id,zip_id:zip_id,manner:manner,re:re},
        success:function(data){
          console.log(data);
          $('#repundit').html(data.pundit);
          $("#myModal_reassign").modal("show");
        }
      });
      
    })
  })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
       $("#assignForm").validate({
            rules: {
                pundit_id: {
                   required:true,
               },

          },
            
        messages: {
                pundit_id: {
                    required:'Please select a pundit',
             },  
           },

        });
    })
</script>

<script>
    $(document).ready(function(){
       $("#reassignForm").validate({
            rules: {
                pundit_id: {
                   required:true,
               },

          },
            
        messages: {
                pundit_id: {
                    required:'Please select a pundit',
             },  
           },

        });
    })
</script>

<script>
    $(document).ready(function(){
       $("#linkForm").validate({
            rules: {
                link: {
                   required:true,
               },
               note:{
                required:true,
               },

          },
            
        messages: {
                link: {
                    required:'Please add puja link',
             },  
             note:{
              required:'Please add note for the puja',
             }
           },

        });
    })
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#assigned').on('change',function(event){
      var value = $('#assigned').val();
      if (value=='Y') {
        $('#pundit_list').css('display','block');
      }else{
        $('#pundit_list').css('display','none');
      }
    })
  });
</script>



<script>
    $( function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker1" ).datepicker();
    });
      $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy',
        onClose: function (selectedDate, inst) {
            console.log(selectedDate, Date.parse(selectedDate));
            let minDate = new Date(selectedDate);
            minDate.setDate(minDate.getDate());
            var selectedDate = $('#datepicker').datepicker('getDate');
            selectedDate.setDate(selectedDate.getDate()+1);
            $("#datepicker1").datepicker("option", "minDate", selectedDate);
            $('#datepicker1').datepicker('show');
        }
    });
    $("#datepicker1").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy',
        onClose: function (selectedDate, inst) {
            var selectedDate = $('#datepicker1').datepicker('getDate');
            if(selectedDate==''|| selectedDate==null || selectedDate==undefined){
            }else{
                selectedDate.setDate(selectedDate.getDate()-1);
                $("#datepicker").datepicker("option", "maxDate", selectedDate);
            }
        }
    });
</script>
<script type="text/javascript">

$(document).ready(function(){
        $(".search_filter").validate({
            rules: {
                to_date:{
                    required: function(){
                        var from_date = $('#datepicker').val();
                        if(from_date !=''){
                            return true
                        }else{
                            return false
                        }
                    },
                },
                from_date:{
                    required:function(){
                        var to_date = $('#datepicker1').val();
                        if(to_date !=''){
                            return true
                        }else{
                            return false
                        }
                    },
                },
            },
            messages: {
                to_date:{
                    required: 'To Date Enter',
                },
                from_date:{
                    required: 'From Date Enter',
                },
            },
        });
    });


</script>

<script type="text/javascript">
  $('#assign_search').on('click',function(event){
    var name_seach = $('#name_seach').val();
    var code_seach = $('#code_seach').val();
    var address_seach = $('#address_seach').val();
    var number_seach = $('#number_seach').val();
    var order_id = $('#order_id').val();
    var puja_id =  $('#puja_id').val();
    var zip_id = $('#zip_id').val();
    var manner = $('#manner_id').val();
    // var order_id = $('.order_id').val();
    // alert(manner);
    $.ajax({
        url:"{{route('admin.manage.puja.pundit-assign-list')}}",
        method:'GET',
        data:{name_seach:name_seach,order_id:order_id,puja_id:puja_id,zip_id:zip_id,manner:manner,code_seach:code_seach,address_seach:address_seach,number_seach:number_seach},
        success:function(data){
          console.log(data);
          $('#pundit').html(data.pundit);
      }
    });
  })
</script>


<script type="text/javascript">
  $('#re_assign_search').on('click',function(event){
   
    var name_seach = $('#re_name_seach').val();
    var code_seach = $('#re_code_seach').val();
    var address_seach = $('#re_address_seach').val();
    var number_seach = $('#re_number_seach').val();
    var order_id = $('.order_id').val();
    var puja_id =  $('#re_puja_id').val();
    var zip_id = $('#re_zip_id').val();
    var manner = $('#re_manner_id').val();
    // alert(order_id);
    var re = 're'; 
    $.ajax({
        url:"{{route('admin.manage.puja.pundit-assign-list')}}",
        method:'GET',
        data:{name_seach:name_seach,order_id:order_id,puja_id:puja_id,zip_id:zip_id,manner:manner,code_seach:code_seach,address_seach:address_seach,number_seach:number_seach,re:re},
        success:function(data){
          console.log(data);
          $('#repundit').html(data.pundit);
      }
    });
  })
</script>
@endsection