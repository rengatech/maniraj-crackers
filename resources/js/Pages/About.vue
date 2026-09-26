<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import BannerSlider from '@/Components/BannerSlider.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const showContactModal = ref(false)

const props = defineProps({
    about_page: Object,
    company_address: String,
    min_order_value: Number,
    mobile_number_1: Number,
    mobile_number_2: Number,
    mobile_number_3: Number,
    mobile_number_4: Number,
    mobile_number_5: Number,
    banner_images: { type: Array, default: () => [] },
})

const openFaq = ref(null)
const toggleFaq = (index) => {
    openFaq.value = openFaq.value === index ? null : index
}

const faqCategories = [
    {
        category: 'Ordering',
        items: [
            { question: 'How do I place an order?', answer: 'Browse our products, add items to your cart, and fill in your details in the order form. Our team will confirm your order shortly after.' },
            { question: 'What is the minimum order value?', answer: 'The minimum order value is displayed on the order form. Orders below this amount cannot be placed.' },
            { question: 'Can I modify or cancel my order after placing it?', answer: 'Please contact us as soon as possible via phone or WhatsApp. We will try our best to accommodate changes before dispatch.' },
            { question: 'How will I receive my order confirmation?', answer: 'You will receive an order confirmation via WhatsApp or phone call from our team.' },
        ],
    },
    {
        category: 'Delivery & Shipping',
        items: [
            { question: 'Do you deliver across India?', answer: 'Yes, we deliver crackers across Tamil Nadu and other states through trusted transport services.' },
            { question: 'How long does delivery take?', answer: 'Delivery typically takes a few days depending on your location and transport availability, especially during festival season.' },
            { question: 'How can I track my order?', answer: 'Once dispatched, we will share the transport/tracking details with you via WhatsApp or phone.' },
        ],
    },
    {
        category: 'Payment',
        items: [
            { question: 'What payment methods do you accept?', answer: 'We accept bank transfer, UPI/GPay, and other digital payment methods. Bank account and QR details are available on our website.' },
            { question: 'Is advance payment required?', answer: 'Yes, advance payment is required to confirm your order. Full details will be shared during order confirmation.' },
        ],
    },
    {
        category: 'Products & Safety',
        items: [
            { question: 'What is a green cracker?', answer: 'Green crackers are dubbed as \'eco-friendly\' crackers and are known to cause less air and noise pollution as compared to traditional firecrackers.' },
            { question: 'How to identify Green Crackers?', answer: 'SWAS - Safe Water Releaser: These crackers do not use sulphur or potassium nitrate, and thus release water vapour instead of certain key pollutants. STAR - Safe Thermite Cracker: Does not contain sulphur and potassium nitrate, has lower sound intensity. SAFAL - Safe Minimal Aluminium: Replaces aluminium content with magnesium and produces reduced levels of pollutants.' },
            { question: 'Who certifies Green Crackers?', answer: 'CSIR-NATIONAL ENVIRONMENTAL ENGINEERING RESEARCH INSTITUTE (CSIR-NEERI).' },
            { question: 'Are your products safe?', answer: 'Yes, all our crackers are PESO licensed and manufactured following strict safety standards from Sivakasi.' },
            { question: 'Can I buy fireworks anytime?', answer: 'You can\'t buy fireworks if you\'re under 18. If you\'re over 18, you can buy from registered sellers during permitted festival periods, or from a licensed shop at other times.' },
        ],
    },
    {
        category: 'Price & Offers',
        items: [
            { question: 'How long is the price list valid?', answer: 'The pricelist is change at any time, depending on product stock availability and the current purchasing price.' },
            { question: 'Do you offer discounts?', answer: 'Yes, we offer attractive discounts, especially during Diwali season. Check our homepage for the latest offers.' },
            { question: 'Are the prices inclusive of GST?', answer: 'Yes, all listed prices are inclusive of applicable taxes unless mentioned otherwise.' },
        ],
    },
]


const features = [
    { title: 'Genuine Price', icon: 'receipt', key: 'genuine_price' },
    { title: 'Best Quality', icon: 'cube', key: 'best_quality' },
    { title: 'Safe To Use', icon: 'shield-check', key: 'safe_to_use' },
    { title: 'Trusted', icon: 'shield', key: 'trusted' },
]
</script>

<template>
    <Head title="About Us - Maniraj Crackers Sivakasi">
        <meta name="description" content="About Maniraj Crackers - Trusted wholesale and retail crackers dealer in Sivakasi, Tamil Nadu. Genuine prices, best quality, safe green crackers." />
    </Head>

    <AppLayout
        :company_address="company_address"
        :mobile_number_1="mobile_number_1"
        :mobile_number_2="mobile_number_2"
        :mobile_number_3="mobile_number_3"
        :mobile_number_4="mobile_number_4"
        :mobile_number_5="mobile_number_5"
        @contact-click="showContactModal = true"
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

        <!-- Top Banner -->
        <BannerSlider
            :images="banner_images"
            fallback="/assets/img/aboutpage-banner.png"
            alt="About Maniraj Crackers"
            img-class="aspect-[2205/690] object-cover object-center brightness-105"
        />

        <div class="mx-auto max-w-6xl px-4 py-12">
         <!-- FAQ Section -->
<div class="mb-16">
    <h2 class="mb-2 text-center font-heading text-2xl md:text-3xl font-bold text-blue-700">Frequently Asked Questions</h2>
    <p class="text-center text-black text-sm mb-8">Everything you need to know about ordering crackers from Maniraj Crackers</p>

    <div class="max-w-3xl mx-auto space-y-8">
        <div v-for="(group, gIndex) in faqCategories" :key="gIndex">
            <h3 class="text-lg font-bold text-brand-red mb-3">{{ group.category }}</h3>
            <div class="space-y-3">
                <div v-for="(faq, index) in group.items" :key="index" class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                    <button
                        @click="toggleFaq(gIndex + '-' + index)"
                        class="w-full flex justify-between items-center px-5 py-4 bg-gray-50 hover:bg-gray-100 transition-colors text-left"
                    >
                        <span class="font-semibold text-brand-dark text-sm md:text-base">{{ faq.question }}</span>
                        <span class="text-xl text-brand-red shrink-0 ml-3">{{ openFaq === (gIndex + '-' + index) ? '−' : '+' }}</span>
                    </button>
                    <div v-show="openFaq === (gIndex + '-' + index)" class="px-5 py-4 bg-white text-gray-600 text-sm leading-relaxed border-t border-gray-200">
                        {{ faq.answer }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="bg-red-50 rounded-xl p-8 text-center mt-10">
            <h3 class="font-bold text-brand-dark text-lg mb-1">Still have questions?</h3>
            <p class="text-gray-500 text-sm mb-4">We're here to help. Contact us anytime!</p>
            <button @click="showContactModal = true" class="bg-brand-red text-white font-bold px-6 py-2.5 rounded-lg hover:bg-red-700 transition-colors">
                Contact Us
            </button>
        </div>
    </div>
</div>
    </div>
    </AppLayout>
</template>
