@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
 @php
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $showOtherRegisterMethod = getFeaturesSettings('show_other_register_method') ?? false;
        $showCertificateAdditionalInRegister = getFeaturesSettings('show_certificate_additional_in_register') ?? false;
    @endphp
   <div class="container">
        <div class="row login-container">
            <div class="col-12 col-md-6 pl-0">
                <img src="/store/1/default_images/instructor_finder_wizard.jpg" class="img-cover" alt="Login">
            </div>
            <div class="col-12 col-md-6">
                <div class="login-card">
                    <h1 class="font-20 font-weight-bold">One more step for your abajim account</h1>

                    <form  action="{{route('saveUserInfo')}}" method="post"  class="mt-35">   
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="input-label" for="city">City :</label>
                                  <select class="form-control select2"  name="city" id="cityschool"   class="form-control select2"> {{-- class="cityschool" --}}             
                                       <option >Select City School</option>
                                       @foreach($cities as $cit)
                                         <option value="{{$cit->title}}">{{$cit->title}}</option>
                                       @endforeach
                                   </select>
                         
                            @error('city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="school">School:</label>
                                  <select class="form-control select2"   name="type"   class="form-control select2"> {{-- class="cityschool" --}}             
                                      <option value="type" >Select type school</option>
                                      <option value="Secondaire" >Secondaire</option>
                                   </select>
                                
                         
                            @error('school')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="school">Name school:</label> 
                                  <select class="form-control select2" name="name" id="nameschool"   class="form-control select2"> {{-- class="cityschool" --}}             
                                         <option value="0" disabled="true" selected="true">Select name school</option>

                                   </select>
               
                            @error('school')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="level">Niveau School :</label>
                                  <select class="form-control select2"  name="name_level" id="levelschool"   class="form-control select2"> {{-- class="cityschool" --}}             
                                        <option value="name" >Select level school</option>
                                      @foreach ($level as $lev)
                                           <option value="{{ $lev->id }}" >{{ $lev->name }}</option>
                                      @endforeach
                                   </select>
                                
                         
                            @error('level')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="section">Section school:</label> 
                                  <select  class="form-control select2"   name="name_section" id="sectionschool"   class="form-control select2"> {{-- class="cityschool" --}}             
                                       <option value="" disabled="true" selected="true">Select section</option>
                                   </select>
                   
               
                            @error('section')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                         <div class="form-group">
                            <label class="input-label" for="section">Option school:</label> 
                                  <select class="form-control select2" name="name_option" id="optionschool"   class="form-control select2"> {{-- class="cityschool" --}}             
                                       <option value="0" disabled="true" selected="true">Select option school</option>
                                   </select>
                   
               
                            @error('section')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                 
                        <button type="submit"
                                class="btn btn-primary btn-block mt-20">Complete Profile Information</button>
                    </form>

                    

                </div>
            </div>
        </div>
    </div>
 

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script type="text/javascript">
$(document).ready(function(){


///city-name////
$(document).on('change','#cityschool',function(){

   var city_id=$(this).val();
   console.log(city_id);
   var div=$(this).parents();
   var op=" ";
   
   $.ajax({
     type:'get',
     url:'{!!URL::to('findSchoolName')!!}',
     data:{'city':city_id},
     success:function(data){
      //console.log('success');
       console.log(data);
       //console.log(data.length);
      op+='<option value="0" selected disabled>Select Name school</option>';
      for(var i=0;i<data.length;i++){
        console.log(data[i].name);
      op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
      }
      div.find('#nameschool').html(" ");
      div.find('#nameschool').append(op);

     },
     error:function(){

     },



    });

});

 ///level-section////


$(document).on('change','#levelschool',function(){

var level_id=$(this).val();
console.log(level_id);
var div=$(this).parents();
var op=" ";

$.ajax({
  type:'get',
  url:'{!!URL::to('findSchoolSection')!!}',
  data:{'level_id':level_id},
  success:function(data){
   //console.log('success');
    console.log(data);
    //console.log(data.length);
   op+='<option value="0" selected disabled>Select Section</option>';
   
   for(var i=0;i<data.length;i++){
     console.log(data[i].name);
   op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
  
   }
   div.find('#sectionschool').html(" ");
   div.find('#sectionschool').append(op);
   
   
  },
  error:function(){

  },
});

});
///level-option
$(document).on('change','#levelschool',function(){

var level_id=$(this).val();
console.log(level_id);
var div=$(this).parents();
var op=" ";

$.ajax({
  type:'get',
  url:'{!!URL::to('findSchoolOption')!!}',
  data:{'level_id':level_id},
  success:function(data){
   //console.log('success');
    console.log("option :"+data);
    //console.log(data.length);
   op+='<option value="0" selected disabled>Select Option</option>';
   
   for(var i=0;i<data.length;i++){
     console.log(data[i].name);
   op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
  
   }
   div.find('#optionschool').html(" ");
   div.find('#optionschool').append(op);
   
   
  },
  error:function(){

  },
});

});





});
</script>
@endpush


