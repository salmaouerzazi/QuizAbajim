@extends(getTemplate() . '.panel.layouts.panel_layout')

<style>
    .coming-soon .lead {
        font-size: 1.25rem;
        font-weight: 300;
    }

    .faq .card-header .btn {
        width: 100%;
        text-align: left;
    }

    .faq .card {
        margin-bottom: 0.5rem;

    }


    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        text-align: justify
    }
</style>
@section('content')
    <div class="container">
        <div class="coming-soon">
            <h1 class="display-4">قريباً على شبكة أبجيم</h1>
            <p class="lead mt-10">يسرّنا أن نعلن عن قرب إطلاق خاصيّة صناعة الدّروس، والتّي تتيح للمعلّمين إنشاء دروس متنوّعة
                وشاملة.
                سيتمكّن المعلّمون من تضمين مجموعة واسعة من الموارد مثل الصّور، عروض باوربونت، ملفّات پدف و وورد، وغيرها من
                الوسائط التّعليميّة. ستوفّر هذه الوحدة للمعلّمين الأدوات اللاّزمة لتنظيم المحتوى بطريقة احترافيّة وسهلة
                الاستخدام،
                ممّا يضمن تجربة تعليميّة تفاعليّة وغنيّة للتّلاميذ.
                قريباً على منصّتنا!</p>
            <hr class="my-4">

            <div class="faq mt-5">
                <h2 class="mb-3">الأسئلة الشّائعة</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="card">
                        <div class="card-header" id="headingOne" style="background-color: #cbc5eb;">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    متى ستكون الوحدة جاهزة؟
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#faqAccordion">
                            <div class="card-body">
                                تاريخ الإطلاق النّهائي للوحدة الجديدة محدّد ل1 ديسمبر 2024. نحن نعمل حاليّاً على تحسينات
                                أخيرة
                                واختبارات تقنيّة لضمان تجربة مثاليّة. سنقوم بإعلامكم بأي تحديثات إضافيّة حتّى تتمكّنوا من
                                الاستفادة منها في أقرب وقت. تابعوا إشعارات المنصّة لمزيد من التّفاصيل!
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo" style="background-color: #dfd9e4;">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    ما هي أنواع الملفّات التّي يمكنني تضمينها في الدّورة التدريبيّة؟ </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                            <div class="card-body">
                                يمكنك تضمين عدة أنواع من الملفات مثل الصور (PNG)، عروض پورپنت، ملفات وورد، بالإضافة إلى
                                إمكانية إضافة مقاطع الفيديو والروابط التفاعلية. </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree" style="background-color: #c9d7e7;">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    هل هناك حد لعدد الدورات التي يمكنني إنشاؤها؟
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                            <div class="card-body">
                                لا، يمكنك إنشاء عدد غير محدود من الدورات التدريبية وفقًا لاحتياجاتك التعليمية.

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingFour"style="background-color: #d0eaec;">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    هل يمكن للتلاميذ تحميل محتويات الدورة؟
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                            <div class="card-body">
                                يعتمد ذلك على إعدادات الدورة التي يختارها المعلم. يمكنك إتاحة المحتوى
                                للتحميل أو تحديد الوصول إليه فقط من خلال الشبكة.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingFive" style="background-color: #c9dae2;">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    هل يمكنني تعديل الدورة التدريبية بعد نشرها؟
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#faqAccordion">
                            <div class="card-body">
                                نعم، يمكنك تعديل المحتوى وإضافة مواد جديدة أو تحديث الملفات في أي وقت حتى بعد نشر الدورة
                                التدريبية.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
