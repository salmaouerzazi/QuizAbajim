@extends(getTemplate() . '.panel.layouts.panel_layoutPay')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

<link rel="stylesheet" href="/store/style.css">
@section('content')


  <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        @font-face {
            font-family: pop;
            src: url(./Fonts/Poppins-Medium.ttf);
        }

        .main{

            display: flex;
            justify-content: center;
            align-items: center;
            font-family: pop;
            flex-direction: column;
        }
        .head{
            text-align: center;
        }
        .head_1{
            font-size: 30px;
            font-weight: 600;
            color: #4fcaf3;
        }
        .head_1 span{
            color: #ff4732;
        }
        .head_2{
            font-size: 16px;
            font-weight: 600;
            color: #911414;
            margin-top: 3px;
        }
        ul{
            display: flex;
            margin-top: 80px;
        }
        ul li{
            list-style: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        ul li .icon{
            font-size: 35px;
            color: #0e56ca;
            margin: 0 60px;
        }
        ul li .text{
            font-size: 14px;
            font-weight: 600;
            color: #0953d4;
        }

        /* Progress Div Css  */

        ul li .progress{
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(68, 68, 68, 0.781);
            margin: 14px 0;
            display: grid;
            place-items: center;
            color: #fff;
            position: relative;
            cursor: pointer;
        }
        .progress::after{
            content: " ";
            position: absolute;
            width: 125px;
            height: 5px;
            background-color: rgba(68, 68, 68, 0.781);
            right: 30px;
        }
        .one::after{
            width: 0;
            height: 0;
        }
        ul li .progress .uil{
            display: none;
        }
        ul li .progress p{
            font-size: 13px;
        }

        /* Active Css  */

        ul li .active{
            background-color: #3bb9fd;
            display: grid;
            place-items: center;
        }
        li .active::after{
            background-color: #32bbff;
        }
        ul li .active p{
            display: none;
        }
        ul li .active .uil{
            font-size: 20px;
            display: flex;
        }

        /* Responsive Css  */

        @media (max-width: 980px) {
            ul{
                flex-direction: column;
            }
            ul li{
                flex-direction: row;
            }
            ul li .progress{
                margin: 0 30px;
            }
            .progress::after{
                width: 5px;
                height: 55px;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                z-index: -1;
            }
            .one::after{
                height: 0;
            }
            ul li .icon{
                margin: 15px 0;
            }
        }

        @media (max-width:600px) {
            .head .head_1{
                font-size: 24px;
            }
            .head .head_2{
                font-size: 16px;
            }
        }
    </style>
    <style>
        .custom-button {
            margin-top: 20px;
            background-color: #4fcaf3;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
    
        .custom-button:hover {
            background-color: #3bb9fd;
        }
    
        .custom-button:active {
            background-color: #2b94c8;
        }
    </style>
    <style>
        .forms-container {
            margin-top: 20px;
            text-align: left;
        }
    
        .step-form {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    
        .step-form h3 {
            margin-bottom: 15px;
            color: #0071bc;
        }
    
        .step-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
    
        .step-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    
        .step-form button {
            padding: 10px 20px;
            background-color: #0071bc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    
        .step-form button:hover {
            background-color: #005a93;
        }
    </style>
<!-- partial:index.partial.html -->
 <div class="main">

            <div class="head">
                
            </div>

            <ul>
                <li>
                    <i class="icon uil uil-capture"></i>
                    <div class="progress one">
                        <p>1</p>
                        <i class="uil uil-check"></i>
                    </div>
                    <p class="text">Add To Cart</p>
                </li>
                <li>
                    <i class="icon uil uil-clipboard-notes"></i>
                    <div class="progress two">
                        <p>2</p>
                        <i class="uil uil-check"></i>
                    </div>
                    <p class="text">Fill Details</p>
                </li>
                <li>
                    <i class="icon uil uil-credit-card"></i>
                    <div class="progress three">
                        <p>3</p>
                        <i class="uil uil-check"></i>
                    </div>
                    <p class="text">Make Payment</p>
                </li>
                <li>
                    <i class="icon uil uil-exchange"></i>
                    <div class="progress four">
                        <p>4</p>
                        <i class="uil uil-check"></i>
                    </div>
                    <p class="text">Order in Progress</p>
                </li>
                <li>
                    <i class="icon uil uil-map-marker"></i>
                    <div class="progress five">
                        <p>5</p>
                        <i class="uil uil-check"></i>
                    </div>
                    <p class="text">Order Arrived</p>
                </li>
            </ul>
        <div class="forms-container">
                <!-- Form for Step 1 -->
                <form id="form1" class="step-form" style="display: none;">
                    <h3>Add To Cart</h3>
                    <label for="product">Product Name:</label>
                    <input type="text" id="product" name="product" placeholder="Enter product name">
                    <button type="button" onclick="alert('Step 1 form submitted!')">Submit</button>
                </form>
            
                <!-- Form for Step 2 -->
                <form id="form2" class="step-form" style="display: none;">
                    <h3>Fill Details</h3>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email">
                    <button type="button" onclick="alert('Step 2 form submitted!')">Submit</button>
                </form>
            
                <!-- Form for Step 3 -->
                <form id="form3" class="step-form" style="display: none;">
                    <h3>Make Payment</h3>
                    <label for="card">Card Number:</label>
                    <input type="text" id="card" name="card" placeholder="Enter card number">
                    <button type="button" onclick="alert('Step 3 form submitted!')">Submit</button>
                </form>
            
                <!-- Form for Step 4 -->
                <form id="form4" class="step-form" style="display: none;">
                    <h3>Order in Progress</h3>
                    <p>Your order is being processed. Please wait...</p>
                </form>
            
                <!-- Form for Step 5 -->
                <form id="form5" class="step-form" style="display: none;">
                    <h3>Order Arrived</h3>
                    <p>Congratulations! Your order has arrived.</p>
                </form>
        </div>
        
        <div class="button-container">
            <button id="nextButton" class="custom-button">Next</button>
        </div>
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
                <div class="card-item__holder">Card Kids</div>
                <transition name="slide-fade-up">
                    <div class="card-item__name" v-if="cardName.length" key="1">
                    @{{ cardName }}
                    </div>
                    <div class="card-item__name" v-else key="2">
                    Card Kids
                    </div>
                </transition>
                </label>
                <div class="card-item__date" ref="cardDate">
                  <label for="cardMonth" class="card-item__dateTitle">Expires</label>
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
                <div class="card-item__cvvTitle">CVV</div>
                <div class="card-item__cvvBand">
                  <span v-for="(n, $index) in cardCvv" :key="$index">
                    *
                  </span>

              </div>
                <div class="card-item__type">
                    <img v-bind:src="'https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/' + getCardType + '.png'" v-if="getCardType" class="card-item__typeImg">
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-form__inner">
        <div class="card-input">
          <label for="cardNumber" class="card-input__label">Card Number</label>
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
          <label for="cardName" class="card-input__label">Card Holders</label>
          <input type="text" id="cardName" class="card-input__input" v-model="cardName" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardName" autocomplete="off">
        </div>
        <div class="card-form__row">
     
          <div class="card-form__col -cvv">
            <div class="card-input">
              <label for="cardCvv" class="card-input__label">CVV</label>
              <input type="text" class="card-input__input" id="cardCvv" v-mask="'####'" maxlength="4" v-model="cardCvv" v-on:focus="flipCard(true)" v-on:blur="flipCard(false)" autocomplete="off">
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
  <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
<script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script><script  src="/store/script.js"></script>
   
    <script>
        const steps = document.querySelectorAll(".progress"); // Get all step elements
        const forms = document.querySelectorAll(".step-form"); // Get all forms
        let currentStep = 0; // Start with the first step
    
        document.getElementById("nextButton").addEventListener("click", function () {
            if (currentStep < steps.length) {
                // Activate current step
                steps.forEach((step, index) => {
                    if (index <= currentStep) {
                        step.classList.add("active");
                    } else {
                        step.classList.remove("active");
                    }
                });
    
                // Show the corresponding form
                forms.forEach((form, index) => {
                    if (index === currentStep) {
                        form.style.display = "block";
                    } else {
                        form.style.display = "none";
                    }
                });
    
                // Move to the next step
                currentStep++;
            }
    
            // Disable button and mark process complete when reaching the last step
            if (currentStep === steps.length) {
                document.getElementById("nextButton").disabled = true;
                document.getElementById("nextButton").textContent = "Completed";
            }
        });
    </script>
    
    
    <script >
        const one = document.querySelector(".one");
        const two = document.querySelector(".two");
        const three = document.querySelector(".three");
        const four = document.querySelector(".four");
        const five = document.querySelector(".five");

        one.onclick = function() {
            one.classList.add("active");
            two.classList.remove("active");
            three.classList.remove("active");
            four.classList.remove("active");
            five.classList.remove("active");
        }

        two.onclick = function() {
            one.classList.add("active");
            two.classList.add("active");
            three.classList.remove("active");
            four.classList.remove("active");
            five.classList.remove("active");
        }
        three.onclick = function() {
            one.classList.add("active");
            two.classList.add("active");
            three.classList.add("active");
            four.classList.remove("active");
            five.classList.remove("active");
        }
        four.onclick = function() {
            one.classList.add("active");
            two.classList.add("active");
            three.classList.add("active");
            four.classList.add("active");
            five.classList.remove("active");
        }
        five.onclick = function() {
            one.classList.add("active");
            two.classList.add("active");
            three.classList.add("active");
            four.classList.add("active");
            five.classList.add("active");
        }
    </script>
@endsection

