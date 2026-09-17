<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { blogPosts } from '@/data/blogPosts'

const props = defineProps({
    company_address: String,
    mobile_number_1: Number,
    mobile_number_2: Number,
    mobile_number_3: Number,
    mobile_number_4: Number,
    mobile_number_5: Number,
})

const showContactModal = ref(false)

const formatDate = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' })
}

const categoryColor = (cat) => {
    const colors = { Guide: 'bg-blue-100 text-blue-700', Education: 'bg-green-100 text-green-700', Safety: 'bg-orange-100 text-orange-700' }
    return colors[cat] || 'bg-gray-100 text-gray-700'
}
</script>

<template>
    <Head title="Blog - Crackers Guide, Safety Tips & Diwali Ideas | Maniraj Crackers">
        <meta name="description" content="Crackers blog by Maniraj Crackers Sivakasi. Diwali guides, safety tips, green crackers info, wholesale buying tips, price lists, and fireworks education." />
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
                    <button @click="showContactModal = false" class="mt-4 text-sm text-gray-400 hover:text-gray-600">Close</button>
                </div>
            </div>
        </Transition>

        <div class="bg-gradient-to-b from-red-50 to-white py-12">
            <div class="mx-auto max-w-4xl px-4">
                <h1 class="mb-2 text-center font-heading text-3xl font-bold text-brand-dark sm:text-4xl">Blog</h1>
                <p class="mb-10 text-center text-gray-500">Guides, safety tips, and everything about crackers</p>

                <div class="grid gap-6 sm:grid-cols-2">
                    <Link
                        v-for="(post, index) in blogPosts"
                        :key="index"
                        :href="`/blog/${post.slug}`"
                        class="group overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5"
                    >
                        <div class="p-5">
                            <div class="mb-2 flex items-center gap-3">
                                <span :class="['rounded-full px-2.5 py-0.5 text-xs font-semibold', categoryColor(post.category)]">{{ post.category }}</span>
                                <span class="text-xs text-gray-400">{{ formatDate(post.date) }}</span>
                            </div>
                            <h2 class="mb-2 text-base font-bold text-brand-dark group-hover:text-brand-red transition-colors sm:text-lg">{{ post.title }}</h2>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ post.excerpt }}</p>
                            <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-brand-red">
                                Read more
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </span>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
