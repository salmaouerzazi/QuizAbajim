@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/vendors/leaflet/leaflet.css">
@endpush

@section('content')
<style>

input[type="file"] {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
}
input[type="submit"]:hover {
    background-color: #45a049;
}

</style>
<style>
    .upload-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .file-upload-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        border: 2px dashed #ccc;
        border-radius: 10px;
    }

    .file-upload-wrapper1 {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 700px;
        height: 120px;
        border: 2px dashed #ccc;
        border-radius: 10px;
    }
    .file-upload-wrapper2 {
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 700px;
        height: 420px;
        border: 2px dashed #555;
        border-radius: 10px;
    }
    .file-upload-wrapper:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .file-upload-button {
        display: none;
    }

    .upload-icon {
        font-size: 24px;
        /* Adjust size as needed */
        color: #555;
    }

    /* Add additional styles for your uploaded images */
    .uploaded-images img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>
    <section class="section">
        <div class="section-header">
            <h1>Add For any countries all Level and All Manul Scolaire</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">Add For any countries all Level and All Manul Scolaire</div>
            </div>
        </div>

        <div class="section-body">
            <section class="card">
                <div class="card-body">
                    <form action="{{ !empty($region) ? getAdminPanelUrl("/regions/{$region->id}/update") : getAdminPanelUrl("/regions/store") }}" method="post">
                        {{ csrf_field() }}

                        <input type="hidden" name="type" value="{{ !empty($region) ? $region->type : request()->get('type', \App\Models\Region::$country) }}">

                        <div class="row">
                            <div class="col-12 col-lg-6">

                                <div id="countrySelectBox" class="form-group {{ !empty($countries) ? '' : 'd-none' }}">
                                    <label class="input-label">{{ trans('update.countries') }}</label>
                                    <select name="country_id" class="form-control search-region-select2 @error('country_id') is-invalid @enderror" data-type="{{ \App\Models\Region::$country }}" data-placeholder="{{ trans('admin/main.search') }} {{ trans('update.countries') }}">

                                        @if(!empty($countries))
                                            <option value="">{{ trans('admin/main.select') }} {{ trans('update.country') }}</option>

                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" data-center="{{ implode(',', $country->geo_center) }}" {{ ((!empty($region) and $region->country_id == $country->id) or old('country_id') == $country->id) ? 'selected' : '' }}>{{ $country->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('country_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div id="provinceSelectBox" class="form-group {{ ((!empty($region) and ($region->type == \App\Models\Region::$city or $region->type == \App\Models\Region::$district)) or (!empty(request()->get('type')) and (request()->get('type') == \App\Models\Region::$city or request()->get('type') == \App\Models\Region::$district))) ? '' : 'd-none'}}">
                                    <label class="input-label">{{ trans('update.provinces') }}</label>

                                    <select name="province_id" {{ empty($provinces) ? 'disabled' : '' }} class="form-control @error('province_id') is-invalid @enderror">
                                        <option value="">{{ trans('admin/main.select') }} {{ trans('update.province') }}</option>

                                        @if(!empty($provinces))
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}" data-center="{{ implode(',', $province->geo_center) }}" {{ ((!empty($region) and $region->province_id == $province->id) or old('province_id') == $province->id) ? 'selected' : '' }}>{{ $province->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @error('province_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div id="citySelectBox" class="form-group {{ ((!empty($region) and $region->type == \App\Models\Region::$district) or (!empty(request()->get('type')) and request()->get('type') == \App\Models\Region::$district)) ? '' : 'd-none'}}">
                                    <label class="input-label">{{ trans('update.city') }}</label>

                                    <select name="city_id" {{ empty($cities) ? 'disabled' : '' }} class="form-control @error('city_id') is-invalid @enderror">
                                        <option value="">{{ trans('admin/main.select') }} {{ trans('update.city') }}</option>

                                        @if(!empty($cities))
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" data-center="{{ implode(',', $city->geo_center) }}" {{ ((!empty($region) and $region->city_id == $city->id) or old('city_id') == $city->id) ? 'selected' : '' }}>{{ $city->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @error('city_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="" class="input-label">{{ trans('admin/main.title') }}</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($region) ? $region->title : '' }}" placeholder="{{ trans('admin/main.title') }}">
                                    @error('title')
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
                        <div class="upload-container">
                                <!-- Placeholder for uploaded images -->
                                <div class="uploaded-images">
                                    <!-- Dynamically populate with uploaded images -->
                                    <img src="https://assets.lls.fr/books/978-2-37760-147-9-MA2_P_2019.png" width="140">
                                    <img src="https://www.editions-hatier.fr/sites/default/files/couvertures/couverture_7512835.jpg" width="140">
                                    <img src="https://revision.ci/assets/uploads/anals/882bb-mon-livre-de-mathematiques-2ndc.png" width="140">

                                    <img src="https://images.epagine.fr/778/9782013954778_1_75.jpg" width="140">

                                    <!-- Add more <img> tags for each uploaded image -->
                                </div>

                                <!-- Upload button with "+" icon -->
                                <label class="file-upload-wrapper" for="file-upload">
                                    <i class="upload-icon">+ </i>
                                </label>
                                <input id="file-upload" class="file-upload-button" type="file" name="files[]" multiple hidden>
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
                        <div class="upload-container">
                                <!-- Placeholder for uploaded images -->
                                <div class="uploaded-images">
                                    <!-- Dynamically populate with uploaded images -->
                                    <img src="https://fr.shopping.rakuten.com/photo/2268346175_ML_NOPAD.jpg" width="140">
                                    <img src="https://fr.shopping.rakuten.com/photo/2334557014_ML_NOPAD.jpg" width="140">
                                    <img src="https://assets.lls.fr/books/978-2-37760-160-8-ESP2_P_2019.png" width="140">

                                    <img src="https://www.editions-delagrave.fr/sites/default/files/produits/images/couvertures/9782206401782-g.jpg" width="140">

                                    <!-- Add more <img> tags for each uploaded image -->
                                </div>

                                <!-- Upload button with "+" icon -->
                                <label class="file-upload-wrapper" for="file-upload">
                                    <i class="upload-icon">+ </i>
                                </label>
                                <input id="file-upload" class="file-upload-button" type="file" name="files[]" multiple hidden>
                            </div> 
                           
                          

                               </label>



                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <input type="hidden" id="LocationLatitude" name="latitude" value="{{ $latitude }}">
                                    <input type="hidden" id="LocationLongitude" name="longitude" value="{{ $longitude }}">

                                    <label class="input-label">{{ trans('update.select_location') }}</label>
                                  

                                    <div style="height: 300px;" class="region-map mt-2" id="mapBox"
                                         data-latitude="{{ $latitude }}"
                                         data-longitude="{{ $longitude }}"
                                         data-zoom="{{ (!empty($region) and $region->type !== \App\Models\Region::$country and $region->type !== \App\Models\Region::$province and !empty($region->geo_center)) ? 12 : 5 }}"
                                    >
                                        <img src="/assets/default/img/location.png" class="marker">
                                    </div>
                                </div>
                              

                                
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-4">{{ trans('admin/main.save') }}</button>
                    </form>
                </div>
            </section>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/vendors/leaflet/leaflet.min.js"></script>

    <script>
        var selectProvinceLang = '{{ trans('update.select_province') }}';
        var selectCityLang = '{{ trans('update.select_city') }}';
        var leafletApiPath = '{{ getLeafletApiPath() }}';
    </script>
    <script src="/assets/default/js/admin/regions_create.min.js"></script>
    <script type="text/javascript">
$(document).ready(function(){


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
