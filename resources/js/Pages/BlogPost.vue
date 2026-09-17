<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    post: Object,
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

const renderedContent = props.post.content
    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
    .replace(/\*(.*?)\*/g, '<em>$1</em>')
    .replace(/^- (.*)/gm, '<li>$1</li>')
    .replace(/(<li>.*<\/li>\n?)+/g, '<ul class="list-disc pl-5 space-y-1 my-2">$&</ul>')
    .replace(/\n\n/g, '</p><p class="mt-3">')
    .replace(/\n/g, '<br />')
</script>

<template>
    <Head :title="post.title + ' | Maniraj Crackers Blog'">
        <meta name="description" :content="post.excerpt" />
        <meta property="og:title" :content="post.title" />
        <meta property="og:description" :content="post.excerpt" />
        <meta property="og:type" content="article" />
        <meta property="article:published_time" :content="post.date" />
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
            <div class="mx-auto max-w-3xl px-4">
                <!-- Back link -->
                <Link href="/blog" class="mb-6 inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-brand-red">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    Back to Blog
                </Link>

                <!-- Article Header -->
                <article>
                    <div class="mb-4 flex items-center gap-3">
                        <span :class="['rounded-full px-2.5 py-0.5 text-xs font-semibold', categoryColor(post.category)]">{{ post.category }}</span>
                        <span class="text-sm text-gray-400">{{ formatDate(post.date) }}</span>
                    </div>

                    <h1 class="mb-4 font-heading text-2xl font-bold text-brand-dark sm:text-3xl leading-tight">{{ post.title }}</h1>
                    <p class="mb-8 text-gray-500">{{ post.excerpt }}</p>

                    <hr class="mb-8 border-gray-200" />

                    <!-- Article Body -->
                    <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed" v-html="renderedContent" />

                    <!-- CTA -->
                    <div class="mt-10 rounded-xl bg-brand-red/5 p-6 text-center">
                        <h3 class="mb-2 font-heading text-lg font-bold text-brand-dark">Order Crackers from Maniraj Crackers</h3>
                        <p class="mb-4 text-sm text-gray-500">Wholesale & retail prices direct from Sivakasi. All India delivery.</p>
                        <div class="flex flex-wrap items-center justify-center gap-3">
                            <Link href="/" class="rounded-lg bg-brand-red px-6 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-brand-red-hover">
                                Shop Now
                            </Link>
                            <button @click="showContactModal = true" class="rounded-lg border-2 border-brand-red px-6 py-2 text-sm font-semibold text-brand-red transition-colors hover:bg-brand-red hover:text-white">
                                Contact Us
                            </button>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </AppLayout>
</template>
