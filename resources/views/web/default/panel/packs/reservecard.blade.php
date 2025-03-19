@extends(getTemplate().'.layouts.app')
<style>
.cover.atvImg {
    margin-left: 25%; /* Default margin for larger screens */
    margin-top: 30px;
    margin-bottom: 39px;
}
.ss {
    font-size: 3.3rem;
    margin-left: 28% !important;
}

/* Responsive styles for screens between 1900px and 700px */
@media (max-width: 1900px) and (min-width: 700px) {
    .cover.atvImg {
        margin-left: 25%; /* Same margin for this range */
        margin-top: 30px;
        margin-bottom: 39px;
    }
}

/* Responsive styles for screens smaller than 512px (mobile) */
@media (max-width: 512px) {
    .cover.atvImg {
        margin-left: 10%; /* Adjust margin for mobile */
        margin-top: 30px;
        margin-bottom: 39px;
    }
    .ss {
    font-size: 1.3rem;
    margin-left: 28% !important;
}
}
</style>
@section('content')

           <div class="container ">
                <h1 class="text mb-15 ss" >أحصل على بطاقة</h1>
                <p>تمكنك بطاقة الشحن من تفعيل اشتراك سنوي في شبكة أبجيم من أجل التمتع بالكتب المدرسية التفاعلية مع خاصية مقاطع الفيديو التفسيرية و الدروس الاضافية, بعد إتمام تعبئة بياناتك، ستصلك البطاقة على عنوانك في غضون 48 ساعة. تحتوي البطاقة على رمز سري يمنحك إمكانية تفعيل الاشتراك بكل سهولة.
                </p>
                <div class="cover atvImg mgg" >
                    <div class="atvImg-layer" data-img="/abajimcard1.png"></div>
                </div>
            </div>


            <div class="container">
                <div class="section-body card">
                <div class="modal-body">
                            
                            <form action="{{ route('webcard_reservations.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    
                                   
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="name" class="text-color-primary">{{trans('panel.parent_name')}}</label>
                                        <input type="text" name="name" id="name" class="form-control" value="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="phone_number" class="text-color-primary">{{trans('panel.phone_number')}}</label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control" value="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="child_level" class="text-color-primary">{{trans('panel.child_level')}}</label>
                                        <select name="level_id"  class="form-control">
                                            <option >select level</option>
                                            @foreach ($levels as $lv)
                                                <option value="{{$lv->id}}">{{$lv->name}}</option>
                                            @endforeach
                                            
                                            </select>

                                        
                                    </div>
                                     <div class="form-group mb-3 col-md-6">
                                        <label for="city">اختر المدينة:</label>
                                        <select name="city" id="city" class="form-control" required>
                                            <option value="" disabled selected>اختر المدينة</option>
                                            <option value="تونس">تونس</option>
                                            <option value="صفاقس">صفاقس</option>
                                            <option value="سوسة">سوسة</option>
                                            <option value="التضامن">التضامن</option>
                                            <option value="القيروان">القيروان</option>
                                            <option value="قابس">قابس</option>
                                            <option value="بنزرت">بنزرت</option>
                                            <option value="أريانة">أريانة</option>
                                            <option value="قفصة">قفصة</option>
                                            <option value="المنستير">المنستير</option>
                                            <option value="مدنين">مدنين</option>
                                            <option value="نابل">نابل</option>
                                            <option value="القصرين">القصرين</option>
                                            <option value="بن عروس">بن عروس</option>
                                            <option value="المهدية">المهدية</option>
                                            <option value="سيدي بوزيد">سيدي بوزيد</option>
                                            <option value="جندوبة">جندوبة</option>
                                            <option value="قبلي">قبلي</option>
                                            <option value="توزر">توزر</option>
                                            <option value="سليانة">سليانة</option>
                                            <option value="باجة">باجة</option>
                                            <option value="زغوان">زغوان</option>
                                            <option value="منوبة">منوبة</option>
                                        </select>
                                    </div>
                                     <div class="form-group mb-3 col-md-12">
                                        <label for="address" class="text-color-primary">{{trans('panel.address')}}</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="{{trans('panel.enter_address')}}">
                                    </div>
                                    
                                    <input type="hidden" name="user_id" id="user_id" class="form-control" value="1">
                                   
                                    <input type="hidden" name="enfant_id" id="enfant_id" class="form-control" value="1">
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary align-self-end"> حجز البطاقة</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>


    <script>
    function atvImg(){
        var d = document,
            de = d.documentElement,
            bd = d.getElementsByTagName('body')[0],
            htm = d.getElementsByTagName('html')[0],
            win = window,
            imgs = d.querySelectorAll('.atvImg'),
            totalImgs = imgs.length,
            supportsTouch = 'ontouchstart' in win || navigator.msMaxTouchPoints;

        if(totalImgs <= 0){
            return;
        }

        for(var l=0;l<totalImgs;l++){

            var thisImg = imgs[l],
                layerElems = thisImg.querySelectorAll('.atvImg-layer'),
                totalLayerElems = layerElems.length;

            if(totalLayerElems <= 0){
                continue;
            }

            while(thisImg.firstChild) {
                thisImg.removeChild(thisImg.firstChild);
            }
        
            var containerHTML = d.createElement('div'),
                shineHTML = d.createElement('div'),
                shadowHTML = d.createElement('div'),
                layersHTML = d.createElement('div'),
                layers = [];

            thisImg.id = 'atvImg__'+l;
            containerHTML.className = 'atvImg-container';
            shineHTML.className = 'atvImg-shine';
            shadowHTML.className = 'atvImg-shadow';
            layersHTML.className = 'atvImg-layers';

            for(var i=0;i<totalLayerElems;i++){
                var layer = d.createElement('div'),
                    imgSrc = layerElems[i].getAttribute('data-img');

                layer.className = 'atvImg-rendered-layer';
                layer.setAttribute('data-layer',i);
                layer.style.backgroundImage = 'url('+imgSrc+')';
                layersHTML.appendChild(layer);

                layers.push(layer);
            }

            containerHTML.appendChild(shadowHTML);
            containerHTML.appendChild(layersHTML);
            containerHTML.appendChild(shineHTML);
            thisImg.appendChild(containerHTML);

            var w = thisImg.clientWidth || thisImg.offsetWidth || thisImg.scrollWidth;
            thisImg.style.transform = 'perspective('+ w*3 +'px)';

            if(supportsTouch){
                win.preventScroll = false;

                (function(_thisImg,_layers,_totalLayers,_shine) {
                    thisImg.addEventListener('touchmove', function(e){
                        if (win.preventScroll){
                            e.preventDefault();
                        }
                        processMovement(e,true,_thisImg,_layers,_totalLayers,_shine);		
                    });
                    thisImg.addEventListener('touchstart', function(e){
                        win.preventScroll = true;
                        processEnter(e,_thisImg);		
                    });
                    thisImg.addEventListener('touchend', function(e){
                        win.preventScroll = false;
                        processExit(e,_thisImg,_layers,_totalLayers,_shine);		
                    });
                })(thisImg,layers,totalLayerElems,shineHTML);
            } else {
                (function(_thisImg,_layers,_totalLayers,_shine) {
                    thisImg.addEventListener('mousemove', function(e){
                        processMovement(e,false,_thisImg,_layers,_totalLayers,_shine);		
                    });
                    thisImg.addEventListener('mouseenter', function(e){
                        processEnter(e,_thisImg);		
                    });
                    thisImg.addEventListener('mouseleave', function(e){
                        processExit(e,_thisImg,_layers,_totalLayers,_shine);		
                    });
                })(thisImg,layers,totalLayerElems,shineHTML);
            }
        }

        function processMovement(e, touchEnabled, elem, layers, totalLayers, shine){

            var bdst = bd.scrollTop || htm.scrollTop,
                bdsl = bd.scrollLeft,
                pageX = (touchEnabled)? e.touches[0].pageX : e.pageX,
                pageY = (touchEnabled)? e.touches[0].pageY : e.pageY,
                offsets = elem.getBoundingClientRect(),
                w = elem.clientWidth || elem.offsetWidth || elem.scrollWidth,
                h = elem.clientHeight || elem.offsetHeight || elem.scrollHeight,
                wMultiple = 320/w,
                offsetX = 0.52 - (pageX - offsets.left - bdsl)/w,
                offsetY = 0.52 - (pageY - offsets.top - bdst)/h,
                dy = (pageY - offsets.top - bdst) - h / 2,
                dx = (pageX - offsets.left - bdsl) - w / 2,
                yRotate = (offsetX - dx)*(0.07 * wMultiple),
                xRotate = (dy - offsetY)*(0.1 * wMultiple),
                imgCSS = 'rotateX(' + xRotate + 'deg) rotateY(' + yRotate + 'deg)',
                arad = Math.atan2(dy, dx),
                angle = arad * 180 / Math.PI - 90;

            if (angle < 0) {
                angle = angle + 360;
            }

            if(elem.firstChild.className.indexOf(' over') != -1){
                imgCSS += ' scale3d(1.07,1.07,1.07)';
            }
            elem.firstChild.style.transform = imgCSS;
            
            shine.style.background = 'linear-gradient(' + angle + 'deg, rgba(255,255,255,' + (pageY - offsets.top - bdst)/h * 0.4 + ') 0%,rgba(255,255,255,0) 80%)';
            shine.style.transform = 'translateX(' + (offsetX * totalLayers) - 0.1 + 'px) translateY(' + (offsetY * totalLayers) - 0.1 + 'px)';	

            var revNum = totalLayers;
            for(var ly=0;ly<totalLayers;ly++){
                layers[ly].style.transform = 'translateX(' + (offsetX * revNum) * ((ly * 2.5) / wMultiple) + 'px) translateY(' + (offsetY * totalLayers) * ((ly * 2.5) / wMultiple) + 'px)';
                revNum--;
            }
        }

        function processEnter(e, elem){
            elem.firstChild.className += ' over';
        }

        function processExit(e, elem, layers, totalLayers, shine){

            var container = elem.firstChild;

            container.className = container.className.replace(' over','');
            container.style.transform = '';
            shine.style.cssText = '';
            
            for(var ly=0;ly<totalLayers;ly++){
                layers[ly].style.transform = '';
            }

        }

    }

    atvImg();

    </script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
<script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>

@endsection


