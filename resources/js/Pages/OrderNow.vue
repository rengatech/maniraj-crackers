<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { ref, computed, nextTick, onMounted, onUnmounted } from 'vue'
import { useStore } from 'vuex'
import { pick } from 'lodash'

const props = defineProps({
    status: String,
    categories: Object,
    global_discount: Number,
    starting_year: Number,
    min_order_value: Number,
    mobile_number_1: Number,
    mobile_number_2: Number,
    mobile_number_3: Number,
    mobile_number_4: Number,
    mobile_number_5: Number,
    marquee_content: Object,
    bank_details: Object,
    company_address: String,
})

const store = useStore()
const showAnnouncement = ref(true)
const showContactModal = ref(false)
const imageModal = ref(null)
const bannerImages = [
    { src: '/assets/img/ordernow-banner.jpeg', filter: 'none', overlay: false, position: 'center', fit: 'cover', height: null }
]

const currentBanner = ref(0)
let bannerInterval = null

// Category accordion
const openCategories = ref(
    props.categories ? props.categories.map(c => c.id) : []
)

const collapseAll = () => { openCategories.value = [] }
const expandAll = () => { openCategories.value = props.categories ? props.categories.map(c => c.id) : [] }
const allExpanded = computed(() => props.categories && openCategories.value.length === props.categories.length)
const toggleCategory = (id) => {
    const index = openCategories.value.indexOf(id)
    if (index === -1) openCategories.value.push(id)
    else openCategories.value.splice(index, 1)
}
const isCategoryOpen = (id) => openCategories.value.includes(id)

// Cart
const totalPrice = computed(() => store.getters.totalPrice)
const totalItems = computed(() => store.getters.totalItems)
const cartItems = computed(() => store.state.cartItems)
const itemCount = (id) => store.getters.countByItem(id)

const addItem = (product, categoryName) => store.commit('addToCart', { ...product, category_name: categoryName })
const removeItem = (product) => store.commit('removeItemFromCart', product)
const deleteItem = (item) => store.commit('deleteFromCart', item)
const clearCart = () => store.commit('clearCart')

const discountAmount = (price) => Math.round((price * props.global_discount) / 100)
const finalPrice = (price) => price - discountAmount(price)

const discountTotalAmount = computed(() =>
    Math.round((props.global_discount / 100) * totalPrice.value)
)
const NO_DISCOUNT_CATEGORIES = ['DIGITAL POPS', 'SPL GIFT BOXES'];

const isExcludedItem = (item) => NO_DISCOUNT_CATEGORIES.includes(item.category_name?.trim().toUpperCase());
const itemFinalPrice = (item) => isExcludedItem(item) ? item.price : finalPrice(item.price);

const discountedTotal = computed(() => {
    let total = 0;
    for (const item of cartItems.value) {
        const isExcluded = NO_DISCOUNT_CATEGORIES.includes(item.category_name?.trim().toUpperCase());
        const itemTotal = item.quantity * item.price;
        total += isExcluded ? itemTotal : (itemTotal - (itemTotal * props.global_discount) / 100);
    }
    return Math.round(total);
})
const canSubmit = computed(() => discountedTotal.value >= props.min_order_value)

// Checkout form
const orderItems = computed(() =>
    store.getters.getOrderItems.map(item => pick(item, ['id', 'quantity']))
)

const sameAsMobile = ref(true)
const submitting = ref(false)

const form = useForm({
    name: '',
    mobile_number: '',
    whatsapp_number: '',
    address: '',
    city_town: '',
    order_items: null,
    payment_screenshot: null,
})

const isMobileValid = computed(() => /^\d{10}$/.test(form.mobile_number))
const isWhatsAppValid = computed(() => /^\d{10}$/.test(form.whatsapp_number))

const handleSameAsMobile = () => {
    if (sameAsMobile.value) form.whatsapp_number = form.mobile_number
}

const handleScreenshotUpload = (e) => {
    form.payment_screenshot = e.target.files[0]
}

const submitOrder = () => {
    if (submitting.value) return
    submitting.value = true
    form.order_items = orderItems
    form.post(route('orders.store'), {
        onSuccess: () => store.commit('clearCart'),
        onError: () => { submitting.value = false },
    })
}

const scrollToCheckout = () => {
    document.getElementById('checkout-section')?.scrollIntoView({ behavior: 'smooth' })
}

// Smart scroll button — toggles between top/bottom based on position
const isNearBottom = ref(false)
const onScroll = () => {
    const scrollPos = window.scrollY + window.innerHeight
    isNearBottom.value = scrollPos >= document.body.scrollHeight - 200
}
const smartScroll = () => {
    if (isNearBottom.value) {
        window.scrollTo({ top: 0, behavior: 'smooth' })
    } else {
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' })
    }
}
onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true })
    // Auto-scroll to checkout if navigated from another page
    const params = new URLSearchParams(window.location.search)
    if (params.get('scroll') === 'checkout') {
        nextTick(() => {
            document.getElementById('checkout-section')?.scrollIntoView({ behavior: 'smooth' })
        })
        // Clean up URL
        window.history.replaceState({}, '', window.location.pathname)
    }
})
onUnmounted(() => {
 window.removeEventListener('scroll', onScroll)
 clearInterval(bannerInterval)
})
</script>

<template>
    <Head title="Buy Crackers Online Sivakasi | Wholesale Fireworks">
        <meta name="description" content="Buy crackers online from ManirajCrackers, Sivakasi. Wholesale & retail fireworks at best prices. Sparklers, aerial shots, gift boxes. All India delivery." />
    </Head>

    <AppLayout
        :global-discount="global_discount"
        :min-order-value="min_order_value"
        :company_address="company_address"
        :mobile_number_1="mobile_number_1"
        :mobile_number_2="mobile_number_2"
        :mobile_number_3="mobile_number_3"
        :mobile_number_4="mobile_number_4"
        :mobile_number_5="mobile_number_5"
        @contact-click="showContactModal = true"
        @scroll-to-checkout="scrollToCheckout"
    >
        <!-- Contact Modal -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showContactModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="showContactModal = false">
                <div class="mx-4 w-full max-w-sm rounded-xl bg-white p-6 text-center shadow-xl">
                    <h3 class="mb-4 font-heading text-lg font-bold text-brand-red">Contact Numbers</h3>
                    <div class="space-y-3">
                        <a v-if="mobile_number_1" :href="`tel:+91${mobile_number_1}`" class="block rounded-lg bg-gray-50 px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-red-50 hover:text-brand-red">+91 {{ mobile_number_1 }}</a>
                        <a v-if="mobile_number_2" :href="`tel:+91${mobile_number_2}`" class="block rounded-lg bg-gray-50 px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-red-50 hover:text-brand-red">+91 {{ mobile_number_2 }}</a>
                        <a v-if="mobile_number_3" :href="`tel:+91${mobile_number_3}`" class="block rounded-lg bg-gray-50 px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-red-50 hover:text-brand-red">+91 {{ mobile_number_3 }}</a>
                        <a v-if="mobile_number_4" :href="`tel:+91${mobile_number_4}`" class="block rounded-lg bg-gray-50 px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-red-50 hover:text-brand-red">+91 {{ mobile_number_4 }}</a>
                        <a v-if="mobile_number_5" :href="`tel:+91${mobile_number_5}`" class="block rounded-lg bg-gray-50 px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-red-50 hover:text-brand-red">+91 {{ mobile_number_5 }}</a>
                    </div>
                    <button @click="showContactModal = false" class="mt-4 rounded-lg bg-brand-dark px-6 py-2 text-sm font-semibold text-white hover:bg-gray-800">Close</button>
                </div>
            </div>
        </Transition>

        <!-- Hero Section -->
        <div class="relative w-full aspect-[2205/690] flex items-center justify-center overflow-hidden">
            <img
                src="/assets/img/ordernow-banner.png"
                alt="Order Now Maniraj Crackers"
                width="2205"
                height="600"
                fetchpriority="high"
                decoding="async"
                class="absolute inset-0 h-full w-full object-cover object-center"
            />
            <div class="relative z-10 text-center">
                <h1 class="text-5xl md:text-6xl font-black text-white drop-shadow-xl tracking-widest uppercase" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.7),;">
                </h1>
            </div>
        </div>

        <!-- Product List Table -->
        <div class="mx-auto max-w-[1600px] px-2 sm:px-4 pt-6 pb-32 md:pb-6 relative">
            <!-- Product Disclaimer -->
         <div
      class="mb-4 rounded-lg border border-red-500 bg-red-300 px-4 py-4 text-center text-sm text-black shadow-sm"
>
        <span class="font-semibold text-red-600">Note:</span>
      The Product Image is only for your reference — packing and brand may change.
    </div>
            <!-- Floating buttons (right side) -->
            <div class="fixed bottom-6 right-6 z-30 flex flex-col items-end gap-3">
                <button
                    @click="smartScroll"
                    class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-dark text-white shadow-lg transition-transform hover:scale-110"
                    :title="isNearBottom ? 'Scroll to top' : 'Scroll to bottom'"
                >
                    <!-- Up arrow when near bottom -->
                    <svg v-if="isNearBottom" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                    </svg>
                    <!-- Down arrow when near top/middle -->
                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <button
                    @click="allExpanded ? collapseAll() : expandAll()"
                    class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-dark text-white shadow-lg transition-transform hover:scale-110"
                    :title="allExpanded ? 'Collapse All' : 'Expand All'"
                >
                    <svg v-if="allExpanded" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>

            <!-- Top Totals Bar -->
             <div class="sticky top-[110px] md:top-[140px] z-40 flex justify-between items-center bg-blue-500 px-2 sm:px-6 py-2 sm:py-4 font-bold text-white text-xs sm:text-base border-b-2 border-white shadow-sm">
                <div class="flex flex-col sm:flex-row sm:gap-2 items-center justify-center w-1/3 text-center">
                    <span class="whitespace-nowrap mb-0.5 sm:mb-0">Total Products :</span>
                    <span class="text-[13px] sm:text-base">{{ totalItems }}</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:gap-2 items-center justify-center w-1/3 text-center">
                    <span class="whitespace-nowrap mb-0.5 sm:mb-0">Discount Total :</span>
                    <span class="text-[13px] sm:text-base">{{ global_discount }} %</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:gap-2 items-center justify-center w-1/3 text-center">
                    <span class="whitespace-nowrap mb-0.5 sm:mb-0 text-white-500">Overall Total :</span>
                    <span class="text-[13px] sm:text-base text-white-500">₹ {{ discountedTotal }}</span>
                </div>
            </div>

            <!-- Table / Mobile Cards -->
            <div class="shadow-sm bg-[#e5e7eb]">
                <!-- Desktop View (hidden on mobile) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap min-w-[800px] bg-[#efefef]">                    
                        <thead class="bg-[#d1d5db] text-[#24408e] font-bold text-sm">
                            <tr>
                                <th class="px-4 py-4 text-center w-24">Image</th>
                                <th class="px-4 py-4 text-center">Product Name</th>
                                <th class="px-4 py-4 text-center">Units</th>
                                <th class="px-4 py-4 text-center">Price</th>
                                <th class="px-4 py-4 text-center">Quantity</th>
                                <th class="px-4 py-4 text-center w-28">Total</th>
                            </tr>
                        </thead>
                        <tbody v-for="(category, catIndex) in categories" :key="category.id">
                            <!-- Category Header -->
                            <tr>
                                <td colspan="7" class="bg-[#64781e] text-white text-center py-2.5 font-bold uppercase tracking-wider text-sm cursor-pointer hover:bg-[#4d5e17] transition-colors" @click="toggleCategory(category.id)">
                                <span>{{ category.category }}</span>
                                <span v-if="category.tamil_name" class="text-yellow-300 text-xs ml-7"> &nbsp;&nbsp;{{ category.tamil_name }}</span>
                                <span class="float-right mr-4">{{ isCategoryOpen(category.id) ? '▲' : '▼' }}</span>
                                </td>
                            </tr>
                            <!-- Category Products -->
                            <tr v-show="isCategoryOpen(category.id)" v-for="(product, index) in category.products" :key="product.id" class="product-row h-30">
                                <!-- Image -->
                                <td class="px-4 py-3 text-center border-b border-white">
                                    <div class="flex justify-center">
                                        <img v-if="product.image" :src="'/storage/' + product.image" class="h-16 w-16 object-cover rounded shadow-sm cursor-pointer bg-white p-0.5 hover:scale-105 transition-transform" @click="imageModal = '/storage/' + product.image" />
                                        <div v-else class="h-16 w-16 bg-white rounded flex items-center justify-center text-gray-300 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V5.25a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v14.25a1.5 1.5 0 0 0 1.5 1.5Z" /></svg>
                                        </div>
                                    </div>
                                </td>
                                 <!-- Product Name (English + Tamil) -->
                                <td class="px-4 py-3 text-center">
                                <div class="font-bold text-gray-800">{{ product.name }}</div>
                                <div v-if="product.tamil_name" class="text-gray-500 text-sm">{{ product.tamil_name }}</div>
                                </td>
                                <!-- Units -->
                               <td class="px-4 py-3 text-center text-gray-600 text-sm">
                              {{ product.unit ?? '-' }}
                               </td>
                               <!-- Price -->
                               <td class="px-4 py-3 text-center">
                             <div v-if="global_discount > 0 && !['DIGITAL POPS', 'SPL GIFT BOXES'].includes(category.category?.trim().toUpperCase())" class="line-through text-gray-400 text-xs">₹ {{ product.price }}</div>
                             <div v-if="global_discount > 0 && !['DIGITAL POPS', 'SPL GIFT BOXES'].includes(category.category?.trim().toUpperCase())" class="text-green-600 font-bold">₹ {{ finalPrice(product.price) }}</div>
                             <div v-else class="text-gray-700 font-bold">₹ {{ product.price }}</div>
                             </td>
                               <!-- Quantity -->
                             <td class="px-4 py-3">
                             <div class="flex justify-center">
                             <div class="flex border border-gray-400 rounded-md overflow-hidden">
                             <button @click="removeItem(product)" class="w-8 h-8 flex items-center justify-center font-bold text-gray-700 bg-white hover:bg-gray-100">-</button>
                             <span class="w-14 h-8 flex items-center justify-center text-sm font-bold text-gray-700 bg-white border-l border-r border-gray-400">{{ itemCount(product.id) }}</span>
                             <button @click="addItem(product, category.category)" class="w-8 h-8 flex items-center justify-center font-bold text-gray-700 bg-white hover:bg-gray-100">+</button>
                             </div>
                             </div>
                             </td>

                                <!-- Total / Add -->
                                 <td class="px-4 py-3 text-center font-bold text-gray-800">
                  ₹ {{ (itemCount(product.id) * (global_discount > 0 && !['DIGITAL POPS', 'SPL GIFT BOXES'].includes(category.category?.trim().toUpperCase()) ? finalPrice(product.price) : product.price)).toFixed(2) }}
                         </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View (hidden on desktop) -->
                <div class="block md:hidden">
                    <div v-for="(category, catIndex) in categories" :key="category.id">
                        <!-- Category Header -->
                        <div class="bg-[#64781e] text-white py-2.5 font-bold uppercase tracking-wider text-sm cursor-pointer hover:bg-blue-800 transition-colors flex justify-between items-center px-4" @click="toggleCategory(category.id)">
                            <div class="flex-1 flex flex-col items-start text-left">
                                <span>{{ category.category }}</span>
                                <span v-if="category.tamil_name" class="text-yellow-300 text-xs mt-0.5">{{ category.tamil_name }}</span>
                            </div>
                            <span class="ml-2">{{ isCategoryOpen(category.id) ? '▲' : '▼' }}</span>
                        </div>
                        
                        <!-- Category Products -->
                        <div v-show="isCategoryOpen(category.id)" class="divide-y divide-gray-300">
                            <div v-for="(product, index) in category.products" :key="product.id" class="p-3 flex items-center gap-3 border-b-2 border-gray-300" :class="index % 2 === 0 ? 'bg-[#f3f4f6]' : 'bg-[#e5e7eb]'">
                                <!-- Image (Left) -->
                                <div class="shrink-0">
                                    <img v-if="product.image" :src="'/storage/' + product.image" class="h-16 w-16 object-cover rounded shadow-sm cursor-pointer bg-white p-0.5" @click="imageModal = '/storage/' + product.image" />
                                    <div v-else class="h-16 w-16 bg-white rounded flex items-center justify-center text-gray-300 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V5.25a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v14.25a1.5 1.5 0 0 0 1.5 1.5Z" /></svg>
                                    </div>
                                </div>

                                <!-- Details (Center) -->
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-gray-800 text-sm leading-tight truncate">{{ product.name }}</div>
                                    <div v-if="product.tamil_name" class="text-gray-500 text-xs mt-0.5 truncate">{{ product.tamil_name }}</div>
                                    <div v-if="product.unit" class="text-gray-600 text-xs mt-0.5">{{ product.unit }}</div>
                                    <div class="mt-1 flex items-center gap-2">
                                       <span v-if="global_discount > 0 && !['DIGITAL POPS', 'SPL GIFT BOXES'].includes(category.category?.trim().toUpperCase())" class="line-through text-gray-400 text-xs">₹{{ product.price }}</span>
                                       <span v-if="global_discount > 0 && !['DIGITAL POPS', 'SPL GIFT BOXES'].includes(category.category?.trim().toUpperCase())" class="text-green-600 font-bold text-sm">₹{{ finalPrice(product.price) }}</span>
                                       <span v-else class="text-gray-700 font-bold text-sm">₹{{ product.price }}</span>
                                    </div>
                                </div>
                                
                                <!-- Add/Qty Button (Right) -->
                         <div class="shrink-0 flex flex-col items-end justify-center gap-1">
                        <div class="flex border border-gray-400 rounded-md overflow-hidden bg-white">
                         <button @click="removeItem(product)" class="w-7 h-7 flex items-center justify-center font-bold text-gray-700 text-sm">-</button>
                          <span class="w-10 h-7 flex items-center justify-center text-xs font-bold text-gray-700 border-l border-r border-gray-400">{{ itemCount(product.id) }}</span>
                          <button @click="addItem(product, category.category)" class="w-7 h-7 flex items-center justify-center font-bold text-gray-700 text-sm">+</button>
                           </div>
                           <span class="text-xs font-bold text-gray-800">₹ {{ (itemCount(product.id) * (global_discount > 0 ? finalPrice(product.price) : product.price)).toFixed(2) }}</span>
                           </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== INLINE CHECKOUT SECTION ===== -->
        <div id="checkout-section" class="bg-gray-50 py-8">
            <div class="mx-auto max-w-6xl px-4">
                <h2 class="mb-6 text-center font-heading text-2xl font-bold text-brand-dark border-b-4 border-brand-red pb-3">Order Confirmation</h2>

                <!-- Empty cart state -->
                <div v-if="cartItems.length === 0" class="py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-4 h-16 w-16 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121 0 2.09-.773 2.34-1.867l1.86-8.154A.75.75 0 0 0 20.44 3.5H6.456M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <p class="text-lg font-medium text-gray-500">No items are added to cart</p>
                    <p class="mt-1 text-sm text-gray-400">Please add items from the product list above</p>
                </div>

                <form v-else @submit.prevent="submitOrder" class="grid gap-6 lg:grid-cols-5">
                    <!-- Order Summary -->
                    <div class="lg:col-span-3">
                        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-100 sm:p-6">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="font-heading text-lg font-semibold text-brand-dark">Order Summary ({{ totalItems }} items)</h3>
                                <button
                                    type="button"
                                    @click="clearCart"
                                    class="flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition-colors hover:bg-red-100"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    Clear Cart
                                </button>
                            </div>

                            <div class="divide-y">
                                <div v-for="item in cartItems" :key="item.id" class="py-3">
                                    <div class="flex items-center gap-3">
                                        <img
                                            v-if="item.image"
                                            :src="'/storage/' + item.image"
                                            :alt="item.name"
                                            class="h-9 w-9 shrink-0 rounded-md object-cover"
                                        />
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-brand-dark">{{ item.name }}</p>
                                            <div class="flex items-center gap-1.5">
                                                <span v-if="global_discount > 0 && !isExcludedItem(item)" class="text-xs text-gray-400 line-through">₹{{ item.price }}</span>
                                                <span class="text-xs" :class="global_discount > 0 && !isExcludedItem(item) ? 'text-green-600 font-medium' : 'text-gray-400'">₹{{ itemFinalPrice(item) }} each</span>
                                            </div>
                                        </div>
                                        <p class="shrink-0 text-sm font-semibold">₹{{ itemFinalPrice(item) * item.quantity }}</p>
                                    </div>
                                    <div class="mt-2 flex items-center justify-between">
                                        <button
                                            type="button"
                                            @click="deleteItem(item)"
                                            class="rounded-lg p-1.5 text-red-400 transition-colors hover:bg-red-50 hover:text-red-600"
                                            title="Remove item"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                        <div class="flex items-center rounded-lg bg-brand-red">
                                            <button type="button" @click="removeItem(item)" class="flex h-8 w-8 items-center justify-center rounded-l-lg text-base font-bold text-white active:bg-brand-red-hover">&minus;</button>
                                            <span class="w-7 text-center text-sm font-bold text-white">{{ item.quantity }}</span>
                                            <button type="button" @click="addItem(item)" class="flex h-8 w-8 items-center justify-center rounded-r-lg text-base font-bold text-white active:bg-brand-red-hover">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Totals -->
                            <div class="mt-4 space-y-2 border-t pt-4 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">MRP Total</span>
                                    <span>₹{{ totalPrice }}</span>
                                </div>
                                <div class="flex justify-between text-green-600">
                                    <span>Discount ({{ global_discount }}%)</span>
                                    <span>-₹{{ discountTotalAmount }}</span>
                                </div>
                                <div class="flex justify-between border-t pt-2 text-lg font-bold text-brand-dark">
                                    <span>Net Total</span>
                                    <span>₹{{ discountedTotal }}</span>
                                </div>
                            </div>

                            <p v-if="!canSubmit" class="animate-blink-color mt-4 rounded-lg bg-red-50 px-4 py-4 text-center text-base font-bold">
                                <span>Minimum order value: ₹{{ min_order_value }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div class="lg:col-span-2">
                        <div class="rounded-xl border-2 border-brand-red bg-white p-6 shadow-sm">
                            <h3 class="mb-4 font-heading text-lg font-semibold text-brand-dark">Customer Details</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-brand-dark">Name *</label>
                                    <input v-model="form.name" type="text" required class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base focus:border-brand-red focus:ring-brand-red" placeholder="Your full name" />
                                    <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name }}</p>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-brand-dark">Mobile Number *</label>
                                    <input v-model="form.mobile_number" type="tel" required class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base focus:border-brand-red focus:ring-brand-red" placeholder="10-digit mobile number" @input="sameAsMobile && (form.whatsapp_number = form.mobile_number)" />
                                    <p v-if="form.mobile_number && !isMobileValid" class="mt-1 text-xs text-red-500">Mobile number should be 10 digits</p>
                                </div>

                                <div>
                                    <div class="mb-1 flex items-center justify-between">
                                        <label class="text-sm font-semibold text-brand-dark">WhatsApp Number *</label>
                                        <label class="flex items-center gap-1.5 text-xs text-gray-400">
                                            <input v-model="sameAsMobile" type="checkbox" class="rounded border-gray-300 text-brand-red focus:ring-brand-red" @change="handleSameAsMobile" />
                                            Same as mobile
                                        </label>
                                    </div>
                                    <input v-model="form.whatsapp_number" type="tel" required :disabled="sameAsMobile" class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base focus:border-brand-red focus:ring-brand-red disabled:bg-gray-50" placeholder="10-digit WhatsApp number" />
                                    <p v-if="form.whatsapp_number && !isWhatsAppValid" class="mt-1 text-xs text-red-500">WhatsApp number should be 10 digits</p>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-brand-dark">City / Delivery Area *</label>
                                    <input v-model="form.city_town" type="text" required class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base focus:border-brand-red focus:ring-brand-red" placeholder="City or town" />
                                    <p v-if="form.errors.city_town" class="mt-1 text-xs text-red-500">{{ form.errors.city_town }}</p>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-brand-dark">Delivery Address *</label>
                                    <textarea v-model="form.address" required rows="3" class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base focus:border-brand-red focus:ring-brand-red" placeholder="Full delivery address"></textarea>
                                    <p v-if="form.errors.address" class="mt-1 text-xs text-red-500">{{ form.errors.address }}</p>
                                </div>
                                <div>
                                  <label class="mb-1.5 block text-sm font-semibold text-brand-dark">Payment Screenshot (Optional)</label>
                                 <input
                                   type="file"
                                   accept="image/*"
                                  @change="handleScreenshotUpload"
                                 class="w-full rounded-lg border-2 border-gray-300 px-4 py-2.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-brand-red file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white"
                                />
                              <p class="mt-1 text-xs text-gray-400">Upload your payment/UPI screenshot if you've already paid.</p>
                             <p v-if="form.errors.payment_screenshot" class="mt-1 text-xs text-red-500">{{ form.errors.payment_screenshot }}</p>
                            </div>
                            </div>

                            <button
                                type="submit"
                                :disabled="!canSubmit || !isMobileValid || !isWhatsAppValid || submitting"
                                :class="[
                                    'mt-6 w-full rounded-lg py-3 text-sm font-semibold text-white transition-colors',
                                    canSubmit && isMobileValid && isWhatsAppValid && !submitting
                                        ? 'bg-brand-red hover:bg-brand-red-hover'
                                        : 'bg-gray-300 cursor-not-allowed',
                                ]"
                            >
                                <span v-if="submitting" class="flex items-center justify-center gap-2">
                                    <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25" />
                                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" class="opacity-75" />
                                    </svg>
                                    Placing Order...
                                </span>
                                <span v-else>Place Order — ₹{{ discountedTotal }}</span>
                            </button>
                            <p v-if="!canSubmit" class="animate-blink-color mt-3 rounded-lg bg-red-50 px-4 py-4 text-center text-base font-bold">
                                <span>Minimum order value: ₹{{ min_order_value }}</span>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bank Details Section -->
        <div v-if="bank_details && bank_details.length > 0" class="bg-[#fffbeb] py-10">
            <div class="mx-auto max-w-6xl px-4">
                <h2 class="mb-6 text-center font-heading text-2xl font-bold text-brand-dark">
                    Bank Details
                </h2>
                <div class="mx-auto flex flex-wrap justify-center gap-6">
                    <div
                        v-for="(bank, bankIndex) in bank_details"
                        :key="bank.id"
                        class="animate-fade-up rounded-2xl border border-yellow-400 bg-[#64781e] p-6 sm:p-8 text-white min-w-[320px] max-w-sm"
                        :style="{ animationDelay: `${bankIndex * 0.1}s` }"
                    >
                        <div class="space-y-3 text-[15px] leading-relaxed">
                            <p>Name :- {{ bank.name }}</p>
                            <p>Bank Name :- {{ bank.bank_name }}</p>
                            <p>Acc No :- {{ bank.account_number }}</p>
                            <p>Bank Branch :- {{ bank.branch }}</p>
                            <p>IFSC Code :- {{ bank.ifsc_code }}</p>
                            <p v-if="bank.g_pay">Gpay Number :- {{ bank.g_pay }}</p>
                            <p v-if="bank.phone_pay">Phone Pay :- {{ bank.phone_pay }}</p>
                            <div v-if="bank.image" class="pt-2">
                                <p class="mb-2">QR Scanner :</p>
                                <img
                                    :src="'/storage/' + bank.image"
                                    alt="Bank Screenshot"
                                    class="max-w-[200px] rounded-lg border border-white/20 shadow-sm"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Popup Modal -->
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 scale-90"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-90"
        >
            <div v-if="imageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4" @click="imageModal = null">
                <img :src="imageModal" alt="Product" class="max-h-[80vh] max-w-full rounded-xl object-contain shadow-2xl" />
                <button @click="imageModal = null" class="absolute right-4 top-4 rounded-full bg-white/20 p-2 text-white backdrop-blur hover:bg-white/40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </Transition>

    </AppLayout>
</template>

