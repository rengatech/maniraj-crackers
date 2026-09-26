<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import BannerSlider from '@/Components/BannerSlider.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    status: String,
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
    banner_images: { type: Array, default: () => [] },
})

const showContactModal = ref(false)

// Cart icon in navbar now sends the user to OrderNow to checkout
const scrollToCheckout = () => {
    router.visit('/order-now')
}
</script>

<template>
    <Head title="Buy Crackers Online Sivakasi | Wholesale Fireworks">
        <meta name="description" content="Buy crackers online from Maniraj Crackers, Sivakasi. Wholesale & retail fireworks at best prices. Sparklers, aerial shots, gift boxes. All India delivery." />
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
        <BannerSlider
            :images="banner_images"
            fallback="/assets/img/homepage-banner.png"
            alt="Maniraj Crackers"
            img-class="h-auto md:h-[600px] md:object-cover"
            class="text-center text-white"
        >
            <div class="animate-shimmer pointer-events-none absolute inset-0"></div>
        </BannerSlider>


        <!-- Marquee / Announcement -->
        <div v-if="marquee_content" class="overflow-hidden py-1.5" style="background: linear-gradient(to right, #4c1d95, #4c1d95, #4c1d95);">
            <p class="animate-marquee whitespace-nowrap text-sm font-medium text-white sm:text-base">
                {{ marquee_content }}
            </p>
        </div>

        <!-- Home About/Promo Section -->
        <div class="mx-auto max-w-6xl px-4 py-12">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <!-- Left: Text -->
                <div>
                    <h2 class="mt-2 font-heading text-3xl font-bold text-brand-dark sm:text-4xl">
                        Welcome to Maniraj Crackers
                    </h2>
                    <p class="mt-4 text-sm leading-relaxed text-brand-gray sm:text-base">
                        Best quality fireworks online from Sivakasi, at wholesale and retail prices.
                        Browse our full range of crackers, sparklers, aerial shots and gift boxes.
                        All orders are dispatched through registered and authorized transport
                        service providers, ensuring safe and reliable delivery across the country.
                    </p>
                </div>

                <!-- Right: Logo -->
                <div class="flex justify-center">
                    <img
                        src="/assets/img/maniraj.logo.jpg"
                        alt="Maniraj Crackers"
                        class="h-64 w-64 rounded-full object-cover shadow-lg sm:h-72 sm:w-72"
                    />
                </div>
            </div>

            <!-- Feature cards -->
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-brand-red">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                    </div>
                    <h3 class="font-heading text-base font-semibold text-brand-dark">Genuine Price</h3>
                    <p class="mt-1 text-sm text-brand-gray">We offer genuine and affordable prices without hidden charges</p>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-brand-red">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                    </div>
                    <h3 class="font-heading text-base font-semibold text-brand-dark">Best Quality</h3>
                    <p class="mt-1 text-sm text-brand-gray">Every product is carefully selected to ensure top quality</p>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-brand-red">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="font-heading text-base font-semibold text-brand-dark">Safe To Use</h3>
                    <p class="mt-1 text-sm text-brand-gray">All our crackers are tested and safe for family celebrations</p>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-brand-red">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                    </div>
                    <h3 class="font-heading text-base font-semibold text-brand-dark">Trusted</h3>
                    <p class="mt-1 text-sm text-brand-gray">Trusted by thousands of customers across Tamil Nadu</p>
                </div>
            </div>
        </div>

        <!-- Bank Details Section -->
        <div v-if="bank_details && bank_details.length > 0" class="bg-white py-10">
            <div class="mx-auto max-w-6xl px-4">
                <h2 class="mb-6 text-center font-heading text-2xl font-bold text-brand-dark">
                    Bank Details
                </h2>
                <div class="mx-auto grid max-w-4xl gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="(bank, bankIndex) in bank_details"
                        :key="bank.id"
                        class="animate-fade-up rounded-xl bg-brand-maroon p-5 text-white transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg"
                        :style="{ animationDelay: `${bankIndex * 0.1}s` }"
                    >
                        <div class="space-y-2 text-sm">
                            <p><span class="text-white/70">Name:</span> <span class="font-semibold text-yellow-300">{{ bank.name }}</span></p>
                            <p><span class="text-white/70">Bank:</span> <span class="font-semibold text-yellow-300">{{ bank.bank_name }}</span></p>
                            <p><span class="text-white/70">A/C No:</span> <span class="font-semibold text-yellow-300">{{ bank.account_number }}</span></p>
                            <p><span class="text-white/70">IFSC:</span> <span class="font-semibold text-yellow-300">{{ bank.ifsc_code }}</span></p>
                            <p><span class="text-white/70">Branch:</span> <span class="font-semibold text-yellow-300">{{ bank.branch }}</span></p>
                            <p><span class="text-white/70">Google Pay:</span> <span class="font-semibold text-yellow-300">{{ bank.g_pay }}</span></p>
                            <img
                                v-if="bank.image"
                                :src="'/storage/' + bank.image"
                                alt="Bank Screenshot"
                                class="mt-2 max-w-[200px] rounded-lg border-2 border-yellow-300"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>