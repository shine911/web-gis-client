<template>
  <div>
    <vl-map ref="map"
      style="height: 500px"
      class="map"
      @mounted="onMapMounted"
      :load-tiles-while-animating="true"
      :load-tiles-while-interacting="true"
      @postcompose="onMapPostCompose"
    >
      <vl-view
        :zoom.sync="zoom"
        :center.sync="center"
        :rotation.sync="rotation"
      ></vl-view>
      <vl-layer-tile class="base-layer" :z-index="0">
        <vl-source-osm :attributions="copyright"></vl-source-osm>
      </vl-layer-tile>

      <vl-layer-vector
        v-for="(feature, index) in listFloor"
        :key="`floor-${index}`"
        :z-index="index"
        :id="`floor${index}`"
      >
        <vl-source-vector
          v-if="showLogic[index]"
          :features.sync="feature.features"
        ></vl-source-vector> 
        <vl-style-box v-if="showLogic[index]">
          <vl-style-stroke :color="feature.color" :width="1"></vl-style-stroke>
          <vl-style-fill color="white"></vl-style-fill>
        </vl-style-box>
      </vl-layer-vector>

      <vl-layer-vector
        v-for="(feature, index) in listDormity"
        :key="`dormity-${index}`"
        :z-index="index"
        :id="`dormity${index}`"
      >
        <vl-source-vector
          v-if="showLogicDormity[index]"
          :features.sync="feature.features"
        ></vl-source-vector> 
        <vl-style-box v-if="showLogicDormity[index]">
          <vl-style-stroke :color="feature.color" :width="1"></vl-style-stroke>
          <vl-style-fill color="white"></vl-style-fill>
        </vl-style-box>
      </vl-layer-vector>

      <vl-layer-vector
        v-for="(feature, index) in listElectricNetwork"
        :key="`electricNetwork-${index}`"
        :z-index="index"
        :id="`electricNetwork${index}`"
      >
        <vl-source-vector
          v-if="showLogicElectricNetwork[index]"
          :features.sync="feature.features"
        ></vl-source-vector> 
        <vl-style-box v-if="showLogicElectricNetwork[index]">
          <vl-style-stroke :color="feature.color" :width="1"></vl-style-stroke>
        </vl-style-box>
      </vl-layer-vector>

      <vl-layer-vector
        v-for="(feature, index) in listWaterNetwork"
        :key="`waterNetwork-${index}`"
        :z-index="index"
        :id="`waterNetwork${index}`"
      >
        <vl-source-vector
          v-if="showLogicWaterNetwork[index]"
          :features.sync="feature.features"
        ></vl-source-vector> 
        <vl-style-box v-if="showLogicWaterNetwork[index]">
          <vl-style-stroke :color="feature.color" :width="1"></vl-style-stroke>
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
      <!-- Interaction Select Layer -->
      <vl-interaction-select :features.sync="selectedFeatures">
        <template slot-scope="select">
          <!-- select styles -->
          <vl-style-box>
            <vl-style-stroke color="#423e9e" :width="1"></vl-style-stroke>
            <vl-style-fill :color="[254, 178, 76, 0.7]"></vl-style-fill>
            <vl-style-circle :radius="5">
              <vl-style-stroke color="#423e9e" :width="1"></vl-style-stroke>
              <vl-style-fill :color="[254, 178, 76, 0.7]"></vl-style-fill>
            </vl-style-circle>
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
          >
            <template>
              <section class="card">
                <div class="card-body">
                  <div class="card-title">
                    Feature ID {{ feature.id }}
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
                    <ul v-if="feature.properties.roomcode!==undefined">
                      <li>Mã phòng: {{ feature.properties.roomcode }}</li>
                      <li>Tên phòng: {{ feature.properties.roomnamevi }}</li>
                      <li>Tầng: {{ feature.properties.floor }}</li>
                      <li>Sức chứa: {{ feature.properties.capacity }}</li>
                      <li>Diện tích: {{ feature.properties.area }}</li>
                    </ul>
                    <ul v-else>
                      <li>Toà nhà: {{ feature.properties.building }}</li>
                      <li>Khu: {{ feature.properties.dormitoryzone }}</li>
                      <li>Tầng: {{ feature.properties.floor }}</li>
                      <li>Sức chứa: {{ feature.properties.roomcapity }}</li>
                      <li>Diện tích: {{ feature.properties.roomarea }}</li>
                      <li>Hiện trạng: {{ feature.properties.state }}</li>
                    </ul>
                  </div>
                </div>
              </section>
            </template>
          </vl-overlay>
          <!--// selected popup -->
        </template>
      </vl-interaction-select>
    </vl-map>
    <div>
      <ul class="vertical-nav-menu">
        <li>
          <a href="#">
            <i class="metismenu-icon pe-7s-culture"></i>
            Phòng
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
          </a>
          <ul>
            <li v-for="(value,index) in listUrl" :key="value.id">
              <div class="position-relative form-check">
                <label class="form-check-label"
                  ><input
                    type="checkbox"
                    class="form-check-input"
                    v-model="showLogic[index]"
                  />
                  {{ value.layer_name }}</label
                >
              </div>
            </li>
          </ul>
        </li>
        <li>
          <a href="#">
            <i class="metismenu-icon pe-7s-home"></i>
            Ký túc xá
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
          </a>
          <ul>
            <li v-for="(value, index) in listUrlDormity" :key="value.id">
              <div class="position-relative form-check">
                <label class="form-check-label"
                  ><input
                    type="checkbox"
                    class="form-check-input"
                    v-model="showLogicDormity[index]"
                  />
                  {{ value.layer_name }}</label
                >
              </div>
            </li>
          </ul>
        </li>
        <li v-if="listUrlElectricNetwork.length != 0">
          <a href="#">
            <i class="metismenu-icon pe-7s-gleam"></i>
            Mạng lưới điện
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
          </a>
          <ul>
            <li v-for="(value, index) in listUrlElectricNetwork" :key="value.id">
              <div class="position-relative form-check">
                <label class="form-check-label"
                  ><input
                    type="checkbox"
                    class="form-check-input"
                    v-model="showLogicElectricNetwork[index]"
                  />
                  {{ value.layer_name }}</label
                >
              </div>
            </li>
          </ul>
            <!-- Water network -->
          <li v-if="listUrlWaterNetwork.length != 0">
          <a href="#">
            <i class="metismenu-icon pe-7s-drop"></i>
            Mạng lưới nuowsc
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
          </a>
          <ul>
            <li v-for="(value, index) in listUrlWaterNetwork" :key="value.id">
              <div class="position-relative form-check">
                <label class="form-check-label"
                  ><input
                    type="checkbox"
                    class="form-check-input"
                    v-model="showLogicWaterNetwork[index]"
                  />
                  {{ value.layer_name }}</label
                >
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import ScaleLine from "ol/control/ScaleLine";
import FullScreen from "ol/control/FullScreen";
import OverviewMap from "ol/control/OverviewMap";
import ZoomSlider from "ol/control/ZoomSlider";
import { findPointOnSurface, createStyle } from "vuelayers/lib/ol-ext";
const easeInOut = t => 1 - Math.pow(1 - t, 3);

export default {
  name: "MapGlobalView",
  props: {
    url: String,
    //TODO: Fix props !
    urlDormity: String,
    urlElectric: String,
    urlWater: String,
    userHideLogic: Boolean,
  },
  data() {
    return {
      copyright: '&copy; <a href="https://www.ctu.edu.vn/" target="_blank">CTU WebGIS Project</a> contributors.',
      zoom: 16,
      center: [11774094.696107, 1122418.043939],
      rotation: 0,
      listFloor: [],
      loading: false,
      selectedFeatures: [],
      selectedDormity: [],
      showLogic: [],
      listDormity: [],
      showLogicDormity: [],
      listElectricNetwork: [],
      showLogicElectricNetwork: [],
      listWaterNetwork: [],
      showLogicWaterNetwork: [],
      deviceCoordinate: undefined,
    };
  },
  beforeMount() {
    this.loading = true;
    /* See url in featureList
     * this.listFloor is empty
     * this.listUrl is an array object with FeatureConfig Table Class in Laravel
     * Property:
     * id: auto increament
     * feature_name: name of floor
     * url: Url string
     */
    let listFloor = this.listFloor;
    let showLogic = this.showLogic;
    let floorLayerGroup = this.floorGroupLayerId;
    this.listUrl.forEach(function (value, index) {
      var letters = "0123456789ABCDEF";
      var color = "#";
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      axios.get(value.url).then((res) => {
        listFloor[index] = res.data;
        listFloor[index].color = color;
      });
      showLogic[index] = false;
    });

    //Dormity
    let listDormity = this.listDormity;
    let showLogicDormity = this.showLogicDormity;
    let dormityLayerGroup = this.dormityGroupLayerId;
    this.listUrlDormity.forEach(function (value, index) {
      var letters = "0123456789ABCDEF";
      var color = "#";
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      axios.get(value.url).then((res) => {
        listDormity[index] = res.data;
        listDormity[index].color = color;
      });
      showLogicDormity[index] = false;
    });

    //ElectricNetwork
    if (this.urlElectric !== undefined) {
      let listElectricNetwork = this.listElectricNetwork;
      let showLogicElectricNetwork = this.showLogicElectricNetwork;
      this.listUrlElectricNetwork.forEach((value, index) => {
        axios.get(value.url).then((res) => {
          listElectricNetwork[index] = res.data;
          listElectricNetwork[index].color = "red";
        });
        showLogicElectricNetwork[index] = false;
      });
    }

    //WaterNetwork
    if (this.urlWater !== undefined) {
      let listWaterNetwork = this.listWaterNetwork;
      let showLogicWaterNetwork = this.showLogicWaterNetwork;
      this.listUrlWaterNetwork.forEach((value, index) => {
        axios.get(value.url).then((res) => {
          listWaterNetwork[index] = res.data;
          listWaterNetwork[index].color = "blue";
        });
        showLogicWaterNetwork[index] = false;
      });
    }

    this.loading = false;
  },
  methods: {
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
    pointOnSurface: findPointOnSurface,
    color() {
      var letters = "0123456789ABCDEF";
      var color = "#";
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
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
  computed: {
    //url parse json
    listUrl: function () {
      if (this.userHideLogic) {
        return JSON.parse(this.url).filter((url) => url.user_hide == false);
      }
      return JSON.parse(this.url);
    },
    listUrlDormity: function () {
      return JSON.parse(this.urlDormity);
    },
    listUrlElectricNetwork: function () {
      if (this.userHideLogic) {
        return [];
      }
      return JSON.parse(this.urlElectric);
    },
    listUrlWaterNetwork: function () {
      if (this.userHideLogic) {
        return [];
      }
      return JSON.parse(this.urlWater);
    },
  },
};
</script>

<style lang="scss">
.card-title {
  display: flex;
  justify-content: space-between;

  .card-header-icon {
    cursor: pointer;
  }
}
</style>
