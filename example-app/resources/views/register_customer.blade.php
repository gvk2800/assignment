@extends('master')
@section('content')
<h1>Register a Customer Form</h1>

<form id="myform">
    @csrf
  <div class="mb-3">
    <label for="fname" class="form-label">First Name</label>
    <input type="text" class="form-control" id="fname"name="fname" >
    <span style="color:red;"class="fname_err"></span>
  </div>
  <div class="mb-3">
    <label for="lname" class="form-label">Last Name</label>
    <input type="text" class="form-control" id="lname"name="lname" >
  </div>
  <div class="mb-3">
    <label for="mobile" class="form-label">Mobile Number</label>
    <input type="number" class="form-control" id="mobile"name="mobile" >
    <span style="color:red;" class="mobile_err"></span>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email"aria-describedby="emailHelp">
    <span style="color:red;" class="email_err"></span>
    <div  class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="pass"name="pass">
    <span style="color:red;" class="pass_err"></span>
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
            var pass=$("#pass").val();
            var email=$("#email").val();
            $.ajax({
                url:"{{route('customer.store')}}",
                type:"POST",
                data:{_token:_token,email:email,pass:pass,fname:fname,lname:lname,mobile:mobile},
                dataType:'json',
                success:function(data){
                    console.log(data);
                    if($.isEmptyObject(data))
                    {
                        alert(data.success);
                        $('.fname_err').text('');
                        $('.mobile_err').text('');
                        $('.email_err').text('');
                        $('.pass_err').text('');
                    }
                    else
                    {
                        printErrorMsg(data.error);
                    }
                    window.location.replace('/login');
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