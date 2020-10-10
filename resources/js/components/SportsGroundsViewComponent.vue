<template>
    <div>
        <vl-map style="height: 500px" :load-tiles-while-animating="true" :load-tiles-while-interacting="true">
            <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation"></vl-view>
            <vl-layer-tile class="base-layer" :z-index="0">
                <vl-source-osm></vl-source-osm>
                <vl-layer-vector>
                    <vl-source-vector></vl-source-vector>
                </vl-layer-vector>
            </vl-layer-tile>
            <b-spinner v-if="loading"></b-spinner>
        </vl-map>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data(){
      return {
          features: [],
          zoom: 16,
          center: [11774094.696107, 1122418.043939],
          rotation: 0,
          loading: false,
      };
    },
    mounted() {
      /*
       * Shine911 load sports grounds
       * Use direct GEOSERVER service
       */
        this.loading = true
        axios.get('http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3Atest_point_new&maxFeatures=50&outputFormat=application%2Fjson')
            .then(res => {
                this.features = res.data.features
                this.loading = false
            })
    },
    methods: {

    }
}
</script>

<style scoped>

</style>
