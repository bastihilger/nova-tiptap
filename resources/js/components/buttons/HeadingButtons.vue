<template>
    <span>
        <button
            v-for="level in headingLevels"
            :key="'heading-button'+level"
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
            :class="{ 'btn-primary': editor ? editor.isActive('heading', { level: level }) : false }"
            @click="editor.chain().focus().toggleHeading({ level: level }).run()"
        >
          H{{  level  }}
        </button>
    </span>
</template>

<script>
export default {
    props: ['headingLevels', 'isActive', 'editor'],
}
</script>
