<template>
   <div class="container">
      <!--==================== NEW INVOICE ====================-->
      <div class="invoices">
        
        <div class="card__header">
            <div>
                <h2 class="invoice__title">New Invoice</h2>
            </div>
            <div>
                
            </div>
        </div>

        <div class="card__content">
            <div class="card__content--header">
                <div>
                    <p class="my-1">Customer</p>
                    <select name="" id="" class="input" v-model="customer_id" placeholder="Choose Customers">
                        <option disabled>Select Customer</option>
                        <option  v-for="customer in customers_list" :value="customer.id">{{customer.firstName}}</option>
                    </select>
                </div>
                <div>
                    <p class="my-1">Date</p> 
                    <input id="date" placeholder="dd-mm-yyyy" type="date"  v-model="form.invoice_date"  class="input"> <!---->
                    <p class="my-1">Due Date</p> 
                    <input id="due_date" type="date" class="input" v-model="form.due_date">
                </div>
                <div>
                    <p class="my-1" >Numero</p> 
                    <input type="text" class="input" v-model="form.number"> 
                    <p class="my-1">Reference(Optional)</p> 
                    <input type="text" class="input" v-model="form.reference">
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
                <div class="table--items2" v-for="(cart_item,i) in cartList" :key="cart_item.id">
                    <p>{{cart_item.item_code}}   {{cart_item.description}}</p>
                    <p>
                        <input type="text" class="input"   v-model="cart_item.unite_price">
                    </p>
                    <p>
                        <input type="text" class="input" v-model="cart_item.quantity" >
                    </p>
                    <p v-if="cart_item.quantity">
                       {{(cart_item.quantity * cart_item.unite_price)}}
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
                    <textarea cols="50" rows="7" class="textarea" v-model="form.terms_and_conditions" ></textarea>
                </div>
                <div>
                    <div class="table__footer--subtotal">
                        <p>Sub Total</p>
                        <span>$ {{subTotal()}}</span>
                    </div>
                    <div class="table__footer--discount">
                        <p>Discount</p>
                        <input type="text" class="input" v-model="form.discount">
                    </div>
                    <div class="table__footer--total">
                        <p>Grand Total</p>
                        <span>$ {{Total()}}</span>
                    </div>
                </div>
            </div>

           
        </div>
        <div class="card__header" style="margin-top: 40px;">
            <div>
                
            </div>
            <div>
                <a class="btn btn-secondary" @click="onSave()">
                    Save
                </a>
            </div>
        </div>
        
    </div>
      <!--==================== add modal items ====================-->
      <div class="modal main__modal " :class="{show : showModal}">
        <div class="modal__content">
            <span class="modal__close btn__close--modal" v-on:click="closeModal()">×</span>
            <h3 class="modal__title">Add Item</h3>
            <hr><br>
            <div class="modal__items">
                <ul>
                    <li  style="display: grid;grid-template-columns: 30px 350px 15px;
                     align-items: center; padding-bottom: 4px;"   v-for="(product , i) in products_list" :key="product.id">
                     
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
                <button class="btn btn-light mr-2 btn__close--modal" @click="closeModal()">
                    Cancel
                </button>
                <button class="btn btn-light btn__close--modal " >Save</button>
            </div>
        </div>
    </div>
   </div>
</template>


<script setup>
import axios from 'axios';
import { onMounted,ref } from 'vue';
import router from '../../router';

let form = ref([])
let customers_list = ref([])
let customer_id = ref([])
let item =ref([])
let cartList = ref([])
let products_list =ref([])
const showModal = ref(false)
const hideModal = ref(true)
onMounted( async ()=>{
    indexForm()
    getCustomers()
    getProducts()
})
const indexForm = async ()=>{
    let response = await axios.get('/api/invoices/create_invoice')
form.value= response.data
}

const getCustomers = async ()=>{
    let response = await axios.get('/api/customers')
customers_list.value= response.data.customers
}
const getProducts = async ()=>{
    let response = await axios.get('/api/products')
products_list.value= response.data.products
}

const addCart = async (item)=>{
const cart_item = {
    id: item.id,
    code: item.code,
    description:item.description,
    unite_price:item.unite_price,
    quantity: item.quantity,

}
cartList.value.push(cart_item)
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

const subTotal = ()=>{
    let subtotal = 0
    
    cartList.value.map((item) =>{
        if(item.quantity){
subtotal = subtotal + (item.unite_price * item.quantity)
}
    })
    return subtotal
}

const Total = ()=>{
    let total=subTotal() - form.value.discount
    return total
}


const onSave = ()=>{
    if(cartList.value.length >= 1 ){
        let subtotal = 0
        subtotal=subTotal()
        let total = 0
        total = Total()

        const formData = new FormData()

        formData.append('invoice_product',JSON.stringify(cartList.value))
        formData.append('customer_id',customer_id.value)
        formData.append('invoice_date',form.value.invoice_date)
        formData.append('due_date',form.value.due_date)
        formData.append('number',form.value.number)
        formData.append('reference',form.value.reference)
        formData.append('discount',form.value.discount)
        formData.append('subtotal',subtotal)
        formData.append('total',total)
        formData.append('terms_and_conditions',form.value.terms_and_conditions)

        axios.post("/api/invoices/",formData)
        cartList = []
        router.push('/')
        







    }
}
</script>
