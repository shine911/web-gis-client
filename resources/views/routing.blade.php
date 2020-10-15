<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Directions Service (Complex)</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgYIJ_notoMwRyPUsVJG-q_3lblcYDDd4&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
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
        top: 10px;
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

        const stepDisplay = new google.maps.InfoWindow(); // Display the route between the initial start and end selections.

        calculateAndDisplayRoute(
          directionsRenderer,
          directionsService,
          markerArray,
          stepDisplay,
          map
        ); // Listen to change events from the start and end lists.

        const onChangeHandler = function() {
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

        directionsService.route(
          {
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
   	

    <div id="floating-panel">
	
    <!--
    <p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p>-->
      <b>Start: </b>
      <select id="start">
	  
          <option value=" Khoa Công nghệ, Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Công nghệ </option>
          <option value=" Khoa Công nghệ Thông tin & Truyền thông Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Công nghệ Thông tin & Truyền thông </option>
          <option value=" Khoa Dự bị Dân tộc Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Dự bị Dân tộc </option>
          <option value=" Khoa Khoa học Chính trị Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học Chính trị </option>
          <option value=" Khoa Khoa học Tự nhiên Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học Tự nhiên </option>
          <option value=" Khoa Khoa học Xã hội & Nhân văn Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học Xã hội & Nhân văn </option>
          <option value=" Khoa Kinh tế, Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Kinh tế </option>
          <option value=" Khoa Luật Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Luật </option>
          <option value=" Khoa Môi trường & Tài nguyên Thiên nhiên Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Môi trường & Tài nguyên Thiên nhiên </option>
          <option value=" Khoa Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Ngoại ngữ </option>
          <option value=" Khoa Nông nghiệp Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Nông nghiệp </option>
          <option value=" Khoa Phát triển Nông thôn Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Phát triển Nông thôn </option>
          <option value=" Khoa Sau đại học Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Sau đại học </option>
          <option value=" Khoa Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Sư phạm </option>
          <option value=" Khoa Thủy sản Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Thủy sản </option>
          <option value=" Bộ môn Giáo dục Thể chất Đại học Cần Thơ, Can Tho city, Vietnam"> Bộ môn Giáo dục Thể chất </option>
          <option value=" Viện Nghiên cứu Biến đổi Khí Hậu Đại học Cần Thơ, Can Tho city, Vietnam"> Viện Nghiên cứu Biến đổi Khí Hậu </option>
          <option value=" Viện Nghiên cứu Phát triển ĐBSCL Đại học Cần Thơ, Can Tho city, Vietnam"> Viện Nghiên cứu Phát triển ĐBSCL </option>
          <option value=" Viện NC & Phát triển Công nghệ Sinh học Đại học Cần Thơ, Can Tho city, Vietnam"> Viện NC & Phát triển Công nghệ Sinh học </option>
          <option value=" Trường THPT Thực hành Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Trường THPT Thực hành Sư phạm </option>
          <option value=" Trung tâm Bồi dưỡng Nghiệp vụ Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Bồi dưỡng Nghiệp vụ Sư phạm </option>
          <option value=" Trung tâm Chuyển giao Công nghệ và Dịch vụ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Chuyển giao Công nghệ và Dịch vụ </option>
          <option value=" Trung tâm Công nghệ Phần mềm Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Công nghệ Phần mềm </option>
          <option value=" Trung tâm Dịch vụ Khoa học Nông nghiệp Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Dịch vụ Khoa học Nông nghiệp </option>
          <option value=" Trung tâm Đánh giá năng lực Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Đánh giá năng lực Ngoại ngữ </option>
          <option value=" Trung tâm Đào tạo, NC và Tư vấn kinh tế Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Đào tạo, NC và Tư vấn kinh tế </option>
          <option value=" Trung tâm Điện - Điện tử Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Điện - Điện tử </option>
          <option value=" Trung tâm Điện tử Tin học Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Điện tử Tin học </option>
          <option value=" Trung tâm Giáo dục Quốc phòng & An ninh Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Giáo dục Quốc phòng & An ninh </option>
          <option value=" Trung tâm Học liệu Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Học liệu </option>
          <option value=" Trung tâm Kiểm định và Tư vấn Xây dựng Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Kiểm định và Tư vấn Xây dựng </option>
          <option value=" Trung tâm Liên kết Đào tạo Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Liên kết Đào tạo </option>
          <option value=" Trung tâm NC và Ứng dụng công nghệ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm NC và Ứng dụng công nghệ </option>
          <option value=" Trung tâm Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Ngoại ngữ </option>
          <option value=" Trung tâm Quản lý chất lượng Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Quản lý chất lượng </option>
          <option value=" Trung tâm Thông tin và Quản trị mạng Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Thông tin và Quản trị mạng </option>
          <option value=" Trung tâm Tư vấn, Hỗ trợ và Khởi nghiệp sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Tư vấn, Hỗ trợ và Khởi nghiệp sinh viên </option>
          <option value=" Công ty TNHH một thành viên KHCN Đại học Cần Thơ, Can Tho city, Vietnam"> Công ty TNHH một thành viên KHCN </option>
          <option value=" Phòng Công tác Chính trị Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Công tác Chính trị </option>
          <option value=" Phòng Công tác Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Công tác Sinh viên </option>
          <option value=" Phòng Đào tạo Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Đào tạo </option>
          <option value=" Phòng Hợp tác Quốc tế Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Hợp tác Quốc tế </option>
          <option value=" Phòng Kế hoạch Tổng hợp Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Kế hoạch Tổng hợp </option>
          <option value=" Phòng Quản lý Khoa học Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Quản lý Khoa học </option>
          <option value=" Phòng Quản trị-Thiết bị Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Quản trị-Thiết bị </option>
          <option value=" Phòng Tài chính Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Tài chính </option>
          <option value=" Phòng Thanh tra - Pháp chế Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Thanh tra - Pháp chế </option>
          <option value=" Phòng Tổ chức-Cán bộ Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Tổ chức-Cán bộ </option>
          <option value=" Ban Quản lý dự án ODA Đại học Cần Thơ, Can Tho city, Vietnam"> Ban Quản lý dự án ODA </option>
          <option value=" Không gian sáng chế Đại học Cần Thơ, Can Tho city, Vietnam"> Không gian sáng chế </option>
          <option value=" Nhà Xuất Bản Đại học Cần Thơ Đại học Cần Thơ, Can Tho city, Vietnam"> Nhà Xuất Bản Đại học Cần Thơ </option>
          <option value=" Tạp chí Khoa học Trường ĐHCT Đại học Cần Thơ, Can Tho city, Vietnam"> Tạp chí Khoa học Trường ĐHCT </option>
          <option value=" Công Ðoàn Trường Đại học Cần Thơ, Can Tho city, Vietnam"> Công Ðoàn Trường </option>
          <option value=" Ðoàn Thanh niên CSHCM & Hội Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Ðoàn Thanh niên CSHCM & Hội Sinh viên </option>
          <option value=" Văn phòng Ðảng ủy Đại học Cần Thơ, Can Tho city, Vietnam"> Văn phòng Ðảng ủy </option>
          <option value=" Hội Cựu Chiến binh Đại học Cần Thơ, Can Tho city, Vietnam"> Hội Cựu Chiến binh </option>
          <option value=" Hội Cựu Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Hội Cựu Sinh viên </option>

      </select>
      <b>End: </b>
      <select id="end">
          <option value=" Khoa Công nghệ Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Công nghệ </option>
          <option value=" Khoa Công nghệ Thông tin & Truyền thông Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Công nghệ Thông tin & Truyền thông </option>
          <option value=" Khoa Dự bị Dân tộc Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Dự bị Dân tộc </option>
          <option value=" Khoa Khoa học Chính trị Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học Chính trị </option>
          <option value=" Khoa Khoa học Tự nhiên Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học Tự nhiên </option>
          <option value=" Khoa Khoa học Xã hội & Nhân văn Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Khoa học Xã hội & Nhân văn </option>
          <option value=" Khoa Kinh tế Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Kinh tế </option>
          <option value=" Khoa Luật Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Luật </option>
          <option value=" Khoa Môi trường & Tài nguyên Thiên nhiên Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Môi trường & Tài nguyên Thiên nhiên </option>
          <option value=" Khoa Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Ngoại ngữ </option>
          <option value=" Khoa Nông nghiệp Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Nông nghiệp </option>
          <option value=" Khoa Phát triển Nông thôn Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Phát triển Nông thôn </option>
          <option value=" Khoa Sau đại học Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Sau đại học </option>
          <option value=" Khoa Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Sư phạm </option>
          <option value=" Khoa Thủy sản Đại học Cần Thơ, Can Tho city, Vietnam"> Khoa Thủy sản </option>
          <option value=" Bộ môn Giáo dục Thể chất Đại học Cần Thơ, Can Tho city, Vietnam"> Bộ môn Giáo dục Thể chất </option>
          <option value=" Viện Nghiên cứu Biến đổi Khí Hậu Đại học Cần Thơ, Can Tho city, Vietnam"> Viện Nghiên cứu Biến đổi Khí Hậu </option>
          <option value=" Viện Nghiên cứu Phát triển ĐBSCL Đại học Cần Thơ, Can Tho city, Vietnam"> Viện Nghiên cứu Phát triển ĐBSCL </option>
          <option value=" Viện NC & Phát triển Công nghệ Sinh học Đại học Cần Thơ, Can Tho city, Vietnam"> Viện NC & Phát triển Công nghệ Sinh học </option>
          <option value=" Trường THPT Thực hành Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Trường THPT Thực hành Sư phạm </option>
          <option value=" Trung tâm Bồi dưỡng Nghiệp vụ Sư phạm Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Bồi dưỡng Nghiệp vụ Sư phạm </option>
          <option value=" Trung tâm Chuyển giao Công nghệ và Dịch vụ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Chuyển giao Công nghệ và Dịch vụ </option>
          <option value=" Trung tâm Công nghệ Phần mềm Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Công nghệ Phần mềm </option>
          <option value=" Trung tâm Dịch vụ Khoa học Nông nghiệp Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Dịch vụ Khoa học Nông nghiệp </option>
          <option value=" Trung tâm Đánh giá năng lực Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Đánh giá năng lực Ngoại ngữ </option>
          <option value=" Trung tâm Đào tạo, NC và Tư vấn kinh tế Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Đào tạo, NC và Tư vấn kinh tế </option>
          <option value=" Trung tâm Điện - Điện tử Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Điện - Điện tử </option>
          <option value=" Trung tâm Điện tử Tin học Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Điện tử Tin học </option>
          <option value=" Trung tâm Giáo dục Quốc phòng & An ninh Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Giáo dục Quốc phòng & An ninh </option>
          <option value=" Trung tâm Học liệu Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Học liệu </option>
          <option value=" Trung tâm Kiểm định và Tư vấn Xây dựng Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Kiểm định và Tư vấn Xây dựng </option>
          <option value=" Trung tâm Liên kết Đào tạo Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Liên kết Đào tạo </option>
          <option value=" Trung tâm NC và Ứng dụng công nghệ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm NC và Ứng dụng công nghệ </option>
          <option value=" Trung tâm Ngoại ngữ Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Ngoại ngữ </option>
          <option value=" Trung tâm Quản lý chất lượng Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Quản lý chất lượng </option>
          <option value=" Trung tâm Thông tin và Quản trị mạng Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Thông tin và Quản trị mạng </option>
          <option value=" Trung tâm Tư vấn, Hỗ trợ và Khởi nghiệp sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Trung tâm Tư vấn, Hỗ trợ và Khởi nghiệp sinh viên </option>
          <option value=" Công ty TNHH một thành viên KHCN Đại học Cần Thơ, Can Tho city, Vietnam"> Công ty TNHH một thành viên KHCN </option>
          <option value=" Phòng Công tác Chính trị Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Công tác Chính trị </option>
          <option value=" Phòng Công tác Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Công tác Sinh viên </option>
          <option value=" Phòng Đào tạo Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Đào tạo </option>
          <option value=" Phòng Hợp tác Quốc tế Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Hợp tác Quốc tế </option>
          <option value=" Phòng Kế hoạch Tổng hợp Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Kế hoạch Tổng hợp </option>
          <option value=" Phòng Quản lý Khoa học Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Quản lý Khoa học </option>
          <option value=" Phòng Quản trị-Thiết bị Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Quản trị-Thiết bị </option>
          <option value=" Phòng Tài chính Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Tài chính </option>
          <option value=" Phòng Thanh tra - Pháp chế Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Thanh tra - Pháp chế </option>
          <option value=" Phòng Tổ chức-Cán bộ Đại học Cần Thơ, Can Tho city, Vietnam"> Phòng Tổ chức-Cán bộ </option>
          <option value=" Ban Quản lý dự án ODA Đại học Cần Thơ, Can Tho city, Vietnam"> Ban Quản lý dự án ODA </option>
          <option value=" Không gian sáng chế Đại học Cần Thơ, Can Tho city, Vietnam"> Không gian sáng chế </option>
          <option value=" Nhà Xuất Bản Đại học Cần Thơ Đại học Cần Thơ, Can Tho city, Vietnam"> Nhà Xuất Bản Đại học Cần Thơ </option>
          <option value=" Tạp chí Khoa học Trường ĐHCT Đại học Cần Thơ, Can Tho city, Vietnam"> Tạp chí Khoa học Trường ĐHCT </option>
          <option value=" Công Ðoàn Trường Đại học Cần Thơ, Can Tho city, Vietnam"> Công Ðoàn Trường </option>
          <option value=" Ðoàn Thanh niên CSHCM & Hội Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Ðoàn Thanh niên CSHCM & Hội Sinh viên </option>
          <option value=" Văn phòng Ðảng ủy Đại học Cần Thơ, Can Tho city, Vietnam"> Văn phòng Ðảng ủy </option>
          <option value=" Hội Cựu Chiến binh Đại học Cần Thơ, Can Tho city, Vietnam"> Hội Cựu Chiến binh </option>
          <option value=" Hội Cựu Sinh viên Đại học Cần Thơ, Can Tho city, Vietnam"> Hội Cựu Sinh viên </option>

      </select>


	
    </div>
    <div id="map"></div>
    &nbsp;
    <div id="warnings-panel"></div>



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
  element.add(para,element[0]);
  element.selectedIndex = "0";
  //x.innerHTML = "Vị trí của tôi: " + position.coords.latitude + "," + position.coords.longitude;
}
</script>
  </body>
</html>