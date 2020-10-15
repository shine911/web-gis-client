<template>
  <div>
    <vl-map
      id="map2"
      ref="map"
      style="height: 500px"
      :load-tiles-while-animating="true"
      :load-tiles-while-interacting="true"
      @postcompose="onMapPostCompose"
    >
      <vl-view
        :zoom.sync="zoom"
        :center.sync="center"
        :rotation.sync="rotation"
      >
        <vl-layer-tile class="base-layer" :z-index="0">
          <vl-source-osm></vl-source-osm>
        </vl-layer-tile>
        <vl-layer-vector :z-index="1">
          <vl-source-vector :features.sync="sportGrounds"></vl-source-vector>
        </vl-layer-vector>
        <vl-layer-vector id="sport" :z-index="2" render="image">
          <vl-source-vector :features.sync="features"></vl-source-vector>
          <vl-style-box :condition="isRed">
            <vl-style-icon
              src="./assets/images/icon_red.svg"
              :scale="1"
            ></vl-style-icon>
          </vl-style-box>
          <vl-style-box :condition="isGreen" >
              <vl-style-icon
              src="./assets/images/icon_green.svg"
              :scale="1"></vl-style-icon>
          </vl-style-box>
        </vl-layer-vector>

      <!-- My point Layer -->
      <!-- geolocation -->
      <vl-geoloc @update:position="onUpdatePosition" >
        <template slot-scope="geoloc">
          <vl-feature ref="marker" :properties="{ start: Date.now(), duration: 2500 }" v-if="geoloc.position" id="position-feature">
            <vl-geom-point :coordinates="geoloc.position"></vl-geom-point>
            <vl-style-box>
              <vl-style-icon src="./assets/images/marker.png" :scale="0.4" :anchor="[0.5, 0.95]" :size="[128, 128]"></vl-style-icon>
            </vl-style-box>
          </vl-feature>
        </template>
      </vl-geoloc>
      <!--// geolocation -->

        <vl-interaction-select
          :features.sync="selectedFeatures"
          :layers="['sport']"
        >
          <template slot-scope="select">
            <!-- select styles -->
            <vl-style-box>
              <vl-style-icon
                src="./assets/images/icon_blue.svg"
                :scale="1"
              ></vl-style-icon>
            </vl-style-box>
            <!--// select styles -->

            <!-- selected feature popup -->
            <vl-overlay
              class="feature-popup"
              v-for="feature in select.features"
              :key="feature.id"
              :id="feature.id"
              :position="pointOnSurface(feature.geometry)"
              :auto-pan="true"
              :auto-pan-animation="{ duration: 300 }"
              :offset="[10, 10]"
            >
              <template slot-scope="popup">
                <section class="card">
                  <div class="card-body">
                    <div class="card-title">
                      Thông tin địa điểm
                      <a
                        class="card-header-icon"
                        title="Close"
                        @click="
                          selectedFeatures = selectedFeatures.filter(
                            (f) => f.id !== feature.id
                          )
                        "
                        >x</a
                      >
                    </div>
                    <div class="content">
                      <ul>
                        <li>Địa điểm: {{ feature.properties.diadiem }}</li>
                        <li>
                          Khu Vực: {{ feature.properties.makhuvuc }} -
                          {{ feature.properties.tenkhuvuc }}
                        </li>
                        <li>Tên: {{ feature.properties.tendiadiem }}</li>
                        <li>
                          Trạng thái:
                          {{
                            feature.properties.state == 'YES'
                              ? "Đang hoạt động"
                              : "Không hoạt động"
                          }}
                        </li>
                        <li>Hoạt động: {{ feature.properties.activeName }}</li>
                      </ul>
                    </div>
                  </div>
                </section>
              </template>
            </vl-overlay>
            <!--// selected popup -->
          </template>
        </vl-interaction-select>
        <b-spinner v-if="loading"></b-spinner>
      </vl-view>
    </vl-map>
  </div>
</template>

<script>
import axios from "axios";
import { findPointOnSurface, createStyle } from "vuelayers/lib/ol-ext";
import ScaleLine from "ol/control/ScaleLine";
import FullScreen from "ol/control/FullScreen";
import OverviewMap from "ol/control/OverviewMap";
import ZoomSlider from "ol/control/ZoomSlider";
import md5 from "md5";
const easeInOut = t => 1 - Math.pow(1 - t, 3);

export default {
  data() {
    return {
      features: [],
      zoom: 16,
      center: [11774094.696107, 1122418.043939],
      rotation: 0,
      loading: false,
      selectedFeatures: [],
      activeFeatures: [],
      sportGrounds: [],
      deviceCoordinate: undefined,
    };
  },
  beforeMount() {
    /*
     * Shine911 load sports grounds
     * Use direct GEOSERVER service
     */
    this.loading = true;
    
      axios.all([this.getPointInfoCTU(), this.getGeoJSON()]).then(axios.spread((info, geo)=>{
          info = Object.values(info.data.original);
          this.features = geo.data.features;
          this.features.forEach(f => {
              let found = info.find(i => i.MADIADIEM === f.properties.diadiem);
              console.log(found);
              if(found!=undefined){
                f.properties.state = found.TRANGTHAI;
                f.properties.activeName = found.TENHOATDONG;
              }
              //
          })
      }));
    axios.get(
        "http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3Asports_grounds&maxFeatures=50&outputFormat=application%2Fjson"
      )
      .then((res) => {
        this.sportGrounds = res.data.features;
        //this.loading = false;
      });
  },
  methods: {
    pointOnSurface: findPointOnSurface,
    onUpdatePosition (coordinate) {
      this.deviceCoordinate = coordinate
    },
    onMapMounted() {
      // now ol.Map instance is ready and we can work with it directly
      this.$refs.map.$map.getControls().extend([
        new ScaleLine(),
        new FullScreen(),
        new OverviewMap({
          collapsed: false,
          collapsible: true,
        }),
        new ZoomSlider(),
      ]);
    },
    noActivity: function () {
      return this.features.filter((f) => f.properties.state === false);
    },
    isRed (feature, resolution) {
        return feature.values_.state === "YES"
    },
    isGreen (feature, resolution) {
        return feature.values_.state === "NO"
    },
    getGeoJSON: function() {
        return axios.get("http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3Aextracurricular_points&maxFeatures=50&outputFormat=application%2Fjson");
    },
    getPointInfoCTU: function() {
      let dateTime = Math.floor(new Date().getTime() / 1000);
      let mode = "hdnk";
      let value = "allpositioninmap";
      let encryptDateTime = dateTime;
      for (let i = 0; i < 5; i++) {
        value = md5(value);
        mode = md5(mode);
      }

      //Encrypt validate
      let validate = "qlph." + value + encryptDateTime;
      //console.log(validate);
      for (let i = 0; i < 5; i++) {
        validate = md5(validate);
      }

      return axios.get("api/map", {
          params: {
            mode: mode,
            value: value,
            validate: validate,
            time: dateTime,
          },
        });
    },
    onMapPostCompose ({ vectorContext, frameState }) {
      if (!this.$refs.marker || !this.$refs.marker.$feature) return
      const feature = this.$refs.marker.$feature
      if (!feature.getGeometry() || !feature.getStyle()) return
      const flashGeom = feature.getGeometry().clone()
      const duration = feature.get('duration')
      const elapsed = frameState.time - feature.get('start')
      const elapsedRatio = elapsed / duration
      const radius = easeInOut(elapsedRatio) * 35 + 5
      const opacity = easeInOut(1 - elapsedRatio)
      const fillOpacity = easeInOut(0.5 - elapsedRatio)
      vectorContext.setStyle(createStyle({
        imageRadius: radius,
        fillColor: [119, 170, 203, fillOpacity],
        strokeColor: [119, 170, 203, opacity],
        strokeWidth: 2 + opacity,
      }))
      vectorContext.drawGeometry(flashGeom)
      vectorContext.setStyle(feature.getStyle()(feature)[0])
      vectorContext.drawGeometry(feature.getGeometry())
      if (elapsed > duration) {
        feature.set('start', Date.now())
      }
      this.$refs.map.render()
    },
  },
};
</script>

<style scoped>
</style>
