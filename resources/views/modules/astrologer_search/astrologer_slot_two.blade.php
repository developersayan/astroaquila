@if(count(@$uniq)>0)


@foreach(@$uniq as $key=> $value)

<li>
<input id="slot_{{$value}}" type="checkbox" class="slot_class schedule_class"  value="{{date('H:i:s',strtotime(@$value))}}" name="slot_name[]" data-id = "{{date('H:i:s',strtotime(@$value))}}">
<label for="slot_{{$value}}">{{date('H:i',strtotime(@$value))}}</label>
</li>
@endforeach
@else
<p>All Slots Are Booked In This Date</p>
@endif
{{-- <script type="text/javascript">


	$(document).ready(function(){
$('[name="slot_name[]"]').on('click',function(event){
     var allRadios = $('[name="slot_name[]"]:checked').length;
     var call = '{{$user->call_price}}';
     var price = allRadios*call;
     alert(price);

});
});
</script> --}}