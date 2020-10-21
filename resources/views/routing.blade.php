<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Directions Service (Complex)</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{$app->make('url')->to('/')}}/main.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.2/css/ol.css" type="text/css">
    <style>
        .logo img {
            height: 50px;
            width;
            50px;
        }

    </style>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgYIJ_notoMwRyPUsVJG-q_3lblcYDDd4&callback=initMap&libraries=&v=weekly"
        defer></script>
    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 500px;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #floating-panel {
            position: absolute;
            top: 90%;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: "Roboto", "sans-serif";
            line-height: 30px;
            padding-left: 10px;
        }

        #warnings-panel {
            display: none;
            width: 100%;
            height: 10%;
            text-align: center;
        }

    </style>
    <script>
        "use strict";

        function initMap() {
            const markerArray = []; // Instantiate a directions service.

            const directionsService = new google.maps.DirectionsService(); // Create a map and center it on Manhattan.

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: {
                    lat: 10.03,
                    long: 105.768
                }
            }); // Create a renderer for directions and bind it to the map.



            const directionsRenderer = new google.maps.DirectionsRenderer({
                map: map
            }); // Instantiate an info window to hold step text.

            const stepDisplay = new google.maps
        .InfoWindow(); // Display the route between the initial start and end selections.

            calculateAndDisplayRoute(
                directionsRenderer,
                directionsService,
                markerArray,
                stepDisplay,
                map
            ); // Listen to change events from the start and end lists.

            const onChangeHandler = function () {
                calculateAndDisplayRoute(
                    directionsRenderer,
                    directionsService,
                    markerArray,
                    stepDisplay,
                    map
                );
            };

            document
                .getElementById("start")
                .addEventListener("change", onChangeHandler);
            document
                .getElementById("end")
                .addEventListener("change", onChangeHandler);
        }

        function calculateAndDisplayRoute(
            directionsRenderer,
            directionsService,
            markerArray,
            stepDisplay,
            map
        ) {
            // First, remove any existing markers from the map.
            for (let i = 0; i < markerArray.length; i++) {
                markerArray[i].setMap(null);
            } // Retrieve the start and end locations and create a DirectionsRequest using
            // WALKING directions.

            directionsService.route({
                    origin: document.getElementById("start").value,
                    destination: document.getElementById("end").value,
                    travelMode: google.maps.TravelMode.WALKING
                },
                (result, status) => {
                    // Route the directions and pass the response to a function to create
                    // markers for each step.
                    if (status === "OK") {
                        document.getElementById("warnings-panel").innerHTML =
                            "<b>" + result.routes[0].warnings + "</b>";
                        directionsRenderer.setDirections(result);
                        showSteps(result, markerArray, stepDisplay, map);
                    } else {
                        window.alert("Directions request failed due to " + status);
                    }
                }
            );
        }

        function showSteps(directionResult, markerArray, stepDisplay, map) {
            // For each step, place a marker, and add the text to the marker's infowindow.
            // Also attach the marker to an array so we can keep track of it and remove it
            // when calculating new routes.
            const myRoute = directionResult.routes[0].legs[0];

            for (let i = 0; i < myRoute.steps.length; i++) {
                const marker = (markerArray[i] =
                    markerArray[i] || new google.maps.Marker());
                marker.setMap(map);
                marker.setPosition(myRoute.steps[i].start_location);
                attachInstructionText(
                    stepDisplay,
                    marker,
                    myRoute.steps[i].instructions,
                    map
                );
            }
        }

        function attachInstructionText(stepDisplay, marker, text, map) {
            google.maps.event.addListener(marker, "click", () => {
                // Open an info window when the marker is clicked on, containing the text
                // of the step.
                stepDisplay.setContent(text);
                stepDisplay.open(map, marker);
            });
        }

    </script>
</head>

<body>

    <div class="app-container app-theme-white body-tabs-shadow fixed-header">
        <!-- Sidebar -->
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo"><img
                        src="data:image/png;base64,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" />
                </div>
            </div>

            <div class="app-header__menu">
                <span>
                    <button type="button"
                        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">

                                    <a href="{{route('dashboard')}}">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-main">
            <div class="app-main__outer">
                <!-- Content -->
                <div class="app-main__inner">
                  <!--
                  <div class="app-page-title">
                      <div class="page-title-wrapper">
                          <div class="page-title-heading">
                              <div class="page-title-icon">
                                  <i class="pe-7s-map icon-gradient bg-premium-dark">
                                  </i>
                              </div>
                              <div>Bản đồ
                                  <div class="page-title-subheading">Bản đồ ĐHCT khu II
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  -->
                  <div class="row">
                      <div class="col-md-12">
                          <div class="main-card mb-3 card">
                              <div class="card-body">
                                  <div class="card-title">{{__("message.map.title")}}</div>
                                  <ul class="nav nav-tabs">
                                      <li class="nav-item"><a href="{{route('index')}}" class="nav-link">Bản đồ CTU</a></li>
                                      <li class="nav-item"><a href="{{route('sport-view')}}" class="nav-link">Sân Chơi</a></li>
                                      <li class="nav-item"><a href="{{route('routing-view')}}" class="active nav-link">Tìm đường đi</a></li>
                                  </ul>
          
                                  <div id="app" class="tab-content">
                                      <div id="floating-panel">
                                          <b>Start: </b>
                                          <select id="start">
                      
                                              <option value=" Khoa Công nghệ, Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Công nghệ
                                              </option>
                                              <option value=" Khoa Công nghệ Thông tin & Truyền thông Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Khoa Công nghệ Thông tin & Truyền thông </option>
                                              <option value=" Khoa Dự bị Dân tộc Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Dự bị Dân tộc
                                              </option>
                                              <option value=" Khoa Khoa học Chính trị Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học
                                                  Chính trị </option>
                                              <option value=" Khoa Khoa học Tự nhiên Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học Tự
                                                  nhiên </option>
                                              <option value=" Khoa Khoa học Xã hội & Nhân văn Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa
                                                  Khoa học Xã hội & Nhân văn </option>
                                              <option value=" Khoa Kinh tế, Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Kinh tế </option>
                                              <option value=" Khoa Luật Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Luật </option>
                                              <option
                                                  value=" Khoa Môi trường & Tài nguyên Thiên nhiên Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Khoa Môi trường & Tài nguyên Thiên nhiên </option>
                                              <option value=" Khoa Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Ngoại ngữ </option>
                                              <option value=" Khoa Nông nghiệp Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Nông nghiệp
                                              </option>
                                              <option value=" Khoa Phát triển Nông thôn Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Phát
                                                  triển Nông thôn </option>
                                              <option value=" Khoa Sau đại học Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Sau đại học
                                              </option>
                                              <option value=" Khoa Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Sư phạm </option>
                                              <option value=" Khoa Thủy sản Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Thủy sản </option>
                                              <option value=" Bộ môn Giáo dục Thể chất Đại học Cần Thơ, Can Tho city, Vietnam"> Bộ môn Giáo
                                                  dục Thể chất </option>
                                              <option value=" Viện Nghiên cứu Biến đổi Khí Hậu Đại học Cần Thơ, Can Tho city, Vietnam"> Viện
                                                  Nghiên cứu Biến đổi Khí Hậu </option>
                                              <option value=" Viện Nghiên cứu Phát triển ĐBSCL Đại học Cần Thơ, Can Tho city, Vietnam"> Viện
                                                  Nghiên cứu Phát triển ĐBSCL </option>
                                              <option value=" Viện NC & Phát triển Công nghệ Sinh học Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Viện NC & Phát triển Công nghệ Sinh học </option>
                                              <option value=" Trường THPT Thực hành Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Trường
                                                  THPT Thực hành Sư phạm </option>
                                              <option value=" Trung tâm Bồi dưỡng Nghiệp vụ Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Bồi dưỡng Nghiệp vụ Sư phạm </option>
                                              <option
                                                  value=" Trung tâm Chuyển giao Công nghệ và Dịch vụ Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Chuyển giao Công nghệ và Dịch vụ </option>
                                              <option value=" Trung tâm Công nghệ Phần mềm Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm
                                                  Công nghệ Phần mềm </option>
                                              <option value=" Trung tâm Dịch vụ Khoa học Nông nghiệp Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Dịch vụ Khoa học Nông nghiệp </option>
                                              <option value=" Trung tâm Đánh giá năng lực Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Đánh giá năng lực Ngoại ngữ </option>
                                              <option value=" Trung tâm Đào tạo, NC và Tư vấn kinh tế Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Đào tạo, NC và Tư vấn kinh tế </option>
                                              <option value=" Trung tâm Điện - Điện tử Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Điện
                                                  - Điện tử </option>
                                              <option value=" Trung tâm Điện tử Tin học Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm
                                                  Điện tử Tin học </option>
                                              <option value=" Trung tâm Giáo dục Quốc phòng & An ninh Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Giáo dục Quốc phòng & An ninh </option>
                                              <option value=" Trung tâm Học liệu Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Học liệu
                                              </option>
                                              <option value=" Trung tâm Kiểm định và Tư vấn Xây dựng Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Kiểm định và Tư vấn Xây dựng </option>
                                              <option value=" Trung tâm Liên kết Đào tạo Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm
                                                  Liên kết Đào tạo </option>
                                              <option value=" Trung tâm NC và Ứng dụng công nghệ Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm NC và Ứng dụng công nghệ </option>
                                              <option value=" Trung tâm Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Ngoại ngữ
                                              </option>
                                              <option value=" Trung tâm Quản lý chất lượng Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm
                                                  Quản lý chất lượng </option>
                                              <option value=" Trung tâm Thông tin và Quản trị mạng Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Thông tin và Quản trị mạng </option>
                                              <option
                                                  value=" Trung tâm Tư vấn, Hỗ trợ và Khởi nghiệp sinh viên Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Tư vấn, Hỗ trợ và Khởi nghiệp sinh viên </option>
                                              <option value=" Công ty TNHH một thành viên KHCN Đại học Cần Thơ, Can Tho city, Vietnam"> Công
                                                  ty TNHH một thành viên KHCN </option>
                                              <option value=" Phòng Công tác Chính trị Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Công tác
                                                  Chính trị </option>
                                              <option value=" Phòng Công tác Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Công tác
                                                  Sinh viên </option>
                                              <option value=" Phòng Đào tạo Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Đào tạo </option>
                                              <option value=" Phòng Hợp tác Quốc tế Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Hợp tác
                                                  Quốc tế </option>
                                              <option value=" Phòng Kế hoạch Tổng hợp Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Kế hoạch
                                                  Tổng hợp </option>
                                              <option value=" Phòng Quản lý Khoa học Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Quản lý
                                                  Khoa học </option>
                                              <option value=" Phòng Quản trị-Thiết bị Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Quản
                                                  trị-Thiết bị </option>
                                              <option value=" Phòng Tài chính Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Tài chính
                                              </option>
                                              <option value=" Phòng Thanh tra - Pháp chế Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Thanh
                                                  tra - Pháp chế </option>
                                              <option value=" Phòng Tổ chức-Cán bộ Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Tổ chức-Cán
                                                  bộ </option>
                                              <option value=" Ban Quản lý dự án ODA Đại học Cần Thơ, Can Tho city, Vietnam"> Ban Quản lý dự án
                                                  ODA </option>
                                              <option value=" Không gian sáng chế Đại học Cần Thơ, Can Tho city, Vietnam"> Không gian sáng chế
                                              </option>
                                              <option value=" Nhà Xuất Bản Đại học Cần Thơ Đại học Cần Thơ, Can Tho city, Vietnam"> Nhà Xuất
                                                  Bản Đại học Cần Thơ </option>
                                              <option value=" Tạp chí Khoa học Trường ĐHCT Đại học Cần Thơ, Can Tho city, Vietnam"> Tạp chí
                                                  Khoa học Trường ĐHCT </option>
                                              <option value=" Công Ðoàn Trường Đại học Cần Thơ, Can Tho city, Vietnam"> Công Ðoàn Trường
                                              </option>
                                              <option value=" Ðoàn Thanh niên CSHCM & Hội Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Ðoàn Thanh niên CSHCM & Hội Sinh viên </option>
                                              <option value=" Văn phòng Ðảng ủy Đại học Cần Thơ, Can Tho city, Vietnam"> Văn phòng Ðảng ủy
                                              </option>
                                              <option value=" Hội Cựu Chiến binh Đại học Cần Thơ, Can Tho city, Vietnam"> Hội Cựu Chiến binh
                                              </option>
                                              <option value=" Hội Cựu Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Hội Cựu Sinh viên
                                              </option>
                      
                                          </select>
                                          <b>End: </b>
                                          <select id="end">
                                              <option value=" Khoa Công nghệ Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Công nghệ </option>
                                              <option value=" Khoa Công nghệ Thông tin & Truyền thông Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Khoa Công nghệ Thông tin & Truyền thông </option>
                                              <option value=" Khoa Dự bị Dân tộc Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Dự bị Dân tộc
                                              </option>
                                              <option value=" Khoa Khoa học Chính trị Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học
                                                  Chính trị </option>
                                              <option value=" Khoa Khoa học Tự nhiên Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học Tự
                                                  nhiên </option>
                                              <option value=" Khoa Khoa học Xã hội & Nhân văn Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa
                                                  Khoa học Xã hội & Nhân văn </option>
                                              <option value=" Khoa Kinh tế Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Kinh tế </option>
                                              <option value=" Khoa Luật Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Luật </option>
                                              <option
                                                  value=" Khoa Môi trường & Tài nguyên Thiên nhiên Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Khoa Môi trường & Tài nguyên Thiên nhiên </option>
                                              <option value=" Khoa Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Ngoại ngữ </option>
                                              <option value=" Khoa Nông nghiệp Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Nông nghiệp
                                              </option>
                                              <option value=" Khoa Phát triển Nông thôn Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Phát
                                                  triển Nông thôn </option>
                                              <option value=" Khoa Sau đại học Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Sau đại học
                                              </option>
                                              <option value=" Khoa Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Sư phạm </option>
                                              <option value=" Khoa Thủy sản Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Thủy sản </option>
                                              <option value=" Bộ môn Giáo dục Thể chất Đại học Cần Thơ, Can Tho city, Vietnam"> Bộ môn Giáo
                                                  dục Thể chất </option>
                                              <option value=" Viện Nghiên cứu Biến đổi Khí Hậu Đại học Cần Thơ, Can Tho city, Vietnam"> Viện
                                                  Nghiên cứu Biến đổi Khí Hậu </option>
                                              <option value=" Viện Nghiên cứu Phát triển ĐBSCL Đại học Cần Thơ, Can Tho city, Vietnam"> Viện
                                                  Nghiên cứu Phát triển ĐBSCL </option>
                                              <option value=" Viện NC & Phát triển Công nghệ Sinh học Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Viện NC & Phát triển Công nghệ Sinh học </option>
                                              <option value=" Trường THPT Thực hành Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Trường
                                                  THPT Thực hành Sư phạm </option>
                                              <option value=" Trung tâm Bồi dưỡng Nghiệp vụ Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Bồi dưỡng Nghiệp vụ Sư phạm </option>
                                              <option
                                                  value=" Trung tâm Chuyển giao Công nghệ và Dịch vụ Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Chuyển giao Công nghệ và Dịch vụ </option>
                                              <option value=" Trung tâm Công nghệ Phần mềm Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm
                                                  Công nghệ Phần mềm </option>
                                              <option value=" Trung tâm Dịch vụ Khoa học Nông nghiệp Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Dịch vụ Khoa học Nông nghiệp </option>
                                              <option value=" Trung tâm Đánh giá năng lực Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Đánh giá năng lực Ngoại ngữ </option>
                                              <option value=" Trung tâm Đào tạo, NC và Tư vấn kinh tế Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Đào tạo, NC và Tư vấn kinh tế </option>
                                              <option value=" Trung tâm Điện - Điện tử Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Điện
                                                  - Điện tử </option>
                                              <option value=" Trung tâm Điện tử Tin học Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm
                                                  Điện tử Tin học </option>
                                              <option value=" Trung tâm Giáo dục Quốc phòng & An ninh Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Giáo dục Quốc phòng & An ninh </option>
                                              <option value=" Trung tâm Học liệu Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Học liệu
                                              </option>
                                              <option value=" Trung tâm Kiểm định và Tư vấn Xây dựng Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Kiểm định và Tư vấn Xây dựng </option>
                                              <option value=" Trung tâm Liên kết Đào tạo Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm
                                                  Liên kết Đào tạo </option>
                                              <option value=" Trung tâm NC và Ứng dụng công nghệ Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm NC và Ứng dụng công nghệ </option>
                                              <option value=" Trung tâm Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Ngoại ngữ
                                              </option>
                                              <option value=" Trung tâm Quản lý chất lượng Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm
                                                  Quản lý chất lượng </option>
                                              <option value=" Trung tâm Thông tin và Quản trị mạng Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Thông tin và Quản trị mạng </option>
                                              <option
                                                  value=" Trung tâm Tư vấn, Hỗ trợ và Khởi nghiệp sinh viên Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Trung tâm Tư vấn, Hỗ trợ và Khởi nghiệp sinh viên </option>
                                              <option value=" Công ty TNHH một thành viên KHCN Đại học Cần Thơ, Can Tho city, Vietnam"> Công
                                                  ty TNHH một thành viên KHCN </option>
                                              <option value=" Phòng Công tác Chính trị Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Công tác
                                                  Chính trị </option>
                                              <option value=" Phòng Công tác Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Công tác
                                                  Sinh viên </option>
                                              <option value=" Phòng Đào tạo Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Đào tạo </option>
                                              <option value=" Phòng Hợp tác Quốc tế Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Hợp tác
                                                  Quốc tế </option>
                                              <option value=" Phòng Kế hoạch Tổng hợp Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Kế hoạch
                                                  Tổng hợp </option>
                                              <option value=" Phòng Quản lý Khoa học Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Quản lý
                                                  Khoa học </option>
                                              <option value=" Phòng Quản trị-Thiết bị Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Quản
                                                  trị-Thiết bị </option>
                                              <option value=" Phòng Tài chính Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Tài chính
                                              </option>
                                              <option value=" Phòng Thanh tra - Pháp chế Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Thanh
                                                  tra - Pháp chế </option>
                                              <option value=" Phòng Tổ chức-Cán bộ Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Tổ chức-Cán
                                                  bộ </option>
                                              <option value=" Ban Quản lý dự án ODA Đại học Cần Thơ, Can Tho city, Vietnam"> Ban Quản lý dự án
                                                  ODA </option>
                                              <option value=" Không gian sáng chế Đại học Cần Thơ, Can Tho city, Vietnam"> Không gian sáng chế
                                              </option>
                                              <option value=" Nhà Xuất Bản Đại học Cần Thơ Đại học Cần Thơ, Can Tho city, Vietnam"> Nhà Xuất
                                                  Bản Đại học Cần Thơ </option>
                                              <option value=" Tạp chí Khoa học Trường ĐHCT Đại học Cần Thơ, Can Tho city, Vietnam"> Tạp chí
                                                  Khoa học Trường ĐHCT </option>
                                              <option value=" Công Ðoàn Trường Đại học Cần Thơ, Can Tho city, Vietnam"> Công Ðoàn Trường
                                              </option>
                                              <option value=" Ðoàn Thanh niên CSHCM & Hội Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam">
                                                  Ðoàn Thanh niên CSHCM & Hội Sinh viên </option>
                                              <option value=" Văn phòng Ðảng ủy Đại học Cần Thơ, Can Tho city, Vietnam"> Văn phòng Ðảng ủy
                                              </option>
                                              <option value=" Hội Cựu Chiến binh Đại học Cần Thơ, Can Tho city, Vietnam"> Hội Cựu Chiến binh
                                              </option>
                                              <option value=" Hội Cựu Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Hội Cựu Sinh viên
                                              </option>
                      
                                          </select>
                                      </div>
                                      <div id="map"></div>
                                      &nbsp;
                                  </div>

                                  <div id="warnings-panel"></div>
                              </div>
                          </div>
                      </div>
          
                  </div>
              </div>
                <!-- Content -->
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-left">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="{{route('change-laguage', ['vi'])}}" class="nav-link">
                                            Tiếng việt
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('change-laguage', ['en'])}}" class="nav-link">
                                            English
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="app-footer-right">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            Footer Link 3
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            <div class="badge badge-success mr-1 ml-0">
                                                <small>NEW</small>
                                            </div>
                                            Footer Link 4
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //var x = document.getElementById("demo");
        getLocation();

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var para = document.createElement("option");
            //var node = document.createTextNode(position.coords.latitude + "," + position.coords.longitude);
            para.value = position.coords.latitude + "," + position.coords.longitude;
            para.innerHTML = "Vị trí của tôi";
            //para.appendChild(node);
            var element = document.getElementById("start");
            //element.appendChild(para);
            element.add(para, element[0]);
            element.selectedIndex = "0";
            //x.innerHTML = "Vị trí của tôi: " + position.coords.latitude + "," + position.coords.longitude;
        }

    </script>
</body>

</html>