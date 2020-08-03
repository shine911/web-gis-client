<template>
  <vl-map :load-tiles-while-animating="true" :load-tiles-while-interacting="true" style="height: 500px">
    <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation"></vl-view>
    <vl-layer-tile id="osm" z-index=0>
      <vl-source-osm></vl-source-osm>
    </vl-layer-tile>
    <vl-layer-vector z-index=1>
        <vl-source-vector ident="draw-target" :features.sync="features"></vl-source-vector>
        <vl-style-box>
          <vl-style-stroke color="green" :width="3"></vl-style-stroke>
          <vl-style-fill color="rgba(255,255,255,0.5)"></vl-style-fill>
        </vl-style-box>
    </vl-layer-vector>
        <vl-interaction-select>
      <!-- this style box working -->
      <vl-style-box>
        <vl-style-stroke color="green"></vl-style-stroke>
        <vl-style-fill color="green"></vl-style-fill>
      </vl-style-box>
    </vl-interaction-select>
    
    <vl-interaction-modify source="draw-target">
      <!-- this style box not working -->
      <vl-style-box>
        <vl-style-circle :radius="5">
          <vl-style-stroke color="green"></vl-style-stroke>
          <vl-style-fill color="green"></vl-style-fill>
        </vl-style-circle>
      </vl-style-box>
    </vl-interaction-modify>
        <vl-interaction-draw type="Polygon" source="draw-target">
      <vl-style-box>
        <vl-style-stroke color="red"></vl-style-stroke>
        <vl-style-fill color="rgba(255,255,255,0.5)"></vl-style-fill>
      </vl-style-box>
    </vl-interaction-draw>
    <p v-if="loading">
      Loading features, please wait...
    </p>
  </vl-map>
</template>

<script>
import axios from 'axios';
  export default {
    data () {
      return { 
        zoom: 16,
        center: [11774094.696107, 1122418.043939],
        rotation: 0,
        features: [],
        loading: false,
      }
    },
    mounted() {
      this.loading = true
      axios.get('http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3Atang1_tret&outputFormat=application%2Fjson')
      .then(res=>{
        this.features = res.data.features
        this.loading = false
      })
    },
    methods: {
    }
  }
</script>