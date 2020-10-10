<template>
    <div>
        <vl-map style="height: 500px" class="map" @mounted="onMapMounted" :load-tiles-while-animating="true"
            :load-tiles-while-interacting="true">
            <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation"></vl-view>
            <vl-layer-tile class="base-layer" :z-index="0">
                <vl-source-osm></vl-source-osm>
            </vl-layer-tile>
            <!--
            <vl-layer-vector v-if="firstFloorShow" class="tang1-layer" :z-index="1">
                <vl-source-vector :features.sync="firstFloor"></vl-source-vector>
                <vl-style-box>
                    <vl-style-stroke color="green" :width="1"></vl-style-stroke>
                    <vl-style-fill color="rgba(255,255,255,0.5)"></vl-style-fill>
                </vl-style-box>
            </vl-layer-vector>
            <vl-layer-vector v-if="secondFloorShow" class="tang2-layer" :z-index="2">
                <vl-source-vector :features.sync="secondFloor"></vl-source-vector>
                <vl-style-box>
                    <vl-style-stroke color="red" :width="1"></vl-style-stroke>
                    <vl-style-fill color="rgba(255,255,255,0.5)"></vl-style-fill>
                </vl-style-box>
            </vl-layer-vector>
            <vl-layer-vector v-if="streetLineShow" class="tang2-layer" :z-index="1">
                <vl-source-vector :features.sync="streetLine"></vl-source-vector>
                <vl-style-box>
                    <vl-style-stroke color="red" :width="1"></vl-style-stroke>
                    <vl-style-fill color="rgba(255,255,255,0.5)"></vl-style-fill>
                </vl-style-box>
            </vl-layer-vector>
      -->
            <vl-layer-vector v-for="(feature, index) in listFloor" :key="id" :z-index="index">
                <vl-source-vector v-if="showLogic[index]" :features.sync="feature.features"></vl-source-vector>
                <vl-style-box>
                    <vl-style-stroke color="green" :width="1"></vl-style-stroke>
                    <vl-style-fill color="#ffffff"></vl-style-fill>
                </vl-style-box>
            </vl-layer-vector>
            <p v-if="loading">Loading map, please wait...</p>

            <vl-interaction-select :features.sync="selectedFeatures">
                <template slot-scope="select">
                    <!-- select styles -->
                    <vl-style-box>
                        <vl-style-stroke color="#423e9e" :width="7"></vl-style-stroke>
                        <vl-style-fill :color="[254, 178, 76, 0.7]"></vl-style-fill>
                        <vl-style-circle :radius="5">
                            <vl-style-stroke color="#423e9e" :width="7"></vl-style-stroke>
                            <vl-style-fill :color="[254, 178, 76, 0.7]"></vl-style-fill>
                        </vl-style-circle>
                    </vl-style-box>
                    <vl-style-box :z-index="1">
                        <vl-style-stroke color="#d43f45" :width="2"></vl-style-stroke>
                        <vl-style-circle :radius="5">
                            <vl-style-stroke color="#d43f45" :width="2"></vl-style-stroke>
                        </vl-style-circle>
                    </vl-style-box>
                    <!--// select styles -->

                    <!-- selected feature popup -->
                    <vl-overlay class="feature-popup" v-for="feature in select.features" :key="feature.id"
                        :id="feature.id" :position="pointOnSurface(feature.geometry)" :auto-pan="true"
                        :auto-pan-animation="{ duration: 300 }">
                        <template slot-scope="popup">
                            <section class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        Feature ID {{ feature.id }}
                                        <a class="card-header-icon" title="Close"
                                            @click="selectedFeatures = selectedFeatures.filter(f => f.id !== feature.id)">x</a>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <li>Mã phòng: {{feature.properties.roomcode}}</li>
                                            <li>Tên phòng: {{feature.properties.roomnamevi}}</li>
                                            <li>Tầng: {{feature.properties.floor}}</li>
                                            <li>Sức chứa: {{feature.properties.capacity}}</li>
                                            <li>Diện tích: {{feature.properties.area}}</li>
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
                        <i class="metismenu-icon pe-7s-car"></i>
                        Room
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li  v-for="(value, index) in listUrl" :key="value.id">
                            <div class="position-relative form-check"><label class="form-check-label"><input
                                        type="checkbox" class="form-check-input" v-model="showLogic[index]"> {{value.layer_name}}</label></div>
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
    import {
        findPointOnSurface
    } from "vuelayers/lib/ol-ext";

    export default {
        name: "MapGlobalView",
        props: {
            url: String,
        },
        data() {
            return {
                zoom: 16,
                center: [11774094.696107, 1122418.043939],
                rotation: 0,
                listFloor: [],
                loading: false,
                selectedFeatures: [],
                showLogic: [],
            };
        },
        mounted() {
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
            this.listUrl.forEach(function (value, index) {
                axios.get(value.url).then((res) => {
                    listFloor[index] = (res.data);
                    showLogic[index] = false;
                });
            });
            this.loading = false;
        },
        methods: {
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
        },
        computed: {
            //url parse json
            listUrl: function () {
                return JSON.parse(this.url);
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
