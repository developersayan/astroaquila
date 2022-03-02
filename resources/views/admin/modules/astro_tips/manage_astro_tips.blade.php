@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Astro Tips</title>
@endsection

@section('style')
@include('admin.includes.style')
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.sidebar')
  <div class="content-page">
    <!-- Start content -->
    <div class="content">
      <div class="container">

        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <h4 class="pull-left page-title">Manage Astro Tips</h4>
            <ol class="breadcrumb pull-right">
                <li class="active"><a href="{{route('admin.add.astro.tips')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add </a></li>
              <li class="active"><a href="{{route('admin.settings.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading rm02 rm04">
                <form role="form" action="{{route('admin.manage.astrologer.search')}}" method="post" id="search_form">
                @csrf
                <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                    <label for="FullName">Keyword</label>
                    <input type="text" placeholder="Keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>
                  <div class="clearfix"></div>
                  <div class="rm05">
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
                            <th>Heading</th>
                            <th> Description</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$tips->isNotEmpty())
                        @foreach(@$tips as $tip)
                          <tr>
                            <td>{{@$tip->heading}}</td>
                            <td>{{@$tip->description}}</td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{@$tip->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                            <div class="show-actions" id="show-{{@$tip->id}}" style="display: none;">
                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                  <li><a href="{{route('admin.edit.astro.tips',['id'=>@$tip->id])}}">Edit</a></li>
                                  <li><a href="{{route('admin.delete.astro.tips',['id'=>$tip->id])}}" onclick="return confirm('Do you want to delete this tip?')">Delete</a></li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                          @else
                         <tr>
                         <td colspan="3">
                          <center> No Data found</center>
                         </td>
                         </tr>
                      @endif


                        </tbody>
                      </table>
                    </div>


                    <ul class="pagination rtg">
                        {{@$tips->links()}}
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
	  @foreach (@$tips as $tip)

        $("#action{{$tip->id}}").click(function(){
            $('.show-actions:not(#show-{{$tip->id}})').slideUp();
            $("#show-{{$tip->id}}").slideToggle();
        });
    @endforeach
</script>
@endsection
