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

export default {
    data() {
        return {
            zoom: 16,
            center: [11774094.696107, 1122418.043939],
            rotation: 0,
            features: [],
            loading: false,
            feature: [],
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
    }
}
</script>
<style scoped>
.map{
    height: 500px;
}
</style>