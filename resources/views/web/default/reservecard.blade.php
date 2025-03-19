@extends(getTemplate().'.layouts.app')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <style>
    /* General Styles */
    body {
        font-family: 'Tajawal', sans-serif;
    }

    .cover.atvImg {
        margin-left: 25%; /* Default margin for larger screens */
        margin-top: 30px;
        margin-bottom: 39px;
    }

    .ss {
        font-size: 3.3rem;
        margin-left: 28% !important;
    }
    
</style>
<style>
    #mensuel, #annuel {
        background-color: transparent;
        border: none;
        color: #000;
        cursor: pointer;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }
    #mensuel.active, #annuel.active {
        color: #22BEC8;
        font-weight: bold;
    }
</style>

@section('content')
<!-- main section -->
      <div class="flex flex-col md:flex-row-reverse md:mx-12 mx-0 ">
         <!-- First Grid -->
         <div class="md:flex-2 md:my-8 my-0 lg:p-8 md:p-8">
            <div class="bg-[#EDF4F6] bg-opacity-30 w-full flex flex-col md:shadow-[0_0_10px_5px_rgba(0,0,0,0.2)] md:rounded-xl lg:py-8 sm:py-5 md:py-8 px-5 ">
               <div class="w-full flex m-auto items-center gap-2 md:text-lg transition-all duration-500">
                  <button id="mensuel" >اشتراك شهري</button>
                  <span>|</span>
                  <button id="annuel" >اشتراك سنوي</button>
               </div>
               <div class="mt-4 text-center ">
                  <h2 class="text-center md:text-3xl text-2xl font-bold text-[#1D3B65]">عرض الكرطابلة</h2>
                  <img class="mx-auto h-48" src="./assets/images/backpack-illustration.svg" alt="">
                  <p class="flex justify-center line-through text-2xl md:text-[1.5em] decoration-red-700 text-gray-400 font-bold"><span >د.ت </span>&nbsp <span id="oldPrice"> 240 </span></p>
                  <p class="md:text-[2em] font-semibold flex text-3xl  justify-center gap-1 text-[#1D3B65] font-bold"><span>د.ت</span> <span id="newPrice" >120</span></p>
               </div>
               <div class="flex flex-col gap-3 md:mx-4 mx-1 lg:py-8 md:py-8 flex-1">
                  <div class="flex flex-row-reverse items-start gap-2">
                     <i class="text-green-500 md:text-[3em] text-[2.4em]"
                        >
                        <svg
                           stroke="currentColor"
                           fill="currentColor"
                           stroke-width="0"
                           viewBox="0 0 24 24"
                           height="1em"
                           width="1em"
                           xmlns="http://www.w3.org/2000/svg"
                           >
                           <path
                              d="M10 15.586L6.707 12.293 5.293 13.707 10 18.414 19.707 8.707 18.293 7.293z"
                              ></path>
                        </svg>
                     </i>
                     <p class="text-end md:text-lg font-medium ">
                        فيديوهات تفسير و اصلاح كامل تمارين الكتب لكل مواد المستوى
                        الدراسي الخاص بطفلك
                     </p>
                  </div>
                  <div class="flex flex-row-reverse items-center gap-2">
                     <i class="text-green-500 md:text-[3em] text-[2.4em]"
                        >
                        <svg
                           stroke="currentColor"
                           fill="currentColor"
                           stroke-width="0"
                           viewBox="0 0 24 24"
                           height="1em"
                           width="1em"
                           xmlns="http://www.w3.org/2000/svg"
                           >
                           <path
                              d="M10 15.586L6.707 12.293 5.293 13.707 10 18.414 19.707 8.707 18.293 7.293z"
                              ></path>
                        </svg>
                     </i>
                     <p class="text-end md:text-lg font-medium">محتوى تعليمي ثري و تفاعلي لأكثر من 80 أستاذ متخصص في فريق أبجيم 

                     </p>
                  </div>
                  <div class="flex flex-row-reverse items-start gap-2">
                     <i class="text-green-500 md:text-[3em] text-[2.4em]"
                        >
                        <svg
                           stroke="currentColor"
                           fill="currentColor"
                           stroke-width="0"
                           viewBox="0 0 24 24"
                           height="1em"
                           width="1em"
                           xmlns="http://www.w3.org/2000/svg"
                           >
                           <path
                              d="M10 15.586L6.707 12.293 5.293 13.707 10 18.414 19.707 8.707 18.293 7.293z"
                              ></path>
                        </svg>
                     </i>
                     <p class="text-end md:text-lg font-medium">
                        اشراف بيداغوجي من قبل متفقدين لضمان جودة المحتوى و توافقه مع
                        البرنامج الرسمي
                     </p>
                  </div>
               </div>
               <div class="relative w-full flex justify-center items-center ">
                  <img
                     src="./assets/images/boy.svg"
                     alt=""
                     class="absolute w-auto md:left-[34%] left-[5%] -translate-x-1/2 -translate-y-1/4"
                     />
                  <button id="choose" class="mt-8 md:m-auto md:w-auto w-full text-center bg-[#1D3B65] text-white py-3 px-16 rounded-xl hover:bg-[#33c2cc] transition-all duration-400 shadow-lg">اختر العرض</button>
               </div>
            </div>
         </div>
         <!-- Second Grid -->
         <div class="md:flex-2 flex-auto md:mt-0 mt-12">
            <div class="w-full md:p-8">
               <p class="md:shadow-[0_0_10px_5px_rgba(0,0,0,0.2)] md:rounded-xl bg-[#EDF4F6] bg-opacity-30 w-full text-end  " style="padding:2rem">
                  <span class="font-bold">بعد اختيار العرض</span>
                  <span>
                  يمكنك ملئ البيانات المطلوبة و ستصلك بطاقة لتفعيل الاشتراك  على عنوانك في غضون 48 ساعة من حجز البطاقة.
                  </span>
                  <span id="read-more" class="underline text-blue-900 cursor-pointer pl-2 mt-2 py-1 text-center" >
                    مواصلة القراءة
                  </span>
               </p>
               <img src="./assets/images/Card.png" alt="" class="h-[28vh] select-none mx-auto md:mt-14 shadow-2xl">
                <form action="{{ route('webcard_reservations.store') }}" method="POST" class="form-container flex flex-col justify-center items-center w-full space-y-8 py-6  md:px-0 px-12 mt-30">
                 @csrf
                  <!-- Personal Information Section -->
                  <div class="space-y-4 w-full">
                     <div class="grid md:grid-cols-2 md:gap-8 gap-4">
                      <div class="space-y-2">
                        <label for="parent-name" class="block text-right font-medium text-gray-700">اسم الولي </label>
                        <input type="text" id="parent-name" name="name"
                           class="w-full px-3 py-2 border rounded-md text-right bg-[#E5EDF7]" 
                           placeholder="أدخل اسم الولي الكامل" required>
                     </div>
                        <div class="space-y-2 md:order-first">
                           <label for="phone" class="block text-right font-medium text-gray-700">رقم الهاتف </label>
                           <input type="text" id="phone" name="phone_number" 
                              class="w-full px-3 py-2 border rounded-md text-right bg-[#E5EDF7]" 
                              placeholder="12345678" minlength="8" maxlength="8" pattern="\d{8}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" >
                           

                        </div>
                 
                     </div>
                  </div>
                  <!-- Contact Information Section -->
                  <div class="space-y-4 w-full">
                     <div class="grid md:grid-cols-2 gap-4 md:gap-8">
                      <div class="space-y-2">
                        <label for="level_id" class="block text-right font-medium text-gray-700">مستوى الطفل </label>
                        <select 
                           id="student-level" 
                           name="level_id" 
                           class="w-full px-3 py-2 border rounded-md text-right text-slate-700 bg-[#E5EDF7]"
                           required
                           >
                           <option value="" selected disabled>اختر المستوى الدراسي</option>
                            @foreach ($levels as $lv)
                                                <option value="{{$lv->id}}">{{$lv->name}}</option>
                                            @endforeach
                        </select>
                     </div>
                        <div class="space-y-2 md:order-first">
                           <label for="school-type" class="block text-right font-medium text-gray-700">الولاية </label>
                           <select 
                              id="school-type" 
                              name="city" 
                              class="w-full px-3 py-2 border rounded-md text-right text-slate-700 bg-[#E5EDF7]"
                              required
                              >
                              <option value="" selected disabled>اختر الولاية</option>
                              <option value="تونس">تونس</option>
                              <option value="صفاقس">صفاقس</option>
                              <option value="سوسة">سوسة</option>
                              <option value="القيروان">القيروان</option>
                              <option value="بنزرت">بنزرت</option>
                              <option value="قابس">قابس</option>
                              <option value="أريانة">أريانة</option>
                              <option value="مدنين">مدنين</option>
                              <option value="قفصة">قفصة</option>
                              <option value="نابل">نابل</option>
                              <option value="المنستير">المنستير</option>
                              <option value="تطاوين">تطاوين</option>
                              <option value="جندوبة">جندوبة</option>
                              <option value="المهدية">المهدية</option>
                              <option value="الكاف">الكاف</option>
                              <option value="سيدي بوزيد">سيدي بوزيد</option>
                              <option value="منوبة">منوبة</option>
                              <option value="زغوان">زغوان</option>
                              <option value="توزر">توزر</option>
                              <option value="قبلي">قبلي</option>
                              <option value="باجة">باجة</option>
                              <option value="سليانة">سليانة</option>
                              <option value="بن عروس">بن عروس</option>
                              <option value="الحمامات">الحمامات</option>
                           </select>
                        </div>
                     
                     </div>
                  </div>
                  <!-- Address Section -->
                  <div class="w-full ">
                     <div class=" gap-4">
                        <div class="space-y-2">
                           <label for="address" class="block text-right font-medium text-gray-700">العنوان  </label>
                           <input type="text" id="address" name="address" 
                              class="w-full px-3 py-2 border rounded-md text-right  bg-[#E5EDF7]" 
                              placeholder="الشارع، رقم المنزل" required>
                        </div>
                     </div>
                  </div>
                    <input type="hidden" name="user_id" id="user_id" class="form-control" value="1">
                                   
                                    <input type="hidden" name="enfant_id" id="enfant_id" class="form-control" value="1">
                  <div class="">
                     <button
                        class="relative justify-center items-center px-16 md:w-auto w-full text-center py-3  bg-[#22BEC8] text-white m-auto w-auto text-white bg-gray-200 shadow-lg rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-300 overflow-hidden"
                        type="submit"
                        disabled
                        id="submit-card-action"
                        >
                        <div
                           class="absolute inset-0   blur-xl group-hover:opacity-75 transition-opacity"
                           ></div>
                        <span class="relative flex items-center justify-center gap-2">
                        إحجز البطاقة
                        </span>
                     </button>
                     <div
                        class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 transition-all duration-300 ease-out transform group-hover:translate-y-0 translate-y-2"
                        id="tooltip-default"
                        >
                        <div
                           class="relative p-4 bg-[#1D3B65] backdrop-blur-md text-white rounded-2xl border border-white/10 shadow-[0_0_30px_rgba(79,70,229,0.15)]"
                           >
                           <div class="flex items-center gap-3 mb-2">
                           </div>
                           <div class="space-y-2">
                              <p class="text-sm text-gray-300">
                                 الرجاء اختيار العرض المناسب (شهري أو سنوي ) قبل حجز البطاقة
                              </p>
                              <div class="flex items-center gap-2 text-xs text-gray-400">
                              </div>
                           </div>
                           <div
                              class="absolute inset-0 rounded-2xl bg-gradient-to-r from-indigo-500/10 to-purple-500/10 blur-xl opacity-50"
                              ></div>
                           <div
                              class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-gradient-to-br from-gray-900/95 to-gray-800/95 rotate-45 border-r border-b border-white/10"
                              ></div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
    <script>

    document.addEventListener("DOMContentLoaded", function () {
    const annuelBtn = document.getElementById("annuel");
    const mensuelBtn = document.getElementById("mensuel");
    const oldPriceLabel = document.getElementById("oldPrice");
    const newPriceLabel = document.getElementById("newPrice");
    const choosePack = document.getElementById("choose");
    const submitCard = document.getElementById("submit-card-action");
    const tooltip = document.getElementById("tooltip-default");
    const formInputs = document.querySelectorAll("input, select"); // Select all form inputs & selects

    function activateButton(activeBtn, inactiveBtn, oldPrice, newPrice) {
        if (!activeBtn || !inactiveBtn || !oldPriceLabel || !newPriceLabel) return;

        // Toggle active state
        activeBtn.classList.add("active");
        inactiveBtn.classList.remove("active");

        // Update price labels
        oldPriceLabel.textContent = oldPrice;
        newPriceLabel.textContent = newPrice;

        // Enable "Choose" button
        if (choosePack) {
            choosePack.disabled = false;
            choosePack.classList.replace("text-gray-400", "text-white");
            choosePack.classList.add("hover:bg-[#33c2cc]", "shadow-lg");
        }

        // Reset submit button
        if (submitCard) {
            submitCard.disabled = true;
             choosePack.textContent = "اختر العرض"
            submitCard.classList.replace("bg-[#1D3B65]", "bg-gray-200");
            submitCard.classList.replace("text-white", "text-gray-400");
            submitCard.classList.remove("hover:bg-[#33c2cc]", "shadow-lg");

            // Show tooltip when submit button is disabled
            tooltip.classList.remove("hidden");
            tooltip.classList.add("opacity-100", "visible");
        }
    }

    function enableSubmit() {
        if (!submitCard || !choosePack) return;

        submitCard.disabled = false;
        submitCard.classList.replace("text-gray-400", "text-white");
        submitCard.classList.replace("bg-gray-200", "bg-[#1D3B65]");
        submitCard.classList.add("hover:bg-[#33c2cc]", "shadow-lg");

        choosePack.disabled = true;
        choosePack.textContent = "تم إختيار العرض"
        choosePack.classList.replace("text-white", "text-gray-400");
        choosePack.classList.remove("hover:bg-[#33c2cc]");

        // Hide tooltip when submit button is enabled
        tooltip.classList.add("hidden");
        tooltip.classList.remove("opacity-100", "visible");

        // Enable form inputs and focus on the first input
        formInputs.forEach(input => input.disabled = false);
        document.getElementById("parent-name")?.focus(); // Focus on the first input
    }

    // Default selection (Annuel active)
    if (annuelBtn && mensuelBtn) {
        activateButton(annuelBtn, mensuelBtn, "240", "120");

        annuelBtn.addEventListener("click", () => activateButton(annuelBtn, mensuelBtn, "240", "120"));
        mensuelBtn.addEventListener("click", () => activateButton(mensuelBtn, annuelBtn, "50", "35"));
    }

    // Enable "Submit" and form inputs on choosing a pack
    choosePack?.addEventListener("click", enableSubmit);
});

document.querySelector('#read-more').addEventListener('click',()=>{
    Swal.fire({
        title: "",
        icon: "",
        html: `
        <img src='./assets/images/card-preview.png' class='m-auto' alt='بطاقة أبجيم' />
        <div class='flex flex-col gap-6' >
        <div class='bg-gray-100 p-2 rounded-lg space-y-4' >
        <p class='font-bold text-2xl text-[#1D3B65]' >الاشتراك في شبكة أبجيم</p>
          <p  >للتمتع باشتراك في شبكة أبجيم يرجى اختيار عرض سنوي أو شهري , بعد ذلك ستتمكن من ملئ البيانات المطلوبة و حجز بطاقة اشتراك, بعد الضغط على احجز البطاقة ستتلقى اتصال هاتفي من فريق أبجيم لتأكيد معلومات الاتصال و العنوان و لتحديد الوقت المناسب لاستلامها</p>
          </div>
          <div class='bg-gray-100 p-2 rounded-lg space-y-4' >
          <p class='font-bold text-2xl text-[#1D3B65]'>استلام بطاقة الاشتراك</p>
          <p>بعد تأكيد الطلب ستصلك البطاقة على العنوان المحدد في غضون 48 ساعة و بامكانك دفع الرسوم عند الاستلام, سيحتوي الضرف بالاضافة الى بطاقة الاشتراك على كتيب ارشادات لطريقة انشاء حساب و تفعيل الاشتراك.
            </div>
          </p>
</div>
        `,
        showCloseButton: true,
        
        focusConfirm: true,
        confirmButtonText: `
          <i class="fa fa-thumbs-up"></i> موافق`,
      });
})
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
    <script>
    // Add this script after your existing JavaScript code
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'تم الحجز بنجاح!',
            text: '{{ session("success") }}',
            confirmButtonText: 'موافق',
            timer: 5000
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'خطأ!',
            html: `<ul class="text-right">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>`,
            confirmButtonText: 'حسناً'
        });
    @endif
</script>
<script>
document.getElementById('submit-card-action').addEventListener('click', function(e) {
    if (this.disabled) {
        e.preventDefault();
        const tooltip = document.getElementById('tooltip-default');
        
        // Show tooltip
        tooltip.classList.remove('invisible', 'opacity-0');
        tooltip.classList.add('visible', 'opacity-100');
        
        // Hide tooltip after 3 seconds
        setTimeout(() => {
            tooltip.classList.remove('visible', 'opacity-100');
            tooltip.classList.add('invisible', 'opacity-0');
        }, 3000);
    }
});
</script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
<script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>
<script src="https://cdn.tailwindcss.com"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection


