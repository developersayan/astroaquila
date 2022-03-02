@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage City</title>
@endsection

@section('style')
@include('admin.includes.style')
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
                    <h4 class="pull-left page-title">Manage City</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.city.add-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add City</a></li>
                        <li class="active" id="excel_click"><a href="{{route('admin.manage.excel.upload')}}"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Add Excel</a></li>
                        <li class="active"><a href="{{route('admin.settings.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <form role="form" action="{{route('admin.manage.city')}}" method="post" id="search_form">
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Country</label>
                                    <select class="form-control rm06 basic-select" name="country" id="country_id">
                                        <option value="">Select Country</option>
                                        @foreach(@$countris as $country)
                                        <option value="{{@$country->id}}" @if(request('country')==$country->id) selected @endif>{{@$country->name}}</option>
                                        @endforeach
                                     </select>
                                </div>

                                <div class="form-group">
                                    <label for="FullName">State</label>
                                    <select class="form-control rm06 basic-select" name="state" id="state_id">
                                      <option value="">Select State</option>
                                        @if(@$state)
                                         @foreach(@$state as $val)
                                                 <option value="{{@$val->id}}" @if(request('state')==@$val->id) selected @endif>{{@$val->name}}</option>
                                                 @endforeach
                                                  @else
                                              
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="FullName">City Name</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('name')}}" name="name" placeholder="City Name">
                                </div>
                                
                                <div class="rm05">
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">Search</button>
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
                                                    <th>Country Name</th>
                                                    <th>State Name</th>
                                                    <th> City Name</th>
                                                   <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($city->isNotEmpty())
                                                @foreach(@$city as $value)
                                                <tr>
                                                    <td>{{@$value->countrylist->name}}</td>
                                                    <td>{{@$value->statelist->name}}</td>
                                                    <td>{{@$value->name}}</td>
                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle_state"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="{{route('admin.manage.city.edit-view',['id'=>$value->id])}}">Edit </a></li>
                                                                <li><a href="{{route('admin.manage.city.delete',['id'=>$value->id])}}" onclick="return confirm('Do you want to delete this city?')">Delete</a></li>
                                                             </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                
                                                <tr><td colspan="4"><center> No Data </center></td></tr>
                                               @endif
                                            </tbody>
                                        </table>
                                    </div>


                                    <ul class="pagination rtg">
                                        {{@$city->links()}}
                                    </ul>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->

    @include('admin.includes.footer')

        <div class="modal" tabindex="-1" role="dialog" id="excel_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Upload Excel File</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4>Instruction</h4>
            <p>1. Select Coutry and State</p>
            <p>2. Upload Excel File Of City</p>
            <p>3. The excel file must match exactly like the demo excel file. </p>
            <p><a href="{{url('public/admin/assets/city.xlsx')}}" download><i class="fa fa-file-excel-o" aria-hidden="true"></i> Download Demo Excel File</a></p>
            <div class="modal-body">
                <form action="{{route('admin.manage.city.export')}}" method="post" enctype="multipart/form-data" id="excel_form">
                    @csrf
                
                <div class="form-group">
                             <label for="FullName">Country</label>
                                               <select class="form-control rm06 basic-select "  name="country" id="country"  style="width: 100%;">
                                                  <option value="">Select Country</option>
                                                  @foreach(@$countris as $value)
                                                  <option value="{{@$value->id}}" @if(request('country')==@$value->id) selected @endif>{{@$value->name}}</option>
                                                  @endforeach
                                               </select>
                                               <div id="error_country"></div>
                 </div>


                 <div class="form-group">
                             <label for="FullName">State</label>
                                               <select class="form-control rm06 basic-select "  name="state" id="state"  style="width: 100%;">
                                                  <option value="">Select State</option>
                                               </select>
                                               <div id="error_state"></div>
                 </div>


                 


                <div class="row">
                    <div class="col-12">
                        <div class="main-center-div">
                        <div class="login-from-area">
                         <div class="uplodimgfil">
                                                  <input type="file"  id="file-2" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"  
                                                   name="excel" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                                  <label for="file-2">Upload Excel<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                  
                                                </div>
                                                <div id="error_excel"></div>
                        <div class="form-group">
                            <input type="submit" name="" value="Submit" class="btn btn-success" style="width: 25%;">
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('script')
@include('admin.includes.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
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
  @foreach (@$city as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach

  // $('#excel_click').on('click',function(e){
  //       $("#excel_modal").modal("show");
  // })

});
</script>


<script>
    $(document).ready(function(){
       $("#excel_form").validate({
            rules: {
                excel: {
                   required:true,
            },
            country:{
                required:true,
            },
            state:{
                required:true,
            },
          },
        ignore: [],   
        messages: {
                excel: {
                    required:'Please upload excel file',
            },  
            country:{
                required:'Please select country',
            },
            state:{
                required:'Please select state',
            },

        },
        errorPlacement: function(error, element) {
            console.log("Error placement called");
            if (element.attr("name") == "excel") {
               
                $("#error_excel").append(error);
            }
            if (element.attr("name") == "country") {
               
                $("#error_country").append(error);
            }
            if (element.attr("name") == "state") {
               
                $("#error_state").append(error);
            }
        },
        });
    })
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $('#country').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('admin.manage.city.get-state')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#state').html(data.state);
          
        }
      })
    })
  })
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#country_id').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('admin.manage.city.get-state')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#state_id').html(data.state);
          
        }
      })
    })
  })
</script>
@endsection
