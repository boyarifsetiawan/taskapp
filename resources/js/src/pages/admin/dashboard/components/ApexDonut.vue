
<template>
    <apexchart
      height="155"
      type="pie"
      :options="options"
      :series="series"
    ></apexchart>
  </template>
  
  <script>
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    name: 'ApexDonut',
    props: {
      tasks: { type: Array, required: true },
    },
    data() {
      return {
        options: {
          title: {
            text: '',
            align: 'left',
          },
          chart: {
            id: 'apex-donut',
          },
          // labels: this.$props.labels,
        labels: ['pending','completed'],
          colors: [
            
           
          ],
          markers: {
            size: 5,
            hover: {
              sizeOffset: 6,
            },
          },
        //   xaxis: {
        //     categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
        //   },
        },
        series: this.$props.tasks,
        // series:[40,60]
      };
    },
  });
  </script>
  