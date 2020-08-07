<template>
    <div>
        <vl-map style="height: 500px" class="map" ref="map" @mounted="onMapMounted" :load-tiles-while-animating="true" :load-tiles-while-interacting="true">
            <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation"></vl-view>
            <vl-layer-tile class="base-layer" :z-index="0">
                <vl-source-osm></vl-source-osm>
            </vl-layer-tile>

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
            <p v-if="loading">
                Loading map, please wait...
            </p>

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
                    <vl-overlay class="feature-popup" v-for="feature in select.features" :key="feature.id" :id="feature.id"
                                :position="pointOnSurface(feature.geometry)" :auto-pan="true" :auto-pan-animation="{ duration: 300 }">
                        <template slot-scope="popup">
                            <section class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        Feature ID {{ feature.id }}
                                        <a class="card-header-icon" title="Close"
                                           @click="selectedFeatures = selectedFeatures.filter(f => f.id !== feature.id)">
                                            x
                                        </a>
                                    </div>
                                    <div class="content">
                                        <p>
                                            Overlay popup content for Feature with ID <strong>{{ feature.id }}</strong>
                                        </p>
                                        <p>
                                            Popup: {{ JSON.stringify(popup) }}
                                        </p>
                                        <p>
                                            Feature: {{ JSON.stringify({ id: feature.id, properties: feature.properties }) }}
                                        </p>
                                    </div>

                                </div>

                            </section>
                        </template>
                    </vl-overlay>
                    <!--// selected popup -->
                </template>
            </vl-interaction-select>
        </vl-map>
        <button class="btn btn-secondary" @click="firstFloorShow = !firstFloorShow">First Floor</button>
        <button class="btn btn-secondary" @click="secondFloorShow = !secondFloorShow">Second Floor</button>
        <button class="btn btn-secondary" @click="streetLineShow = !streetLineShow">Street Line</button>

    </div>

</template>

<script>
import axios from 'axios'
import ScaleLine from 'ol/control/ScaleLine'
import FullScreen from 'ol/control/FullScreen'
import OverviewMap from 'ol/control/OverviewMap'
import ZoomSlider from 'ol/control/ZoomSlider'
import { findPointOnSurface } from 'vuelayers/lib/ol-ext'

export default {
    name: "MapGlobalView",
    data() {
        return {
            zoom: 16,
            center: [11774094.696107, 1122418.043939],
            rotation: 0,
            firstFloor: [],
            firstFloorShow: false,
            loading: false,
            secondFloor: [],
            secondFloorShow: false,
            selectedFeatures: [],
            streetLine: [],
            streetLineShow: false,

        }
    },
    mounted() {
        this.loading = true
        axios.get('http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu:tang1_tret&outputFormat=application/json')
            .then(res => {
                this.firstFloor = res.data.features
            })
        axios.get('http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu:ht_duong_line&outputFormat=application/json')
            .then(res => {
                this.streetLine = res.data.features
            })
        axios.get('http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu:tang2_lau1&outputFormat=application/json')
        .then(res =>{
          this.secondFloor = res.data.features
            this.loading = false
        })
    },
    methods: {
        onMapMounted () {
            // now ol.Map instance is ready and we can work with it directly
            this.$refs.map.$map.getControls().extend([
                new ScaleLine(),
                new FullScreen(),
                new OverviewMap({
                    collapsed: false,
                    collapsible: true,
                }),
                new ZoomSlider(),
            ])
        },
        pointOnSurface: findPointOnSurface
    }
}
</script>

<style lang="sass">
.card-title
    display: flex
    justify-content: space-between
    .card-header-icon
        cursor: pointer


</style>
