<template>

    <div class="container">
          <!--==================== EDIT INVOICE ====================-->
    <div class="invoices">
        
        <div class="card__header">
            <div>
                <h2 class="invoice__title">Edit Invoice</h2>
            </div>
            <div>
                
            </div>
        </div>

        <div class="card__content">
            <div class="card__content--header">
                <div>
                    <p class="my-1">Customer</p>
                    <select name="" id="" class="input" v-model="invoice.customer_id">
                        <option disabled>Select Customers</option>
                        <option v-for="customer in customers_list" :value="customer.id">{{customer.firstName}} {{customer.lastName}}</option>
                    </select>
                </div>
                <div>
                    <p class="my-1">Date</p> 
                    <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="invoice.invoice_date"> <!---->
                    <p class="my-1">Due Date</p> 
                    <input id="due_date" type="date" class="input"  v-model="invoice.due_date">
                </div>
                <div>
                    <p class="my-1">Numero</p> 
                    <input type="text" class="input"  v-model="invoice.number"> 
                    <p class="my-1">Reference(Optional)</p> 
                    <input type="text" class="input"  v-model="invoice.reference">
                </div>
            </div>
            <br><br>
            <div class="table">

                <div class="table--heading2">
                    <p>Item Description</p>
                    <p>Unit Price</p>
                    <p>Qty</p>
                    <p>Total</p>
                    <p></p>
                </div>
    
               
                  <!-- item 1 -->
                  <div class="table--items2" v-for="(item, i) in invoice.items" :key="item.id">
                    <p>{{item.product_id}}   {{item.description}}</p>
                    <p>
                        <p  v-text="item.unit_price"></p>
                    </p>
                    <p>
                        <input type="text" class="input" v-model="item.quantity" >
                    </p>
                    <p v-if="item.quantity">
                       {{(item.quantity * item.unit_price)}}
                    </p>
                    <p v-else></p>
                    <p style="color: red; font-size: 24px;cursor: pointer;" @click="removeItem(i)">
                        &times;
                    </p>
                </div>
                <div style="padding: 10px 30px !important;">
                    <button class="btn btn-sm btn__open--modal" v-on:click="openModal()">Add New Line</button>
                </div>
            </div>

            <div class="table__footer">
                <div class="document-footer" >
                    <p>Terms and Conditions</p>
                    <textarea cols="50" rows="7" class="textarea" v-model="invoice.terms_and_conditions" ></textarea>
                </div>
                <div>
                    <div class="table__footer--subtotal">
                        <p>Sub Total</p>
                        <span>$ {{invoice.sub_total}}</span>
                    </div>
                    <div class="table__footer--discount">
                        <p>Discount</p>
                        <input type="text" class="input" v-model="invoice.discount">
                    </div>
                    <div class="table__footer--total">
                        <p>Grand Total</p>
                        <span>$ {{invoice.total}}</span>
                    </div>
                </div>
            </div>

           
        </div>
        <div class="card__header" style="margin-top: 40px;">
            <div>
                
            </div>
            <div>
                <a class="btn btn-secondary">
                    Save
                </a>
            </div>
        </div>
        
    </div>
    <!--==================== add modal items ====================-->
    <div class="modal main__modal "  :class="{show : showModal}">
        <div class="modal__content">
            <span class="modal__close btn__close--modal" v-on:click="closeModal()">×</span>
            <h3 class="modal__title">Add Item</h3>
            <hr><br>
            <div class="modal__items">
                <ul>
                    <li style="display: grid; grid-template-columns: 30px 350px 15px;
                     align-items: center; padding-bottom: 4px;"  v-for="(product , i) in products_list" :key="product.id">
                     
                    <p>{{i+1}}</p>
                    <a href="">{{product.code}} : {{product.description}}</a>
                    <button @click="addCart(product)" 
                    style="border:1px solid #e0e0e0 ; width: 35px; height: 35px;cursor: pointer;"> +
                   </button>
                    </li>
                </ul>
            </div>
            <br><hr>
            <div class="model__footer">
                <button class="btn btn-light mr-2 btn__close--modal">
                    Cancel
                </button>
                <button class="btn btn-light btn__close--modal ">Save</button>
            </div>
        </div>
    </div>
    
    <br><br><br>

    </div>
</template>

<script setup >
import axios from 'axios';
import { onMounted,ref } from 'vue';

let customers_list = ref([])
let customer_id = ref([])

let cartList = ref([])
let products_list =ref([])
const showModal = ref(false)
const hideModal = ref(true)
let invoice = ref([])
const props = defineProps({
    id:{
        type:String,
        default:''
    }
})


onMounted(async()=>{
    getInvoice()
    getCustomers()
    getProducts()
})
const getCustomers = async ()=>{
    let response = await axios.get('/api/customers')
customers_list.value= response.data.customers
}
const getInvoice = async()=>{
    let response =await axios.get(`/api/invoices/${props.id}`)
    invoice.value = response.data.invoice
    console.log(invoice.value)
}
const deleteInvoice = async(id,i)=>{
invoice.value.items.slice(i,1)
if(id != undefined){
    axios.delete('/api/invoice/items/delete/'+id)
}
}
const getProducts = async ()=>{
    let response = await axios.get('/api/products')
products_list.value= response.data.products
}

const addCart = async (item)=>{
const cart_item = {
    product_id: item.id,
    description:item.description,
    unit_price:item.unit_price,
    quantity: item.quantity,

}
invoice.value.items.push(cart_item)
closeModal()
}

const removeItem = async (i)=>{
    cartList.value.splice(i,1)
}


const openModal= ()=>{
showModal.value = ! showModal.value
}
const closeModal = () => {
    showModal.value = ! hideModal.value
}



</script>