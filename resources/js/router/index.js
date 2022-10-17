import { createRouter,createWebHistory } from "vue-router";
import invoiceIndex from '../components/invoices/index.vue'
import newInvoice from '../components/invoices/new.vue'
import showInvoice from '../components/invoices/show.vue'
import editInvoice from '../components/invoices/edit.vue'

import notFound from '../components/notFound.vue'




const routes =[
{
    path:'/',
    component : invoiceIndex

},
{
    path:'/invoices/edit/:id',
    component : editInvoice,
    props:true
},
{
    path:'/invoices/:id',
    component : showInvoice,
    props:true
},
{
    path:'/invoice/new',
    component : newInvoice

},
{
    path:'/:pathMatch(.*)*',
    component:notFound
}
]
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export  default router