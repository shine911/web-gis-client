<template>
  <div>
    <vl-map
      id="map2"
      ref="map2"
      style="height: 500px"
      :load-tiles-while-animating="true"
      :load-tiles-while-interacting="true"
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
        <vl-layer-vector id="sport" :z-index="2">
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
import { findPointOnSurface } from "vuelayers/lib/ol-ext";
import ScaleLine from "ol/control/ScaleLine";
import FullScreen from "ol/control/FullScreen";
import OverviewMap from "ol/control/OverviewMap";
import ZoomSlider from "ol/control/ZoomSlider";
import md5 from "md5";

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
    };
  },
  beforeMount() {
    /*
     * Shine911 load sports grounds
     * Use direct GEOSERVER service
     */
    this.loading = true;
    
      axios.all([this.getPointInfoCTU(), this.getGeoJSON()]).then(axios.spread((info, geo)=>{
          console.log(info);
          console.log(geo);
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
        "http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3Asports_grounds&maxFeatures=50&outputFormat=application%2Fjson"
      )
      .then((res) => {
        this.sportGrounds = res.data.features;
        //this.loading = false;
      });
  },
  methods: {
    pointOnSurface: findPointOnSurface,
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
        return feature.values_.state === "NO"
    },
    isGreen (feature, resolution) {
        return feature.values_.state === "YES"
    },
    getGeoJSON: function() {
        return axios.get("http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3Aextracurricular_points&maxFeatures=50&outputFormat=application%2Fjson");
    },
    getPointInfoCTU: function() {
      let dateTime = Math.floor(new Date().now / 1000);
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

      return axios.get("/api/map", {
          params: {
            mode: mode,
            value: value,
            validate: validate,
            time: dateTime,
          },
        });
    },
  },
};
</script>

<style scoped>
</style>
