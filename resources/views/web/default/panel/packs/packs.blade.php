@extends(getTemplate() . '.panel.layouts.panel_layout')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"> <!-- Icon Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"> <!-- Icon Library -->
    <link rel="stylesheet" href="/store/style.css">
@push('styles_top')
    <style>
        * {
            font-family: 'Tajawal', sans-serif !important;
        }

        .home-sections {
            margin-top: 0 !important;

        }
    </style>
    <style>
    * {
    margin: 0;
    padding: 0;
}
.nav-tabs .nav-link.active[href="#tab1"] {
  border-width: 3px;
  border-color: #5ddbdb;
  color: #5ddbdb;
}
.nav-tabs .nav-link.active[href="#tab2"] {
  border-width: 3px;
  border-color: #ff0;
  color: #e42828;
}
.nav-tabs .nav-link.active[href="#tab3"] {
  border-width: 3px;
  border-color: #f0f;
  color: #f0f;
}

html {
    height: 100%;
}

/*Background color*/
#grad1 {
    background-color: : #9C27B0;
    background-image: linear-gradient(120deg, #FF4081, #81D4FA);
}

/*form styles*/
#msform {
    text-align: center;
    position: relative;
    margin-top: 20px;
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;

    /*stacking fieldsets above each other*/
    position: relative;
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;

    /*stacking fieldsets above each other*/
    position: relative;
}

/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
    display: none;
}

#msform fieldset .form-card {
    text-align: left;
    color: #9E9E9E;
}

#msform input, #msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    font-family: montserrat;
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px;
}

#msform input:focus, #msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0;
}

/*Blue Buttons*/
#msform .action-button {
    width: 100px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button:hover, #msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue;
}

/*Previous Buttons*/
#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button-previous:hover, #msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
}

/*Dropdown List Exp Date*/
select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px;
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue;
}

/*The background card*/
.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative;
}

/*FieldSet headings*/
.fs-title {
    font-size: 25px;
    color: #2C3E50;
    margin-bottom: 10px;
    font-weight: bold;
    text-align: left;
}

/*progressbar*/
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
}

#progressbar .active {
    color: #000000;
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 25%;
    float: right;
    position: relative;
}

/*Icons in the ProgressBar*/
#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f02c";
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007";
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f09d";
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c";
}

/*ProgressBar before any progress*/
#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #ffffff;
    background: #22bec8;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px;
}

/*ProgressBar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: #22bec8;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1;
}

/*Color number of the step and the connector before it*/
#progressbar li.active:before, #progressbar li.active:after {
    background: #1d3b65;
}

/*Imaged Radio Buttons*/
.radio-group {
    position: relative;
    margin-bottom: 25px;
}

.radio {
    display:inline-block;
    width: 204;
    height: 104;
    border-radius: 0;
    background: lightblue;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    cursor:pointer;
    margin: 8px 2px; 
}

.radio:hover {
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
}

.radio.selected {
    box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
}

/*Fit image in bootstrap div*/
.fit-image{
    width: 100%;
    object-fit: cover;
}
   .avatar-child {
        max-width: 75%;
    border-radius: 35%;
    }
    
    </style>
@endpush

@section('content')

<!-- MultiStep Form -->
<div class="container-fluid" >
                    <form id="msform" >
                            <!-- progressbar -->
                            <ul id="progressbar" dir="rtl">
                                <li class="active" id="account"><strong>اختر الاشتراك</strong></li>
                                <li id="personal"><strong>الشخصية</strong></li>
                                <li id="payment"><strong>الدفع</strong></li>
                                <li id="confirm"><strong>الإنهاء</strong></li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                @include('web.default.panel.packs.includes.packsComponent')
                                </div>
                                <input type="button" name="next" class="next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                            <div class="containerc">    
                                <div class="container">    
                                    <div class="row">               
                                        <div class="col-lg-12">
                                            <div class="row" style="margin-bottom:50px">
                                                @if (!empty($userenfant))
                                                    @foreach ($userenfant as $enf)
                                                        @php
                                                            $levelenfant = DB::table('school_levels')
                                                                ->where('id', $enf->level_id)
                                                                ->pluck('name');
                                                        @endphp
                                                        <div class="col-lg-3 mb-3 d-flex flex-column align-items-center">
                                                            <a>
                                                                <img class="avatar-child img-fluid"
                                                                    src="{{ $enf->avatar }}" alt="Avatar">
                                                            </a>
                                                        
                                                            <div class="flex-container text-center mt-2">
                                                                <span class="text-secondary font-20 d-block">
                                                                    {{ $enf->full_name }}
                                                                </span>
                                                                <span class="font-weight-bold text-secondary font-20">
                                                                    {{ $levelenfant[0] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="next" class="next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    
                                <div class="form-card">
                                    <h2 class="fs-title">Payment Information</h2>
                                    <div class="radio-group">
                                        <div class='radio' data-value="credit"><img src="https://i.imgur.com/XzOzVHZ.jpg" width="600px" height="200px"></div>
                                        <div class='radio' data-value="paypal"><img src="https://i.imgur.com/jXjwZlj.jpg" width="600px" height="200px"></div>
                                        <br>
                                    </div>
                                    
                                </div>
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="make_payment" class="next action-button" value="Confirm"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title text-center">Success !</h2>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5>You Have Successfully Signed Up</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                     
      </form>
   
</div>

    
    <div class="wrapper" id="app">
        <div class="card-form">
        <div class="card-list">
            <div class="card-item" v-bind:class="{ '-active' : isCardFlipped }">
            <div class="card-item__side -front">
                <div class="card-item__focus" v-bind:class="{'-active' : focusElementStyle }" v-bind:style="focusElementStyle" ref="focusElement"></div>
                <div class="card-item__cover">
                <img
                src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/9.jpeg" class="card-item__bg">
                </div>
                
                <div class="card-item__wrapper">
                <div class="card-item__top">
                    <img src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/chip.png" class="card-item__chip">
                    <div class="card-item__type">
                    <transition name="slide-fade-up">
                        <img src="/store/1/logo_white.png" v-if="getCardType" v-bind:key="getCardType" alt="" class="card-item__typeImg">
                    </transition>
                    </div>
                </div>

                        
                <label for="cardNumber" class="card-item__number" ref="cardNumber">
                    {{-- <template v-if="getCardType === 'amex'">
                    <span v-for="(n, $index) in amexCardMask" :key="$index">
                    <transition name="slide-fade-up">
                        <div
                        class="card-item__numberItem"
                        v-if="$index > 0 && $index < 7 && cardNumber.length > $index && n.trim() !== ''"
                        >*</div>
                        <div class="card-item__numberItem"
                        :class="{ '-active' : n.trim() === '' }"
                        :key="$index" v-else-if="cardNumber.length > $index">
                        
                        </div>
                        <div
                        class="card-item__numberItem"
                        :class="{ '-active' : n.trim() === '' }"
                        v-else
                        :key="$index + 1"
                        v-text="n" ></div>
                    </transition>
                    
                    </span>
                    </template> --}}
                        <template v-for="(n, $index) in cardNumber.split('')" :key="$index">
                                <transition name="slide-fade-up">
                                <div class="card-item__numberItem" v-text="n"></div>
                                </transition>
                            </template>

                
                </label>
                <div class="card-item__content">
                <label for="cardName" class="card-item__info" ref="cardName">
                    <div class="card-item__holder">اسم الطفل</div>
                    <transition name="slide-fade-up">
                        <div class="card-item__name" v-if="cardName.length" key="1">
                        @{{ cardName }}
                        </div>
                        <div class="card-item__name" v-else key="2">
                            اسم الطفل                      </div>
                    </transition>
                    </label>
                    <div class="card-item__date" ref="cardDate">
                    <label for="cardMonth" class="card-item__dateTitle">تنتهي صلاحيتها</label>
                    <label for="cardMonth" class="card-item__dateItem">
                        <transition name="slide-fade-up">
                        <span v-if="cardMonth" v-bind:key="cardMonth"></span>
                        <span v-else key="2">07</span>
                        </transition>
                    </label>
                    /
                    <label for="cardYear" class="card-item__dateItem">
                        <transition name="slide-fade-up">
                        <span v-if="cardYear" v-bind:key="cardYear"></span>
                        <span v-else key="2">25</span>
                        </transition>
                    </label>
                    </div>
                </div>
                </div>
            </div>
            <div class="card-item__side -back">
                <div class="card-item__cover">
                <img
                src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/14.jpeg" class="card-item__bg">
                </div>
                <div class="card-item__band"></div>
                <div class="card-item__cvv">
                    <div class="card-item__cvvTitle">مدرسة المستوى</div>
                    <div class="card-item__cvvBand">
                        <span v-if="cardCvv">@{{ cardCvv }}</span>
                        <span v-else>اختر المستوى</span>
                    </div>
                    <div class="card-item__type">
                    <img src="/store/1/logo_white.png" v-if="getCardType" v-bind:key="getCardType" alt="" class="card-item__typeImg">

                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="card-form__inner">
            <div class="card-input">
            <label for="cardNumber" class="card-input__label">رمز البطاقة</label>
                <input
                type="text"
                id="cardNumber"
                class="card-input__input"
                v-mask="generateCardNumberMask"
                v-model="cardNumber"
                v-on:focus="focusInput"
                v-on:blur="blurInput"
                data-ref="cardNumber"
                maxlength="12"
                autocomplete="off"
                />
            </div>
            <div class="card-input">
            <label for="cardName" class="card-input__label">اسم الطفل  </label>
            <input type="text" id="cardName" class="card-input__input" v-model="cardName" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardName" autocomplete="off">
            </div>
            <div class="card-form__row">
        
            
            <div class="card-form__col -cvv">
            <div class="card-input">
                <label for="cardCvv" class="card-input__label">مدرسة المستوى</label>
                <select   class="form-control js-webinar-content-locale"
                id="cardCvv" v-mask="'####'"  v-model="cardCvv" v-on:focus="flipCard(true)" v-on:blur="flipCard(false)"
                class="card-input__input" 
                
                >
                <option value="" disabled selected>اختر المستوى</option>
                <option value="الأولى ابتدائي">الأولى ابتدائي</option>
                <option value="الثانية ابتدائي">الثانية ابتدائي</option>
                <option value="الثالثة ابتدائي">الثالثة ابتدائي</option>
                <option value="الرابعة ابتدائي">الرابعة ابتدائي</option>
                <option value="الخامسة ابتدائي">الخامسة ابتدائي</option>
                <option value="السّادسة  ابتدائي">السّادسة  ابتدائي</option>
                </select>
            </div>
            </div>

            </div>

            <button class="card-form__button">
            Submit
            </button>
        </div>
        </div>
        
    
    </div>
<!-- partial -->
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/sw.js') }}"></script>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
<script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script><script  src="/store/script.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    
    const subscribePlans = document.querySelectorAll('.subscribe-plan');

    subscribePlans.forEach(plan => {
        plan.addEventListener('click', function () {
            const planTitle = this.querySelector('h3').innerText;
            const planDescription = this.querySelector('ul').innerHTML;
            const planPrice = this.querySelector('.pack-price') ? this.querySelector('.pack-price').innerHTML : '';

            // Populate modal content
            const modalContent = `
                <h4>${planTitle}</h4>
                <ul>${planDescription}</ul>
                <p><strong>{{ trans('home.price') }}:</strong> ${planPrice}</p>
            `;
            document.getElementById('modalContent').innerHTML = modalContent;

            // Open the modal
            const subscriptionModal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
            subscriptionModal.show();
        });
    });
});



        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
        document.addEventListener('DOMContentLoaded', function() {

            const monthlyBtn = document.getElementById('monthlyBtn');
            const yearlyBtn = document.getElementById('yearlyBtn');
            const prices = document.querySelectorAll('.pack-price');

            function updatePrices(isYearly) {
                const currentMonth = new Date().getMonth() + 1;
                let monthsLeftInYear = 0;

                if (currentMonth < 6) {
                    monthsLeftInYear = 6 - currentMonth;
                } else {
                    monthsLeftInYear = 12 - currentMonth + 6;
                }
                prices.forEach(priceElement => {
                    const basePrice = parseFloat(priceElement.dataset.basePrice);
                    let finalPrice = basePrice;
                    if (isYearly) {
                        finalPrice = monthsLeftInYear * basePrice;
                    }
                    priceElement.innerHTML =
                        `<del>${finalPrice.toFixed(2)} DT</del>`;
                });
            }

            monthlyBtn.addEventListener('click', function() {
                monthlyBtn.classList.add('active');
                yearlyBtn.classList.remove('active');
                updatePrices(false);
            });

            yearlyBtn.addEventListener('click', function() {
                monthlyBtn.classList.remove('active');
                yearlyBtn.classList.add('active');
                updatePrices(true);
            });

            updatePrices(false);
        });
    </script>







    <script>
   $(document).ready(function(){
    
var current_fs, next_fs, previous_fs; //fieldsets
var opacity;

$(".next").click(function(){
    
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    
    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    
    //show the next fieldset
    next_fs.show(); 
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            next_fs.css({'opacity': opacity});
        }, 
        duration: 600
    });
});

$(".previous").click(function(){
    
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();
    
    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            previous_fs.css({'opacity': opacity});
        }, 
        duration: 600
    });
});

$('.radio-group .radio').click(function(){
    $(this).parent().find('.radio').removeClass('selected');
    $(this).addClass('selected');
});

$(".submit").click(function(){
    return false;
})
    
}); 
    </script>
@endpush
