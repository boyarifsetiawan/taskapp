<script setup>
import { onMounted, ref } from "vue";
import ApexDonut from "./components/ApexDonut.vue";
import ApexRadial from "./components/ApexRadial.vue";
import { useGetPinnedProject } from "./actions/GetPinnedProject";
import { useCountProjects } from "./actions/CountProject";
import { useGetChartData } from "./actions/GetChartData";

const { projectPinned, getPinnedProjects } = useGetPinnedProject();
const { totalProjects, getTotalProjects } = useCountProjects();
const { chartData, getChartData } = useGetChartData();


onMounted(async () => {
    await getPinnedProjects();
    getChartData(projectPinned.value.id);
    getTotalProjects();
    console.log(chartData.value?.tasks)
});
</script>
<template>
    <div class="row">
        <h2>Dashboard</h2>
        <br />
        <br />
        <br />
        <div class="row">
            <div class="col-md-8">
                <h3 style="color: rgb(118, 119, 120)">
                    Project : {{ projectPinned?.name }}
                </h3>
            </div>
        </div>
        <br /><br />
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <b>Total Projects</b>
                    </div>
                    <div class="card-body">
                        <br />
                        <br />

                        <h2 align="center">{{ totalProjects?.count }}</h2>
                        <br />
                        <br />
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header"><b>Tasks</b></div>
                    <div class="card-body">
                        {{ chartData.tasks }}
                        <div v-if="chartData.tasks">
                            <ApexDonut :tasks="chartData.tasks" />
                        </div>
                        <div v-else>
                            No Task
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <b>Task Progress</b>
                    </div>

                    <div class="card-body">
                       
                        <div v-if="chartData.progress > 0">
                            <ApexRadial :percent="chartData.progress" />
                        </div>
                        <div v-else>
                            <ApexRadial :percent="0" />
                        </div>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>