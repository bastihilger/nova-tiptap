<template>
    <teleport to="#modals">
        <div
            class="
                fixed top-0 left-0
                w-full h-full
                flex items-center justify-center
            " 
            style="z-index: 50"
            v-show="isActive"
        >
            <div 
                class="rounded-lg shadow-lg overflow-hidden"
                style="z-index: 20; width: 800px; max-width: 100%"
            >
                
                    <slot />

            </div>

            <div 
                class="
                    absolute top-0 left-0 w-full h-full
                    bg-black
                "
                style=" z-index: 10; opacity: 0.5"
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
