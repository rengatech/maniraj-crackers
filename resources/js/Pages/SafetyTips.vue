<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    mobile_number_1: Number,
    mobile_number_2: Number,
    company_address: String,
})

const doList = [
    'Buy crackers only from a licensed shop.',
    'Burst crackers in an open area, away from buildings and dry vegetation.',
    'Keep a bucket of water or sand nearby before lighting crackers.',
    'Light one cracker at a time and step back immediately.',
    'Wear cotton clothes; avoid loose or synthetic clothing.',
    'Supervise children at all times while bursting crackers.',
    'Store leftover crackers in a cool, dry place, away from flames.',
]

const dontList = [
    "Don't burst crackers inside homes, balconies, or near vehicles.",
    "Don't relight a cracker that has failed to burst — dispose of it safely in water.",
    "Don't hold crackers (sparklers, rockets) in your hand while lighting them.",
    "Don't wear loose, flowing, or nylon clothes near firecrackers.",
    "Don't burst crackers near hospitals, schools, or old-age homes.",
    "Don't allow young children to light crackers without adult supervision.",
    "Don't store crackers near stoves, candles, or other heat sources.",
]

const storageList = [
    'Keep crackers away from direct sunlight and moisture.',
    'Store in a dry, ventilated place — never in a sealed plastic bag.',
    'Keep away from children and pets, in a locked cupboard if possible.',
    'Never store crackers near cooking gas, stoves, or electrical points.',
]

const firstAidList = [
    'For minor burns, run cool (not ice-cold) water over the area for 10-15 minutes.',
    "Don't apply ice, butter, or ointments on a fresh burn.",
    'Cover the burn loosely with a clean, dry cloth.',
    'For eye injuries, do not rub — rinse gently with clean water and seek medical help immediately.',
    'For any serious injury, go to the nearest hospital right away.',
]

const ecoFeatures = [
    {
        title: 'Less Air Pollution',
        desc: 'Green crackers use safer raw materials and emit fewer harmful particles into the air.',
        icon: 'leaf',
    },
    {
        title: 'Reduced Noise',
        desc: 'Certified green crackers produce sound within permitted decibel limits, easier on ears and pets.',
        icon: 'speaker',
    },
    {
        title: 'CSIR-NEERI Certified',
        desc: 'Genuine green crackers carry a QR code and are certified by CSIR-NEERI for safety and compliance.',
        icon: 'badge',
    },
    {
        title: 'Water Vapour Release',
        desc: 'Many green crackers (like SWAS) release water vapour instead of key pollutants, reducing smog.',
        icon: 'droplet',
    },
]
</script>

<template>
    <Head title="Safety Tips - Maniraj Crackers">
        <meta name="description" content="Firecracker safety tips and eco-friendly green cracker information from Maniraj Crackers - do's, don'ts, storage, and first aid for a safe Diwali." />
    </Head>

    <AppLayout :mobile_number_1="mobile_number_1" :mobile_number_2="mobile_number_2" :company_address="company_address">
         <!-- Top Banner -->
    <div class="relative w-full aspect-[2205/690] flex items-center justify-center overflow-hidden">
        <img
            src="/assets/img/safetytips-banner.png"
            alt="Safety Tips - Maniraj Crackers"
            width="2205"
            height="500"
            fetchpriority="high"
            decoding="async"
            class="absolute inset-0 h-full w-full object-cover object-center"
        />
        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-black text-white drop-shadow-xl tracking-widest uppercase" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.6);">
            </h1>
        </div>
    </div>

        <div class="mx-auto max-w-6xl px-4 py-8">
            

            <!-- Do's & Don'ts -->
            <div class="grid gap-8 md:grid-cols-2 mb-14">
                <div class="rounded-xl bg-green-50 p-6 ring-1 ring-green-100">
                    <h2 class="mb-4 font-heading text-xl font-bold text-green-700">✔ Do's</h2>
                    <ul class="space-y-3">
                        <li v-for="(item, index) in doList" :key="index" class="flex items-start gap-2 text-sm text-brand-gray">
                            <span class="mt-0.5 text-green-600">✔</span>
                            <span>{{ item }}</span>
                        </li>
                    </ul>
                </div>

                <div class="rounded-xl bg-red-50 p-6 ring-1 ring-red-100">
                    <h2 class="mb-4 font-heading text-xl font-bold text-brand-red">✘ Don'ts</h2>
                    <ul class="space-y-3">
                        <li v-for="(item, index) in dontList" :key="index" class="flex items-start gap-2 text-sm text-brand-gray">
                            <span class="mt-0.5 text-brand-red">✘</span>
                            <span>{{ item }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Eco-Friendly / Green Crackers -->
            <div class="mb-14">
                <h2 class="mb-2 text-center font-heading text-2xl font-bold text-brand-dark">🌿 Eco-Friendly Green Crackers</h2>
                <p class="mb-6 text-center text-sm text-brand-gray max-w-2xl mx-auto">
                    Choose green crackers for a celebration that's kinder to the environment, without compromising the fun.
                </p>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="feature in ecoFeatures"
                        :key="feature.title"
                        class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-green-100 transition-all hover:shadow-md hover:-translate-y-0.5"
                    >
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path v-if="feature.icon === 'leaf'" stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                                <path v-if="feature.icon === 'speaker'" stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.757 3.63 8.25 4.51 8.25H6.75Z" />
                                <path v-if="feature.icon === 'badge'" stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                <path v-if="feature.icon === 'droplet'" stroke-linecap="round" stroke-linejoin="round" d="M12 21a7.5 7.5 0 0 0 5.303-12.803L12 3 6.697 8.197A7.5 7.5 0 0 0 12 21Z" />
                            </svg>
                        </div>
                        <h3 class="mb-1 font-heading text-base font-semibold text-brand-dark">{{ feature.title }}</h3>
                        <p class="text-sm text-brand-gray">{{ feature.desc }}</p>
                    </div>
                </div>
            </div>

            <!-- Storage & First Aid -->
            <div class="grid gap-8 md:grid-cols-2">
                <div class="rounded-xl bg-blue-50 p-6 ring-1 ring-blue-100">
                    <h2 class="mb-4 font-heading text-xl font-bold text-blue-700">📦 Storage Tips</h2>
                    <ul class="space-y-3">
                        <li v-for="(item, index) in storageList" :key="index" class="flex items-start gap-2 text-sm text-brand-gray">
                            <span class="mt-0.5 text-blue-600">•</span>
                            <span>{{ item }}</span>
                        </li>
                    </ul>
                </div>

                <div class="rounded-xl bg-yellow-50 p-6 ring-1 ring-yellow-100">
                    <h2 class="mb-4 font-heading text-xl font-bold text-yellow-700">🩹 First Aid Tips</h2>
                    <ul class="space-y-3">
                        <li v-for="(item, index) in firstAidList" :key="index" class="flex items-start gap-2 text-sm text-brand-gray">
                            <span class="mt-0.5 text-yellow-600">•</span>
                            <span>{{ item }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AppLayout>
</template>