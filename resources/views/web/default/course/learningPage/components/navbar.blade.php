

<div
    class="learning-page-navbar d-flex align-items-lg-center justify-content-between flex-column flex-lg-row px-15 px-lg-35 py-10">
    <div class="d-flex align-items-lg-center flex-column flex-lg-row flex-grow-1">

        <div class="d-flex align-items-center mt-5 mt-md-0 mr-20">
            <button id="collapseBtn" type="button" class="btn-transparent ml-auto ml-lg-20">
                <i data-feather="menu" width="20" height="20" class=""></i>
            </button>
        </div>
        <div class="d-flex flex-column">
            <a href="{{ $course->getUrl() }}" class="learning-page-navbar-title">
                <span class="font-weight-bold">{{ $course->title }}</span>
            </a>
            <div class="d-flex align-items-center">
                <div
                    class="progress course-progress d-flex align-items-center flex-grow-1 bg-white border border-gray200 rounded-sm shadow-none mt-5">
                </div>
         
            </div>
        </div>
    </div>
    <div class="learning-page-logo-card d-flex align-items-center justify-content-between justify-content-lg-start">
        <a class="navbar-brand d-flex align-items-center justify-content-center mr-0" href="/">
            @if (!empty($generalSettings['logo']))
                <img src="{{ $generalSettings['logo'] }}" width="70%" height="100%" alt="site logo">
            @endif
        </a>
    </div>
</div>
