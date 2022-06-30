<template>
    <teleport to="#modals">
        <div
            class="
                fixed top-0 left-0
                w-full h-full
                z-50 flex items-center justify-center
            " 
            style="z-index: 999"
            v-show="isActive"
        >
            <div 
                class="rounded-lg shadow-lg overflow-hidden z-20"
                style="width: 800px; max-width: 100%"
            >
                
                    <slot />

            </div>

            <div 
                class="
                    z-10 absolute top-0 left-0 w-full h-full
                    bg-black
                "
                style="opacity: 0.5"
                @click="hideMethod"
            >
            </div>
        </div>
    </teleport>
</template>

<script>

export default {
    props: [
        'isActive',
        'hideMethod',
    ],
}
</script>
