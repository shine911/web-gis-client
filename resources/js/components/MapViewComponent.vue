<template>
    <div class="row">
        <div class="col-lg-12 map-css">
            <vl-map class="map" ref="map" @mounted="onMapMounted" :load-tiles-while-animating="true" :load-tiles-while-interacting="true">
                <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation"></vl-view>
                <vl-layer-tile class="base-layer" :z-index="0">
                    <vl-source-osm></vl-source-osm>
                </vl-layer-tile>

                <vl-layer-vector class="source-layer" :z-index="1">
                    <vl-source-vector ident="draw-target" :features.sync="features"></vl-source-vector>
                    <vl-style-box>
                        <vl-style-stroke color="green" :width="3"></vl-style-stroke>
                        <vl-style-fill color="rgba(255,255,255,0.5)"></vl-style-fill>
                    </vl-style-box>
                </vl-layer-vector>
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
                <b-spinner v-if="loading"></b-spinner>

            </vl-map>

        </div>
    </div>
</template>

<script>
import axios from 'axios'
import ScaleLine from 'ol/control/ScaleLine'
import FullScreen from 'ol/control/FullScreen'
import OverviewMap from 'ol/control/OverviewMap'
import ZoomSlider from 'ol/control/ZoomSlider'
import {
    findPointOnSurface
} from "vuelayers/lib/ol-ext";

export default {
    data() {
        return {
            zoom: 16,
            center: [11774094.696107, 1122418.043939],
            rotation: 0,
            features: [],
            loading: false,
            feature: [],
            selectedFeatures: [],
        }
    },
    props: {src: String},
    mounted() {
        this.loading = true
        axios.get(this.src)
            .then(res => {
                this.features = res.data.features
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
        pointOnSurface: findPointOnSurface,
    }
}
</script>
<style scoped>
.map{
    height: 500px;
}
</style>
