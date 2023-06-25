@extends('master')
@section('content')
<h1>Edit Customer Details</h1>

<form id="myform">
    @csrf
  <input type="hidden"id="idd" name="idd"value="{{$data->id}}">
  <div class="mb-3">
    <label for="fname" class="form-label">First Name</label>
    <input type="text" class="form-control" id="fname"name="fname" value="{{$data->first_name}}">
    <span style="color:red;"class="fname_err"></span>
  </div>
  <div class="mb-3">
    <label for="lname" class="form-label">Last Name</label>
    <input type="text" class="form-control" id="lname"name="lname" value="{{$data->last_name}}">
  </div>
  <div class="mb-3">
    <label for="mobile" class="form-label">Mobile Number</label>
    <input type="number" class="form-control" id="mobile"name="mobile" value="{{$data->mobile}}">
    <span style="color:red;" class="mobile_err"></span>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email"aria-describedby="emailHelp"value="{{$data->email}}">
    <span style="color:red;" class="email_err"></span>
    <div  class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<style>
    *{
        margin: 15px;
    }
    
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    
    $(document).ready(function(){
        $("#myform").submit(function(e){
            e.preventDefault();
            // debugger
            var _token= "{{csrf_token()}}";
            var fname=$("#fname").val();
            var lname=$("#lname").val();
            var mobile=$("#mobile").val();
            var email=$("#email").val();
            var idd=$("#idd").val();
            $.ajax({
                url:"{{route('c.update')}}",
                type:"POST",
                data:{_token:_token,idd:idd,email:email,fname:fname,lname:lname,mobile:mobile},
                dataType:'json',
                success:function(data){
                    console.log(data);
                    if($.isEmptyObject(data))
                    {
                        alert(data.success);
                        $('.fname_err').text('');
                        $('.mobile_err').text('');
                        $('.email_err').text('');
                    }
                    else
                    {
                        printErrorMsg(data.error);
                    }
                    window.location.replace('/all_customer');
                },
                error:function(data)
                {
                    console.log(data);
                }
            });
        });
        function printErrorMsg(msg)
        {
            $.each(msg,function(key,value)
            {
                console.log(key);
                $('.'+key+'_err').text(value);
            })
        }
    });
    
</script>
@endsection