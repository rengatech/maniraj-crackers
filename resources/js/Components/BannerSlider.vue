<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue'

const props = defineProps({
    images: { type: Array, default: () => [] },
    fallback: { type: String, default: '' },
    alt: { type: String, default: '' },
    interval: { type: Number, default: 4000 },
    imgClass: { type: String, default: '' },
})

const slides = computed(() => {
    const list = (props.images || []).filter(Boolean).map((p) => (p.startsWith('http') || p.startsWith('/') ? p : '/storage/' + p))
    return list.length ? list : props.fallback ? [props.fallback] : []
})

const current = ref(0)
let timer = null

const next = () => {
    current.value = (current.value + 1) % slides.value.length
}
const prev = () => {
    current.value = (current.value - 1 + slides.value.length) % slides.value.length
}
const goTo = (i) => {
    current.value = i
    restart()
}

const stop = () => {
    if (timer) clearInterval(timer)
    timer = null
}
const start = () => {
    stop()
    if (slides.value.length > 1) timer = setInterval(next, props.interval)
}
const restart = () => start()

// touch swipe
let touchX = null
const onTouchStart = (e) => { touchX = e.changedTouches[0].clientX }
const onTouchEnd = (e) => {
    if (touchX === null) return
    const dx = e.changedTouches[0].clientX - touchX
    if (Math.abs(dx) > 40) { dx < 0 ? next() : prev(); restart() }
    touchX = null
}

watch(slides, () => { current.value = 0; start() })
onMounted(start)
onBeforeUnmount(stop)
</script>

<template>
    <div
        v-if="slides.length"
        class="relative w-full overflow-hidden"
        @mouseenter="stop"
        @mouseleave="start"
        @touchstart.passive="onTouchStart"
        @touchend.passive="onTouchEnd"
    >
        <!-- first slide sets the height, others are absolutely stacked -->
        <div class="relative">
            <img
                v-for="(src, i) in slides"
                :key="src"
                :src="src"
                :alt="alt"
                :fetchpriority="i === 0 ? 'high' : 'auto'"
                :loading="i === 0 ? 'eager' : 'lazy'"
                decoding="async"
                :class="[
                    'block w-full transition-opacity duration-700 ease-in-out',
                    imgClass,
                    i === 0 ? 'relative' : 'absolute inset-0 h-full object-cover',
                    i === current ? 'opacity-100' : 'opacity-0',
                ]"
            />
        </div>

        <slot />

        <template v-if="slides.length > 1">
            <button
                type="button"
                aria-label="Previous slide"
                class="absolute left-3 top-1/2 z-20 -translate-y-1/2 rounded-full bg-black/40 p-2 text-white hover:bg-black/60 focus:outline-none"
                @click="prev(); restart()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button
                type="button"
                aria-label="Next slide"
                class="absolute right-3 top-1/2 z-20 -translate-y-1/2 rounded-full bg-black/40 p-2 text-white hover:bg-black/60 focus:outline-none"
                @click="next(); restart()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>

            <div class="absolute bottom-3 left-1/2 z-20 flex -translate-x-1/2 gap-2">
                <button
                    v-for="(src, i) in slides"
                    :key="'dot-' + i"
                    type="button"
                    :aria-label="'Go to slide ' + (i + 1)"
                    :class="['h-2.5 w-2.5 rounded-full transition-colors', i === current ? 'bg-white' : 'bg-white/50 hover:bg-white/80']"
                    @click="goTo(i)"
                ></button>
            </div>
        </template>
    </div>
</template>
