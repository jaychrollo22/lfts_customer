<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                     <div class="card bg-secondary shadow  mb-5">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0 text-uppercase">Shipment Logs</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <tbody>
                                        <tr v-for="(log, index) in shipment_detail_logs" v-bind:key="index">
                                            <td class="text-center" v-if="log.log_date_time != '12:04:00 AM -0001-11-30'">
                                                <p class="text-muted" style="font-size:12px;">{{log.log_date_time}}</p>
                                            </td>
                                            <td class="text-left" v-if="log.log_date_time != '12:04:00 AM -0001-11-30'">
                                                <p class="title" style="font-size:14px;">{{log.action}}</p>   
                                            </td>   
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow  mb-5">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0 text-uppercase">Track Shipments</h3>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-2 mt-3 float-right">
                                <div class="col-xl-6 mb-2 mt-3 float-left">          
                                    <label for="shipment_number">Search</label>
                                    <input type="text" name="shipment_number" class="form-control" placeholder="Search by Shipment Number" autocomplete="off" v-model="keywords" id="shipment_number">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Shipment Details</th>
                                            <th scope="col">Plate Number</th>
                                            <th scope="col">Distance</th>
                                            <th scope="col">ETA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(shipment, index) in filteredQueues" v-bind:key="index">
                                            <td>{{index + 1}}</td>
                                            <td>{{ shipment.change_date }}</td>
                                            <td>
                                                <p>Shipment Number: <span class="text-info">{{ shipment.shipment_number }}</span></p>
                                                <p>DO Number: <span class="text-success">{{ shipment.do_number }}</span></p>
                                                <p>Customer Code: {{ shipment.customer_code }}</p>
                                                <p>Customer Name: {{ shipment.customer_name }}</p>
                                                <p>Customer Address: {{ shipment.delivery_address }}</p>
                                                <!-- <p>Plant : {{ shipment.plant }}</p>     -->
                                                <p>
                                                    <button v-if="shipment.status =='In Transit'" class="btn btn-sm btn-warning mt-1" @click="fetchShipmentLogs(shipment.shipment_number)">{{ shipment.status }}</button>
                                                    <button v-else-if="shipment.status == 'Reach Destination'" class="btn btn-sm btn-success mt-1" @click="fetchShipmentLogs(shipment.shipment_number)">{{ shipment.status }}</button>
                                                    <button v-else-if="shipment.status == 'Delivered'" class="btn btn-sm btn-primary mt-1" @click="fetchShipmentLogs(shipment.shipment_number)">{{ shipment.status }}</button>
                                                    <button v-else-if="shipment.status == 'In Plant'" class="btn btn-sm btn-info mt-1" @click="fetchShipmentLogs(shipment.shipment_number)">{{ shipment.status }}</button>
                                                    <button v-else class="btn btn-sm btn-warning mt-1" disabled>No Status</button>
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <strong class="text-default">{{ shipment.plate_number }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <strong v-if="shipment.status =='In Transit'" class="text-default">{{ shipment.distance_text}}</strong>
                                                <strong v-else-if="shipment.status =='In Plant'" class="text-default">{{ shipment.distance_text}}</strong>
                                                <strong v-else-if="shipment.status =='Reach Destination'" class="text-default">Reach Destination</strong>
                                                <strong v-else-if="shipment.status =='Delivered'" class="text-default">Delivered</strong>
                                                <strong v-else class="text-default"></strong>
                                            </td>
                                            <td class="text-center">
                                                <strong v-if="shipment.status =='In Transit'" class="text-default">{{ shipment.estimated_time_travel}}</strong>
                                                <strong v-else-if="shipment.status =='In Plant'" class="text-default">{{ shipment.estimated_time_travel}}</strong>
                                                <strong v-else-if="shipment.status =='Reach Destination'" class="text-default">Reach Destination</strong>
                                                <strong v-else-if="shipment.status =='Delivered'" class="text-default">Delivered</strong>
                                                <strong v-else class="text-default"></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mb-3 mt-3 ml-1" v-if="filteredQueues.length">
                                <div class="col-6">
                                    <button :disabled="!showPreviousLink()" class="btn btn-default btn-sm btn-fill" v-on:click="setPage(currentPage - 1)"> Previous </button>
                                        <span class="text-dark">Page {{ currentPage + 1 }} of {{ totalPages }}</span>
                                    <button :disabled="!showNextLink()" class="btn btn-default btn-sm btn-fill" v-on:click="setPage(currentPage + 1)"> Next </button>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="mr-2">Filtered Shipment(s) : {{ filteredQueues.length }} </span><br>
                                    <span class="mr-2">Total Shipment(s) : {{ shipments.length }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                keywords: '',
                shipments: [],
                shipment_detail_logs: [],
                loading : true,
                currentPage: 0,
                itemsPerPage: 10,
                shipmentTimer : '',
                shipmentLocationTimer : '',
                fetchshipmentTimer : '',
                errors:[],
                shipment_logs_loading : false
            }
        },
        created(){
            this.fetchShipmentDetails();
        },
        methods:{
            fetchShipmentDetails() {
                let v = this;
                v.shipments = [];
                axios.get('/track-shipment-details')
                .then(response => {
                    v.shipments = response.data;
                });
            },
            fetchShipmentLogs(shipment_number){
                let v= this;
                v.shipment_detail_logs = [];
                v.shipment_logs_loading = true;
                axios.get('/track-shipment-detail-log-data/' + shipment_number)
                .then(response => {
                    v.shipment_detail_logs = response.data;
                    v.shipment_logs_loading = false;
                });
            },
            setPage(pageNumber) {
                this.currentPage = pageNumber;
            },
            resetStartRow() {
                this.currentPage = 0;
            },
            showPreviousLink() {
                return this.currentPage == 0 ? false : true;
            },
            showNextLink() {
                return this.currentPage == (this.totalPages - 1) ? false : true;
            }
        },
        computed:{
            filteredShipments(){
                let self = this;
                return Object.values(self.shipments).filter(shipment_data => {
                    return shipment_data.shipment_number.toLowerCase().includes(this.keywords.toLowerCase())
                });
            },
            totalPages() {
                return Math.ceil(Object.values(this.filteredShipments).length / this.itemsPerPage)
            },
            filteredQueues() {
                var index = this.currentPage * this.itemsPerPage;
                var queues_array = this.filteredShipments.slice(index, index + this.itemsPerPage);

                if(this.currentPage >= this.totalPages) {
                    this.currentPage = this.totalPages - 1
                }

                if(this.currentPage == -1) {
                    this.currentPage = 0;
                }

                return queues_array;
            },
        }
    }
</script>

<style>
    /* .main-panel>.content {
        padding: 78px 30px 30px 30px!important;
        min-height: calc(100vh - 70px)!important;
    } */
</style>
