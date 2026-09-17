<script setup>
import { Link } from '@inertiajs/vue3'
import { onMounted, onUnmounted, ref } from 'vue'

defineProps({
    company_address: String,
    mobile_number_1: Number,
    mobile_number_2: Number,
   
})

const canvasRef = ref(null)
let animationId = null

onMounted(() => {
    const canvas = canvasRef.value
    if (!canvas) return
    const ctx = canvas.getContext('2d')

    function resizeCanvas() {
        canvas.width = canvas.parentElement.clientWidth
        canvas.height = canvas.parentElement.clientHeight
    }
    resizeCanvas()
    window.addEventListener('resize', resizeCanvas)

    class Particle {
        constructor(x, y) {
            this.x = x
            this.y = y
            const angle = Math.random() * Math.PI * 2
            const speed = Math.random() * 4 + 1.5
            this.vx = Math.cos(angle) * speed
            this.vy = Math.sin(angle) * speed
            this.alpha = 1
            this.decay = Math.random() * 0.015 + 0.01
            this.size = Math.random() * 2.5 + 1.5
            // High contrast White and Gold Sparkles
            this.color = Math.random() > 0.3 ? '#FFFFFF' : '#FFD700'
        }

        update() {
            this.x += this.vx
            this.y += this.vy
            this.vy += 0.04 // Gravity effect
            this.vx *= 0.98
            this.vy *= 0.98
            this.alpha -= this.decay
        }

        draw() {
            ctx.save()
            ctx.globalAlpha = Math.max(this.alpha, 0)
            ctx.beginPath()
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2)
            ctx.fillStyle = this.color
            ctx.shadowBlur = 12
            ctx.shadowColor = '#FFFFFF'
            ctx.fill()
            ctx.restore()
        }
    }

    let particles = []

    function createExplosion() {
        if (!canvas) return
        const x = Math.random() * (canvas.width - 100) + 50
        const y = Math.random() * (canvas.height - 80) + 40
        const particleCount = 45 // Number of sparks per burst
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle(x, y))
        }
    }

    // Launch a firework every 700ms
    const interval = setInterval(createExplosion, 700)

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height)
        particles.forEach((p, index) => {
            p.update()
            p.draw()
            if (p.alpha <= 0) {
                particles.splice(index, 1)
            }
        })
        animationId = requestAnimationFrame(animate)
    }

    animate()

    onUnmounted(() => {
        clearInterval(interval)
        cancelAnimationFrame(animationId)
        window.removeEventListener('resize', resizeCanvas)
    })
})
</script>

<template>
    <!-- Beautiful Midnight Royal Blue Gradient Background -->
    <footer class="relative overflow-hidden bg-gradient-to-b from-[#0a1128] via-[#031b4e] to-[#010b26] text-gray-100 border-t-4 border-amber-400 shadow-[0_-10px_35px_rgba(255,215,0,0.4)]">
        
        <!-- Real JS Canvas Fireworks Animation Layer -->
        <canvas ref="canvasRef" class="pointer-events-none absolute inset-0 z-0 h-full w-full opacity-95"></canvas>

        <div class="relative z-10 mx-auto max-w-6xl px-4 py-12">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                
                <!-- Company Info -->
                <div>
                    <h3 class="mb-4 font-heading text-2xl font-extrabold tracking-wider text-amber-400 drop-shadow-[0_0_15px_rgba(255,215,0,0.9)]">
                         Maniraj Crackers
                    </h3>
                    <p class="mb-4 text-sm leading-relaxed text-gray-200">{{ company_address }}</p>
                    <div class="space-y-2 text-sm font-medium">
                        <p v-if="mobile_number_1">
                            <a :href="`tel:+91${mobile_number_1}`" class="inline-flex items-center gap-1.5 hover:text-amber-400 transition-colors">
                                📞 +91 {{ mobile_number_1 }}
                            </a>
                        </p>
                        <p v-if="mobile_number_2">
                            <a :href="`tel:+91${mobile_number_2}`" class="inline-flex items-center gap-1.5 hover:text-amber-400 transition-colors">
                                📞 +91 {{ mobile_number_2 }}
                            </a>
                        </p>
                        <p v-if="mobile_number_3">
                            <a :href="`tel:+91${mobile_number_3}`" class="inline-flex items-center gap-1.5 hover:text-amber-400 transition-colors">
                                📞 +91 {{ mobile_number_3 }}
                            </a>
                        </p>
                        <p v-if="mobile_number_4">
                            <a :href="`tel:+91${mobile_number_4}`" class="inline-flex items-center gap-1.5 hover:text-amber-400 transition-colors">
                                📞 +91 {{ mobile_number_4 }}
                            </a>
                        </p>
                        <p v-if="mobile_number_5">
                            <a :href="`tel:+91${mobile_number_5}`" class="inline-flex items-center gap-1.5 hover:text-amber-400 transition-colors">
                                📞 +91 {{ mobile_number_5 }}
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="mb-4 font-heading text-lg font-bold text-amber-400">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><Link href="/" class="hover:text-amber-300 hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.9)] transition-all">Home</Link></li>
                        <li><Link href="/about" class="hover:text-amber-300 hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.9)] transition-all">About Us</Link></li>
                        <li><Link href="/order-now" class="hover:text-amber-300 hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.9)] transition-all">OrderNow</Link></li>
                        <li><Link href="/safety-tips" class="hover:text-amber-300 hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.9)] transition-all">Safetytips</Link></li>
                        <li><Link href="/contact" class="hover:text-amber-300 hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.9)] transition-all">Contact</Link></li>
                        <li><Link href="/privacy-policy" class="hover:text-amber-300 hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.9)] transition-all">Privacy Policy</Link></li>
                    </ul>
                </div>

                <!-- Map -->
                <div>
                    <h4 class="mb-4 font-heading text-lg font-bold text-amber-400">Find Us</h4>
                    <div class="p-1 rounded-xl bg-gradient-to-r from-amber-400 to-red-500 shadow-lg">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d26472.295308145178!2d77.74708833362985!3d9.497399906356703!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s4%2F320%2C%20Sivakasi%20to%20kazhugumalai%20main%20road%2C%20Naduvappatti%2C%20627713!5e0!3m2!1sen!2sin!4v1789545389877!5m2!1sen!2sin"
                            class="h-48 w-full rounded-lg border-0"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bottom bar -->
        <div class="relative z-10 border-t border-blue-900/60 bg-[#02091f]/80 py-4 backdrop-blur-sm">
            <p class="text-center text-xs text-gray-300">
                &copy; {{ new Date().getFullYear() }} <span class="text-amber-400 font-semibold">Maniraj Crackers</span>. All rights reserved.
            </p>
        </div>
    </footer>
</template>