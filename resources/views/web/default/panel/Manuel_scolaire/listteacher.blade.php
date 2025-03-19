@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/assets/default/vendors/apexcharts/apexcharts.css" />
    <link rel="stylesheet" href="/assets/default/css/manuelContent.css">
@endpush

@php
    $totalVideos = $totalIconAddInManuels[0];
    $percentageCompleted = ($distinctvideocountbymanul / $totalVideos) * 100;
@endphp

<style>
    * {
        font-family: 'Tajawal', sans-serif;
    }

    .scroll-menu-wrapper {
        margin: 10px !important;
    }

    .scroll-left {
        left: -1.5% !important;
    }
</style>

@section('content')
    <section class="row">
        <div class="col-lg-10">
            <div class="scroll-menu-wrapper">
                <div class="scroll-left" id="scroll-left1">&#9664;</div>
                @php
                    $sortedManuels = $Manuels->sortBy('matiere.section.level.id');
                @endphp
                <div class="scroll-menu-container" id="navbar22">
                    @foreach ($sortedManuels as $manuel)
                        @php
                            $filteredLevelName1 = str_replace('ابتدائي', '', $manuel->matiere->section->level->name);
                        @endphp
                        <a href="/panel/scolaire/teacher/{{ $manuel->id }}icon=1&page=6"
                            class="scroll-menu-item {{ $manuel->id == $id ? 'active' : '' }}"
                            href="/panel/scolaire/teacher/{{ $manuel->id }}icon=1&page=6"
                            style="font-family: 'Tajawal', sans-serif;!important">{{ $filteredLevelName1 }}
                            {{ $manuel->matiere->name }} {{ $manuel->name }}</a>
                    @endforeach

                </div>
                <div class="scroll-right" id="scroll-right1">&#9654;</div>

            </div>
        </div>

        <style>
            .video-square {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin-top: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                padding: 20px;
                width: 100%;
            }
        </style>

    </section>
    <div class="row mt-10">
        <div class="col-12 col-lg-10">
            @if (!empty($t3DPathManuels[0]))
                <a href="{{ $t3DPathManuels[0] }}" class="fp-embed" data-fp-width="100%" data-fp-height="80vh"
                    data-options='{"LinkTarget": "none"}'></a>
            @else
                <div style="padding: 10px;">
                    <object data="{{ $pdfFilePath }}#zoom=auto&page={{ $page }}" type="application/pdf"
                        width="100%" height="860px">
                        <p>Unable to display PDF file. <a href="{{ $pdfFilePath }}">Download</a> instead.</p>
                    </object>
                </div>
            @endif
        </div>
        <div class="col-12 col-lg-2 d-flex flex-column align-items-center">
            <div class="video-square">
                <span class="font-16 text-secondary"
                    style="font-family: 'Tajawal', sans-serif;">{{ trans('public.number_uploaded_videos') }}</span>
                <div class="d-flex align-items-center justify-content-center mt-10"
                    style="border-radius: 50%; border: 1px dashed #838282; width: 100px; height: 100px;">
                    <span class="font-16 font-weight-bold text-secondary text-center"
                        style="font-family: 'Tajawal', sans-serif;">{{ $videocountbymanul }}</span>
                </div>
            </div>
            <div class="video-square">
                <div data-percent="{{ number_format($percentageCompleted) }}"
                    data-label="{{ $videocountbymanul }}/{{ $totalVideos }}" id="nextBadgeChart" class="text-center">
                </div>
                <span class="font-16 text-secondary text-center"
                    style="font-family: 'Tajawal', sans-serif;">{{ trans('public.number_uploaded_videos_per_total') }}</span>
                <div class="d-flex align-items-center justify-content-center mt-10"
                    style="border-radius: 50%; border: 1px dashed #838282; width: 100px; height: 100px;">
                    <span class="font-16 font-weight-bold text-secondary text-center"
                        style="font-family: 'Tajawal', sans-serif;">{{ number_format($percentageCompleted, 0) }}%</span>
                </div>
            </div>
        </div>
    </div>
    <div id="videoUploadModal"
        style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgb(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%;">
            <span id="closeModalBtn" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <h2>Upload Video</h2>
            <form action="/test" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="video">Video File:</label>
                    <input type="file" id="video" name="video" required>
                </div>
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
    <script async defer src="/assets/default/js/panel/flowpaper.min.js"></script>
    <script>
        (function($) {
            "use strict";

            var offlineSuccess = '{{ trans('panel.offline_success') }}';

            function handleNextBadgeChart() {
                const card = $('#nextBadgeChart');
                var percent = card.attr('data-percent');
                var label = card.attr('data-label');

                var options = {
                    series: [Number(percent)],
                    chart: {
                        height: 300,
                        width: "100%",
                        type: 'radialBar',
                        offsetY: -30,
                    },

                    plotOptions: {
                        radialBar: {
                            startAngle: -130,
                            endAngle: 130,
                            inverseOrder: true,

                            hollow: {
                                margin: 5,
                                size: '50%',
                                image: '/assets/default/img/radial-image.png',
                                imageWidth: 140,
                                imageHeight: 140,
                                imageClipped: false,
                            },
                            track: {
                                opacity: 0.4,
                                colors: '#222'
                            },
                            dataLabels: {
                                enabled: false,
                                enabledOnSeries: undefined,
                                formatter: function(val, opts) {
                                    return val + "%"
                                },
                                textAnchor: 'middle',
                                distributed: false,
                                offsetX: 0,
                                offsetY: 0,

                                style: {
                                    fontSize: '14px',
                                    fontFamily: 'Helvetica, Arial,  "Tajawal, sans-serif"',
                                    fill: ['#2b2b2b'],

                                },
                            },
                        }
                    },

                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            shadeIntensity: 0.05,
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100],
                            gradientToColors: ['#a927f9'],
                            type: 'horizontal'
                        },
                        strokeLinecap: 'round'
                    },
                    stroke: {
                        dashArray: 9,
                        strokecolor: ['#ffffff'],
                    },

                    labels: [label],
                    colors: ['#0d6efd'],
                };

                var chart = new ApexCharts(document.querySelector("#nextBadgeChart"), options);
                chart.render();
            }

            handleNextBadgeChart();
        })(jQuery)
    </script>
    <script src="/assets/default/js/panel/dashboard.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {

            const navbar = document.getElementById('navbar22');
            const scrollRightButton = document.getElementById('scroll-right1');
            const scrollLeftButton = document.getElementById('scroll-left1');
            scrollRightButton.addEventListener('click', function() {
                navbar.scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
            });
            scrollLeftButton.addEventListener('click', function() {
                navbar.scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
            });
            const activeItem = navbar.querySelector('.scroll-menu-item.active');
            if (activeItem) {
                const itemOffsetLeft = activeItem.offsetLeft;
                const itemWidth = activeItem.offsetWidth;
                const containerWidth = navbar.offsetWidth;

                const scrollPosition = itemOffsetLeft - (containerWidth / 2) + (itemWidth / 2);

                navbar.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            }
        });
    </script>
    <script type="text/javascript">
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer1", {
                title: {
                    text: "Vues Chart"
                },
                axisX: {
                    title: "timeline",
                    gridThickness: 2
                },
                axisY: {
                    title: "Vues"
                },
                data: [{
                    type: "area",
                    dataPoints: [ //array
                        {
                            x: new Date(2024, 02, 1),
                            y: 26
                        },
                        {
                            x: new Date(2024, 02, 3),
                            y: 38
                        },
                        {
                            x: new Date(2024, 02, 5),
                            y: 43
                        },
                        {
                            x: new Date(2024, 02, 7),
                            y: 29
                        },
                        {
                            x: new Date(2024, 02, 11),
                            y: 41
                        },
                        {
                            x: new Date(2024, 02, 13),
                            y: 54
                        },
                        {
                            x: new Date(2024, 02, 20),
                            y: 65
                        },
                        {
                            x: new Date(2024, 02, 21),
                            y: 60
                        },
                        {
                            x: new Date(2024, 02, 25),
                            y: 53
                        },
                        {
                            x: new Date(2024, 02, 27),
                            y: 60
                        }

                    ]
                }]
            });

            chart.render();
        }
    </script>
    <script type="text/javascript">
        let body = document.body;
        const btn = document.querySelector('.btn_toggle');
        const sidebar = document.querySelector('.side-bar');
        const logo = document.querySelector('.logo');

        btn.addEventListener("click", () => {
            sidebar.classList.toggle("active");
            body.classList.toggle('active');

            if (sidebar.classList.contains('active')) {
                logo.setAttribute("style", "display:flex");
                return
            }
            logo.setAttribute("style", "display:none");
        })
        let profile = document.querySelector('.head .flex .profile');
        document.querySelector('#user-btn').onclick = () => {
            profile.classList.toggle('active');
            searchForm.classList.remove('active');
        }
        let searchForm = document.querySelector('.head .flex .form');
        document.querySelector('#search-btn').onclick = () => {
            searchForm.classList.toggle('active');
            profile.classList.remove('active');
        }


        window.onscroll = () => {
            profile.classList.remove('active');
            searchForm.classList.remove('active');

        }
        let sideBar = document.querySelector('.side-bar');
        document.querySelector('#menu-btn').onclick = () => {
            sideBar.classList.toggle('active');
            body.classList.toggle('active');

        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function scrollHorizontally(direction) {
            var container = document.querySelector('.scroll-menu-container');
            var scrollAmount = 200; // Amount of pixels to scroll

            if (direction === 1) {
                // Scroll right
                container.scrollLeft += scrollAmount;
            } else {
                // Scroll left
                container.scrollLeft -= scrollAmount;
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const iframe = document.querySelector('iframe');

            iframe.addEventListener('load', function() {
                console.log('Iframe loaded');
                setupIframeListener(iframe);
                setupIframeBtnsClick(iframe);
                observeIframeChanges(iframe); // Observe dynamic changes
            });
        });

        function setupIframeBtnsClick(iframe) {
            if (iframe) {
                try {
                    const iframeDoc = iframe.contentWindow.document;
                    const leftBtn = iframeDoc.getElementById('pagesContainer_documentViewer_panelLeft');
                    const rightBtn = iframeDoc.getElementById('pagesContainer_documentViewer_panelRight');

                    if (leftBtn) {
                        leftBtn.addEventListener('click', function() {
                            console.log('Left button clicked');
                            setupIframeListener(iframe);
                        });
                    } else {
                        console.warn('Left button not found.');
                    }

                    if (rightBtn) {
                        rightBtn.addEventListener('click', function() {
                            console.log('Right button clicked');
                            setupIframeListener(iframe);
                        });
                    } else {
                        console.warn('Right button not found.');
                    }
                } catch (e) {
                    console.error('Error accessing iframe contents for buttons:', e);
                }
            }
        }

        function setupIframeListener(iframe) {
            if (iframe) {
                try {
                    const iframeDoc = iframe.contentWindow.document;
                    const links = iframeDoc.querySelectorAll('a[data-href]');

                    console.log("Found links in iframe:", links);

                    if (links.length === 0) {
                        console.warn("No links with data-href found.");
                        return;
                    }

                    links.forEach(link => {
                        if (!link.dataset.listenerAdded) { // Avoid adding multiple listeners
                            console.log("Adding listener to link:", link);

                            link.addEventListener('click', function(event) {
                                event.preventDefault();
                                event.stopImmediatePropagation();
                                console.log("Click intercepted for:", link);
                                alert("Click intercepted!");
                            });

                            link.dataset.listenerAdded = true; // Mark as listener added
                        }
                    });
                } catch (e) {
                    console.error('Error accessing iframe links:', e);
                }
            }
        }

        function observeIframeChanges(iframe) {
            if (!iframe) return;

            try {
                const iframeDoc = iframe.contentWindow.document;

                const observer = new MutationObserver((mutations) => {
                    console.log("Iframe content changed. Reattaching listeners.");

                    // Disconnect observer temporarily to prevent recursive loops
                    observer.disconnect();

                    // Re-attach listeners for newly added content
                    setupIframeListener(iframe);

                    // Reconnect observer after modifications
                    observer.observe(iframeDoc.body, {
                        childList: true,
                        subtree: true
                    });
                });

                observer.observe(iframeDoc.body, {
                    childList: true,
                    subtree: true
                });
            } catch (e) {
                console.error('Error setting up MutationObserver:', e);
            }
        }
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Function to scroll the menu
            function scrollHorizontally(direction) {
                var container = document.querySelector('.scroll-menu-container');
                var scrollAmount = 200; // Amount of pixels to scroll

                if (direction === 1) {
                    // Scroll right
                    container.scrollLeft += scrollAmount;
                } else {
                    // Scroll left
                    container.scrollLeft -= scrollAmount;
                }
            }

            // Bind the scrollHorizontally function to the left and right arrows
            document.querySelector('.scroll-left').addEventListener('click', function() {
                scrollHorizontally(-1);
            });

            document.querySelector('.scroll-right').addEventListener('click', function() {
                scrollHorizontally(1);
            });
        });

        $(document).ready(function() {
            // If you need any JS to scroll to a specific item or similar
            $('.scroll-menu-item').on('click', function(e) {
                e.preventDefault();
                $('.scroll-menu-container').scrollLeft($(this).position().left);
            });


        });

        document.getElementById('chartEmpty').style.display = 'none';

        document.getElementById('chartYear').style.display = 'block';

        document.getElementById('btnLastYear').addEventListener('click', function() {
            // alert('');
            document.getElementById('chartYear').style.display = 'block';
            document.getElementById('chartDay').style.display = 'none';
            document.getElementById('chartEmpty').style.display = 'none';
        });

        document.getElementById('btnLastDay').addEventListener('click', function() {
            document.getElementById('chartYear').style.display = 'none';
            document.getElementById('chartDay').style.display = 'block';
            document.getElementById('chartEmpty').style.display = 'none';
        });

        // Créer le graphique vide
        var ctxEmpty = document.getElementById('chartEmptyCanvas').getContext('2d');
        var chartEmpty = new Chart(ctxEmpty, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(0, 0, 0, 0)',
                    borderColor: 'rgba(0, 0, 0, 0)',
                    borderWidth: 0
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 14, // Modifier la taille de l'écriture
                                weight: 'bold', // Modifier le poids de l'écriture (par exemple : normal, bold)
                                family: "'Arial',  "
                                Tajawal,
                                sans - serif "" // Modifier la police de l'écriture
                            }
                        }
                    },

                }
            }
        });

        // Afficher le graphique vide au chargement de la page
        document.getElementById('chartEmpty').style.display = 'block';

        // Code JavaScript pour initialiser les graphiques avec les données appropriées
        var yearChartData = {
            !!$yearChartData!!
        };

        var moisYear = Object.keys(yearChartData);
        var vuesYear = moisYear.map(m => yearChartData[m].vues);
        var likesYear = moisYear.map(m => yearChartData[m].likes);

        var dayChartData = {
            !!$dayChartData!!
        };
        var jourDay = Object.keys(dayChartData);
        var vuesDay = Object.values(dayChartData).map(data => data.vues);
        var likesDay = Object.values(dayChartData).map(data => data.likes);

        var ctxYear = document.getElementById('chartYearCanvas').getContext('2d');
        var chartYear = new Chart(ctxYear, {
            type: 'bar',
            data: {
                labels: moisYear,
                datasets: [{
                        label: 'Number of views',
                        data: vuesYear,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Number of likes',
                        data: likesYear,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 14, // Modifier la taille de l'écriture
                                weight: 'bold', // Modifier le poids de l'écriture (par exemple : normal, bold)
                                family: "'Arial',  "
                                Tajawal,
                                sans - serif "" // Modifier la police de l'écriture
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                                weight: 'bold',
                                family: "'Arial',  "
                                Tajawal,
                                sans - serif ""
                            }
                        }
                    },
                }
            }
        });

        // Initialiser le graphique du dernier day
        var ctxDay = document.getElementById('chartDayCanvas').getContext('2d');
        var chartDay = new Chart(ctxDay, {
            type: 'bar',
            data: {
                labels: jourDay,
                datasets: [{
                        label: 'Nombre de vues',
                        data: vuesDay,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Nombre de likes',
                        data: likesDay,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 14, // Modifier la taille de l'écriture
                                weight: 'bold', // Modifier le poids de l'écriture (par exemple : normal, bold)
                                family: "'Arial',  "
                                Tajawal,
                                sans - serif "" // Modifier la police de l'écriture
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                                weight: 'bold',
                                family: "'Arial',  "
                                Tajawal,
                                sans - serif ""
                            }
                        }
                    },

                }
            }


        });
    </script>
@endpush
