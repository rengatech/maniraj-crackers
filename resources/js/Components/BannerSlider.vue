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
const root = ref(null)
const ratios = ref({}) // src -> naturalHeight / naturalWidth
const width = ref(0)
let timer = null

const onImgLoad = (e) => {
    const img = e.target
    if (img.naturalWidth) ratios.value = { ...ratios.value, [img.currentSrc || img.src]: img.naturalHeight / img.naturalWidth }
}
const measure = () => { if (root.value) width.value = root.value.clientWidth }
const heightStyle = computed(() => {
    const src = slides.value[current.value]
    const r = ratios.value[src] ?? Object.values(ratios.value)[0]
    return r && width.value ? { height: Math.round(width.value * r) + 'px' } : {}
})

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
const onVisibility = () => (document.hidden ? stop() : start())

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
onMounted(() => {
    measure()
    start()
    // ratios for already-cached images whose load event fired before hydration
    root.value?.querySelectorAll('img').forEach((img) => { if (img.complete) onImgLoad({ target: img }) })
    window.addEventListener('resize', measure)
    document.addEventListener('visibilitychange', onVisibility)
})
onBeforeUnmount(() => {
    stop()
    window.removeEventListener('resize', measure)
    document.removeEventListener('visibilitychange', onVisibility)
})
</script>

<template>
    <div
        v-if="slides.length"
        ref="root"
        class="relative w-full overflow-hidden"
        @touchstart.passive="onTouchStart"
        @touchend.passive="onTouchEnd"
    >
        <!-- container height follows the current slide's aspect ratio; images are never cropped -->
        <div class="grid transition-[height] duration-700 ease-in-out" :style="heightStyle">
            <img
                v-for="(src, i) in slides"
                :key="src"
                :src="src"
                :alt="alt"
                :fetchpriority="i === 0 ? 'high' : 'auto'"
                :loading="i === 0 ? 'eager' : 'lazy'"
                decoding="async"
                @load="onImgLoad"
                :class="[
                    'block w-full h-full object-contain self-center [grid-area:1/1] transition-opacity duration-700 ease-in-out',
                    imgClass,
                    i === current ? 'opacity-100' : 'opacity-0 pointer-events-none',
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
