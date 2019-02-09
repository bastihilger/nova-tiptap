<template>
    <span>
        <button
            v-for="level in headingLevels"
            type="button"
            class="
                btn
                btn-default
                p-2
                leading-none
                text-xs
                min-w-8
                h-8
                tiptap-button
            "
            :class="{ 'btn-primary': isActive.heading({ level: level }) }"
            @click="commands.heading({ level: level })"
        >
          H{{  level  }}
        </button>
    </span>
</template>

<script>
export default {
    props: ['headingLevels', 'isActive', 'commands'],
}
</script>



