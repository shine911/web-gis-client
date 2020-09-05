<template>
  <div>
    <b-spinner v-if="loading" label="Loading..."></b-spinner>
    <b-table
      :items="items"
      :fields="fields"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      sort-icon-left
      responsive="sm"
    ></b-table>

    <div>
      Sorting By:
      <b>{{ sortBy }}</b>, Sort Direction:
      <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      loading: false,
      sortBy: "age",
      sortDesc: false,
      fields: [
        { key: "roomcode", sortable: true },
        { key: "roomnamevi", sortable: true },
        { key: "roomnameen", sortable: true },
        { key: "magencycode", sortable: false },
      ],
      items: [],
    };
  },
  props: { floor: Number },
  mounted() {
    let loading = this.loading;
    let items = this.items;
    let floor = this.floor;
    loading = true;
    axios.get("/api/room", { params: { floor: floor } })
    .then(function(res){
      items = res.data;
      console.log(res.data);
      loading = false;
    });
    console.log(items);
  },
  methods: {
  },
};
</script>