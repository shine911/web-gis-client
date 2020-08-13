<template>
    <div class="row">
        <div class="col-lg-12 map-toolbox mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <button class="btn btn-primary" @click="saveMap()">Save Map</button>
                </div>
                <div class="col-lg-8">
                    <button :disabled="drawType!=null" class="btn btn-primary" @click="drawType='polygon'">Draw Polygon</button>
                    <button :disabled="selectedFeatures.length==0" class="btn btn-primary" @click="deleteFeature">Delete polygon</button>
                    <button :disabled="drawType==null" class="btn btn-primary" @click="drawType=undefined">Stop Draw</button>
                </div>
            </div>
        </div>
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
                <vl-interaction-draw v-if="drawType" source="draw-target" :type="drawType"></vl-interaction-draw>
                <vl-interaction-modify source="draw-target"></vl-interaction-modify>
                <vl-interaction-snap source="draw-target" :priority="10"></vl-interaction-snap>
                <vl-interaction-select :features.sync="selectedFeatures" v-if="drawType == null"></vl-interaction-select>
                <p v-if="loading">
                    Loading map, please wait...
                </p>

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
            drawType: 'polygon',
            selectedFeatures: [],
        }
    },
    props: {'src': String, 'id': Number},
    mounted() {
        this.loading = true
        axios.get(this.src)
            .then(res => {
                this.features = res.data.features
                this.loading = false
            })
    },
    methods: {
        saveMap: function(evt){
            //Alert
            let choose = confirm('We will saving your data?')
            if(choose){
                let geom = JSON.stringify(this.features[0].geometry.coordinates)
                axios.put("/api/tang1_tret/"+this.id, {geom: geom}).then(res=>{alert('Your map saved')
                console.log(res.data)})
            }
            return false
        },
        deleteFeature: function(evt){
            function isEqualsFeature(emt){
                //console.log(this.selectedFeatures[0])
                //console.log(emt)
                return emt.id === this.selectedFeatures[0].id
            }
            console.log(this.features.findIndex(isEqualsFeature, this))
            let id = this.features.findIndex(isEqualsFeature, this)
            this.features.splice(id, 1)
        },
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