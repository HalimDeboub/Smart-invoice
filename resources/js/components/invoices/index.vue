<template>
<div class="container">
    <div class="invoices">
        
        <div class="card__header">
            <div>
                <h2 class="invoice__title">Invoices</h2>
            </div>
            <div>
                <a class="btn btn-secondary" v-on:click="newInvoice">
                    New Invoice
                </a>
            </div>
        </div>

        <div class="table card__content">
            <div class="table--filter">
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                <div class="table--filter--listWrapper">
                    <ul class="table--filter--list">
                        <li>
                            <p class="table--filter--link table--filter--link--active">
                                All
                            </p>
                        </li>
                        <li>
                            <p class="table--filter--link ">
                                Paid
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table--search">
                <div class="table--search--wrapper">
                    <select class="table--search--select" name="" id="">
                        <option value="">Filter</option>
                    </select>
                </div>
                <div class="relative">
                    <i class="table--search--input--icon fas fa-search "></i>
                    <input class="table--search--input" type="text" v-model="searchInvoice" v-on:keyup="search()" placeholder="Search invoice">
                </div>
            </div>

            <div class="table--heading">
                <p>ID</p>
                <p>Date</p>
                <p>Number</p>
                <p>Customer</p>
                <p>Due Date</p>
                <p>Total</p>
            </div>

            <!-- item 1 -->
            <div class="table--items" v-for="invoice in invoices" :key="invoice.id" v-if="invoices.length > 0">
                <a href="#" class="table--items--transactionId" v-text="invoice.id" @click="onShow(invoice.id)"></a>
                <p v-text="invoice.invoice_date"></p>
                <p v-text="invoice.number"></p>
                <p>{{invoice.customer.firstName}}</p>
                <p>{{invoice.due_date}}</p>
                <p>  $ {{invoice.total}}</p>
            </div>
            <div class="table--items" v-else>
<p class="text-red"> No Invoice Founded</p>
            </div>
        </div>
        
    </div>

</div>
</template>


<script setup>
import axios from 'axios';
import { onMounted , ref} from 'vue';
import {useRouter} from 'vue-router'

const router = useRouter()
let invoices = ref([])
let searchInvoice = ref([])
onMounted(async ()=>{
    getInvoices()
   // newInvoice()
  
})
const getInvoices = async ()=>{
   let response =  await axios.get('api/invoices') 
   invoices.value = response.data.invoices
   
}

const search = async ()=>{
    let response = await axios.get('/api/invoices/search/?s=' + searchInvoice.value)
    invoices.value = response.data.invoices
}

const newInvoice = async ()=>{
    let response = await axios.get('api/invoices/create_invoice')
   router.push('/invoice/new')
    console.log(response.data)
}

const onShow = (id)=>{
    router.push("/invoices/"+id)
}
</script>