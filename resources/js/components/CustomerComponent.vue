<template>
    <div>
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="card-title"><i class="tim-icons icon-delivery-fast"></i> Track Shipment</h3>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label>Search</label>
                                <input type="text" class="form-control"  v-model="keywords" placeholder="Input Shipment Number / DO Number / Plate Number" />
                            </div>
                        </div>
                   
                        <div class="col-2">
                            <div class="form-group">
                                <label>From</label>
                                <input type="date" class="form-control"  v-model="from" placeholder="Input Search" />
                                <span class="text-danger" v-if="errors.from"> {{ errors.from[0] }} </span>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>To</label>
                                <input type="date" class="form-control"  v-model="to" placeholder="Input Search" />
                                <span class="text-danger" v-if="errors.to"> {{ errors.to[0] }} </span>
                            </div>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-sm btn-primary" @click="fetchFilter">Filter</button>
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
                                    <th scope="col">Truck</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(shipment, index) in filteredQueues" v-bind:key="index">
                                    <td>{{index + 1}}</td>
                                    <td>{{ shipment.change_date }}</td>
                                    <td>
                                        <p>DO Number: <strong class="text-default">{{ shipment.do_number }}</strong></p>
                                        <p>Customer Name: {{ shipment.customer_name }}</p>
                                        <p>Customer Address: {{ shipment.delivery_address }}</p>
                                        <p>
                                            <button v-if="shipment.status =='In Transit'" class="btn btn-sm btn-warning mt-1" @click="fetchShipmentLogs(shipment.shipment_number)">{{ shipment.status }}</button>
                                            <button v-else-if="shipment.status == 'Reach Destination'" class="btn btn-sm btn-success mt-1" @click="fetchShipmentLogs(shipment.shipment_number)">{{ shipment.status }}</button>
                                            <button v-else-if="shipment.status == 'Delivered'" class="btn btn-sm btn-primary mt-1" @click="fetchShipmentLogs(shipment.shipment_number)">{{ shipment.status }}</button>
                                            <button v-else-if="shipment.status == 'In Plant'" class="btn btn-sm btn-info mt-1" @click="fetchShipmentLogs(shipment.shipment_number)">{{ shipment.status }}</button>
                                            <button v-else class="btn btn-sm btn-warning mt-1" disabled>No Status</button>

                                            <button class="btn btn-sm btn-default mt-1" v-if="shipment.status =='In Transit'" @click="checkMap(shipment.shipment_current_coordinates,shipment.shipment_delivery_coordinates)">Check Google Map</button>
                                            <button class="btn btn-sm btn-default mt-1" v-if="shipment.status =='Reach Destination'" @click="checkMap(shipment.shipment_current_coordinates,shipment.shipment_delivery_coordinates)">Check Google Map</button>
                                        </p>
                                    </td>
                                    <td class="text-left">
                                        <strong class="text-default">{{ shipment.plate_number }}</strong>
                                        <p>Driver: {{ shipment.driver_name }}</p>
                                        <p>Phone No.: {{ shipment.driver_phone_number }}</p>
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
            
        <div class="modal fade" id="shipmentLogsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Shipment Logs</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" style="width:100%;">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                shipment_logs_loading : false,
                from : '',
                to : ''
            }
        },
        created(){
            this.fetchShipmentDetails();
        },
        methods:{
            fetchFilter(){
                let v= this;
                v.shipments = [];
                v.loading = true;
                this.errors = [];
                axios.post('/track-shipment-details-filter',{
                    from:v.from,
                    to:v.to,
                     _method: 'POST'
                })
                .then(response => {
                    v.shipments = response.data;
                    v.loading = false;
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    v.loading = false;
                });
            },
            checkMap(origin,destination){
                if(origin == '0,0' || destination == '0,0'){
                    alert('No coordinates found!');
                }else{
                    window.open('https://www.google.com/maps/dir/'+ origin + '/' +destination, '_blank');
                }
                
            },
            fetchShipmentDetails() {
                let v = this;
                v.shipments = [];
                axios.get('/track-shipment-details')
                .then(response => {
                    v.shipments = response.data;
                });
            },
            fetchShipmentLogs(shipment_number){
                $('#shipmentLogsModal').modal('show');
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
                    return shipment_data.shipment_number.toLowerCase().includes(this.keywords.toLowerCase()) || shipment_data.do_number.toLowerCase().includes(this.keywords.toLowerCase())
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
